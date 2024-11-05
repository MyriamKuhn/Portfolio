<?php
// Configuration des paramètres des cookies de session
session_set_cookie_params([
  'lifetime' => 0, // expire à la fermeture du navigateur
  'path' => '/', 
  'domain' => $_SERVER['SERVER_NAME'], 
  //'secure' => true, 
  'httponly' => true, 
  'samesite' => 'Strict' 
]);

require __DIR__ . '/../vendor/autoload.php'; 

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Démarrage de la session
session_start();

try {
  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    throw new Exception('Méthode non autorisée.');
  } else {
    // Récupération des données du POST et nettoyage des entrées
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $recaptchaResponse = $_POST['g-recaptcha-response']; 
    $csrf_token = $_POST['csrf_token']; 
  
    // Vérification du jeton CSRF pour éviter les attaques CSRF
    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
      throw new Exception('Le jeton CSRF est invalide.');
    }
  
    // Vérification de la limitation de fréquence
    $limit_time = 10; // Limite d'envoi en secondes
    $ip_address = $_SERVER['REMOTE_ADDR']; // Obtenir l'adresse IP de l'utilisateur
  
    // Vérification de la limitation par session
    if (isset($_SESSION['last_submit_time'])) {
      $elapsed_time = time() - $_SESSION['last_submit_time'];
      if ($elapsed_time < $limit_time) {
        throw new Exception('Vous devez attendre avant de renvoyer un message.');
      }
    }
  
    // Vérification de la limitation par IP
    if (!isset($_SESSION['ip_limits'])) {
      $_SESSION['ip_limits'] = [];
    }
  
    // Vérification du dernier envoi pour cette IP
    if (isset($_SESSION['ip_limits'][$ip_address])) {
      $ip_elapsed_time = time() - $_SESSION['ip_limits'][$ip_address];
      if ($ip_elapsed_time < $limit_time) {
        throw new Exception('Vous devez attendre avant de renvoyer un message.');
      }
    } else {
      // Si l'IP n'a jamais envoyé de message, l'initialiser
      $_SESSION['ip_limits'][$ip_address] = time();
    }
  
    // Réinitialiser les limites après 1 heure (3600 secondes)
    foreach ($_SESSION['ip_limits'] as $ip => $timestamp) {
      if (time() - $timestamp > 3600) { // 1 heure
        unset($_SESSION['ip_limits'][$ip]); // Supprime l'entrée pour cette IP
      }
    }
  
    // Vérification si les champs sont vides
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !$email) {
      throw new Exception('Veuillez remplir tous les champs correctement.');
    }
  
    // Vérification du format de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Adresse email invalide.');
    }
  
    // Vérification du reCAPTCHA
    $recaptchaSecret = $_ENV['SITE_RECAPTCHA_SECRET']; 
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaResponseData = file_get_contents($recaptchaUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
      
    // Vérification de la réponse du reCAPTCHA
    if ($recaptchaResponseData === false) {
      throw new Exception('Erreur lors de la vérification du reCAPTCHA.');
    }
    
    $recaptchaData = json_decode($recaptchaResponseData, true);
  
    if (!$recaptchaData['success']) {
      throw new Exception('Échec de la vérification reCAPTCHA.');
    }
  
    // Utilisation de PHPMailer pour envoyer l'e-mail
    $mail = new PHPMailer(true);
    try {
      // Paramètres du serveur
      $mail->isSMTP();
      $mail->Host = $_ENV['MAILER_HOST'];
      $mail->SMTPAuth = true;
      $mail->Username = $_ENV['MAILER_EMAIL'];
      $mail->Password = $_ENV['MAILER_PASSWORD'];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = $_ENV['MAILER_PORT'];
  
      // Destinataire
      $mail->CharSet = 'UTF-8';
      $mail->setFrom($_ENV['MAILER_EMAIL'], 'Myriam Kühn'); 
      $mail->addAddress('contact@myriamkuhn.com'); // Adresse où envoyer le message
  
      // Ajout d'en-têtes sécurisés
      $mail->addReplyTo($email, $name); // Répondre à l'adresse de l'expéditeur
      $mail->addCustomHeader('X-Mailer', 'PHP/' . phpversion());
      $mail->addCustomHeader('X-Priority', '1'); // Haute priorité
  
      // Contenu
      $mail->isHTML(true); // Définir le format de l'e-mail en HTML
      $mail->Subject = "[Demande de contact] - " . html_entity_decode($subject); // Sujet de l'e-mail avec décodage HTML pour les caractères spéciaux
      $mail->Body = "Nom : " . $name . "<br>Email : " . $email . "<br>Message : " . nl2br($message); // Corps de l'e-mail avec saut de ligne HTML
  
      // Envoyer l'e-mail
      $mail->send();
  
      // Enregistrement du temps de soumission
      $_SESSION['last_submit_time'] = time();
      $_SESSION['ip_limits'][$ip_address] = time(); // Enregistrement du dernier envoi par IP
  
      // Message de succès pour l'utilisateur
      $_SESSION['form_message'] = ['type' => 'success', 'text' => 'Votre message a été envoyé avec succès.'];
  
    } catch (Exception $e) {
      $_SESSION['form_message'] = ['type' => 'error', 'text' => 'Erreur lors de l\'envoi du message : ' . $mail->ErrorInfo];
    }
  
    // Redirection vers l'index après le traitement de la requête
    header("Location: /index.php");
    exit;
  } 
} catch (Exception $e) {
  $_SESSION['form_message'] = ['type' => 'error', 'text' => 'Erreur lors de l\'envoi du message : ' . $e->getMessage()];
  header("Location: /index.php");
  exit;
}
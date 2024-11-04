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

// Démarrage de la session
session_start();

// Vérification de l'existence du jeton CSRF dans la session et génération d'un nouveau jeton si nécessaire
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Vérification si il s'agit d'une redirection venant du formulaire de contact pour afficher le message de confirmation
if (isset($_SESSION['form_message'])) {
  setcookie('form_message', 'response is sended', time() + 60, '/');
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/assets/img/logo_mimi.svg" type="image/svg+xml">
    <!-- Balises Meta -->
    <title>Portfolio de Myriam Kühn | Développeuse</title>
    <meta name="description" content="Découvrez le portfolio de Myriam Kühn, développeuse web spécialisée dans la création de sites modernes et interactifs." />
    <meta name="keywords" content="portfolio, Myriam Kühn, développeuse web, sites web, compétences, réalisations, contact" />
    <!-- Balises Open Graph  -->
    <meta property="og:title" content="Portfolio de Myriam Kühn | Développeuse" />
    <meta property="og:description" content="Découvrez le portfolio de Myriam Kühn, développeuse web spécialisée dans la création de sites modernes et interactifs." />
    <meta property="og:image" content="/assets/img/logo_mimi.svg" />
    <!-- CSS et fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="/assets/css/main.min.css" />
  </head>

  <!-- START : Body -->
  <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true" class="bg-light text-dark">

    <!-- START : Header -->
    <header>
      <nav id="navbar" class="navbar navbar-expand-lg position-fixed w-100 navbar-light bg-light" role="navigation" data-translate-aria="nav">
        <div class="container-fluid">
          <a class="navbar-brand text-uppercase fw-medium text-primary" id="brand" href="#">
            <span data-key="brand"></span>
          </a>
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" data-translate-aria="toggle">
            <i class="bi bi-code-square fs-1 text-primary" aria-hidden="true" id="logoToggler"></i>
            <span class="visually-hidden">Menu</span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-2">
              <li class="nav-item">
                <a class="nav-link text-uppercase" aria-current="page" href="#hero" data-key="home">Accueil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase" href="#about" data-key="about">Qui suis-je ?</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase" href="#competences" data-key="skills">Compétences</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase" href="#competences-adds" data-key="skillAdds">Compétences complémentaires</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase" href="#realisations" data-key="projects">Réalisations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-uppercase" href="#contact" data-key="contact">Contact</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- END : Header -->

    <!-- START : Main -->
    <main class="main-content-website">
      
      <!-- HERO -->
      <section id="hero" aria-labelledby="hero-title">
        <div class="container-fluid">
          <div class="row row-cols-1 hero">
            <div class="d-flex justify-content-center flex-column align-items-center text-center hero-presentation">
              <h1 id="hero-title" class="hero-name text-uppercase fw-medium text-primary">Myriam Kühn</h1>
              <p class="hero-description m-0 text-center" data-key="heroDesc1">
                Je suis une développeuse web full-stack et développeuse d'applications spécialisée dans la  jeu vidéo mais ce n'est pas pour autant que je ne suis pas capable de réaliser des sites web ou des applications modernes et interactifs.
              </p>
              <p class="hero-description text-center mt-2" data-key="heroDesc2">
                Venez découvrir mon portfolio !
              </p>
              <a href="/assets/docs/cv_myriamkuehn.pdf" target="_blank" class="btn btn-primary text-uppercase fw-medium mt-5 text-light" data-translate-aria="download" data-key="downloadBtn">Télécharger mon CV</a>
              <a href="#about" class="hero-btn" data-translate-aria="nextSection"><i class="bi bi-arrow-down-short"></i></a>
            </div>
          </div>
        </div>
      </section>

      <!-- QUI SUIS-JE ? -->
      <section class="py-5" id="about">
        <div class="container">
          <div class="row row-cols-1 row-cols-md-2 align-items-center mb-5 pt-5 pb-5">
            <div>
              <img class="about-img" src="/assets/img/img_moi.png" data-translate-alt="aboutImg">
            </div>
            <div class="pt-2 pb-2">
              <h2 data-key="about">Qui suis-je ?</h2>
              <p data-key="aboutDesc1">Bonjour, je suis Myriam Kühn !</p>
              <p data-key="aboutDesc2">
                Depuis toujours passionnée par les technologies, j'ai débuté par un Bac Scientifique en Technologie Industrielle avant d'explorer divers chemins professionnels. Il y a 15 ans, j'ai intégré l'univers du jeu vidéo en tant que Community Manager et Social Media Manager, ce qui m'a permis de travailler aux côtés de développeurs et de graphistes. Cette collaboration m'a donné envie de créer mon propre jeu vidéo, que j'ai commencé à développer en autodidacte sur Unreal Engine 5.3.
              </p>
              <p data-key="aboutDesc3">
                Après une période difficile marquée par la perte de mon emploi dans une startup, j'ai entrepris une formation en développement, renforçant mes compétences en web et en applications. Mon expérience chez IONOS en support technique m'a aussi préparée aux défis du déploiement.
              </p>
              <p data-key="aboutDesc4">
                Aujourd'hui, je suis prête à relever de nouveaux défis en tant que développeuse web full-stack et développeuse d'applications. Je suis convaincue que ma polyvalence et ma passion pour les nouvelles technologies me permettront de mener à bien tous les projets qui me seront confiés.
              </p>
              <div class="d-flex justify-content-center align-items-center">
                <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://github.com/MyriamKuhn" target="_blank" data-translate-aria="github">
                  <i class="bi bi-github"></i>
                </a>
                <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://www.linkedin.com/in/myriam-k%C3%BChn/" target="_blank" data-translate-aria="linkedin">
                  <i class="bi bi-linkedin"></i>
                </a>
                <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://www.facebook.com/myriam.kuhn.9" target="_blank" data-translate-aria="facebook">
                  <i class="bi bi-facebook"></i>
                </a>
                <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://x.com/mimkuhn" target="_blank" data-translate-aria="twitter">
                  <i class="bi bi-twitter-x"></i>
                </a>
                <a class="btn btn-outline-primary align-content-center align-self-center" href="https://www.instagram.com/myriam_kuhn82/" target="_blank" data-translate-aria="instagram">
                  <i class="bi bi-instagram"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- MES COMPETENCES -->
      <section class="py-5" id="competences">
        <div class="container">
          <div class="row text-center mt-5 mb-5 justify-content-center">
            <h2 data-key="competencesTitle">Mes compétences</h2>
            <p data-key="competencesDesc">
              Avec un bagage technique solide et une soif d'apprendre, je suis prête à relever les défis du développement moderne.
            </p>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4 competences-card">
              <!-- HTML -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/html5.svg" class="mx-auto my-3" data-translate-alt="htmlImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">HTML5</h5>
                    <p class="card-text" data-key="htmlDesc">
                      Maîtrise des éléments sémantiques et des API modernes, permettant de créer des pages web accessibles et interactives.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                  </div>
                </div>
              </div>
              <!-- CSS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/css3.svg" class="mx-auto my-3" data-translate-alt="cssImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">CSS3</h5>
                    <p class="card-text" data-key="cssDesc">
                      Expertise dans la création de designs responsives et adaptatifs grâce à CSS3, en utilisant des propriétés avancées, des transitions et des animations pour enrichir l'expérience utilisateur. Maîtrise des préprocesseurs comme SASS pour structurer le code CSS de manière modulaire, garantissant ainsi une gestion efficace des styles.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- SASS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/sass.svg" class="mx-auto my-3" data-translate-alt="sassImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Sass</h5>
                    <p class="card-text" data-key="sassDesc">
                      Utilisation de SASS pour structurer et organiser le code CSS de manière modulaire, facilitant la maintenance et l'évolutivité.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- JS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/js.png" class="mx-auto my-3" data-translate-alt="jsImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">JavaScript</h5>
                    <p class="card-text" data-key="javascriptDesc">
                      Solide compréhension des concepts fondamentaux de JavaScript, y compris les fonctions, les objets et les tableaux, permettant de créer des applications web interactives. Capacité à manipuler le DOM et à gérer les événements utilisateur, tout en intégrant des opérations asynchrones et des API RESTful pour enrichir les fonctionnalités des applications.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- BOOTSTRAP -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/bootstrap.svg" class="mx-auto my-3" data-translate-alt="bootstrapImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Bootstrap 5.3</h5>
                    <p class="card-text" data-key="bootstrapDesc">
                      Expertise dans l'utilisation de Bootstrap pour créer des interfaces utilisateur réactives et modernes. Capacité à tirer parti des composants et des utilitaires de Bootstrap pour accélérer le développement tout en assurant une expérience utilisateur cohérente sur tous les appareils.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- THREE.JS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/threejs.svg" class="mx-auto my-3" data-translate-alt="threejsImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Three.js</h5>
                    <p class="card-text" data-key="threejsDesc">
                      Maîtrise de Three.js pour créer des expériences 3D interactives et immersives sur le web. Capacité à modéliser des environnements 3D, à intégrer des animations et à optimiser les performances pour des rendus fluides.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- PHASER -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/phaser.png" class="mx-auto my-3" data-translate-alt="phaserImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">PHASER</h5>
                    <p class="card-text" data-key="phaserDesc">
                      Expertise dans l'utilisation de Phaser pour développer des jeux 2D dynamiques et engageants. Capacité à intégrer des mécaniques de jeu, des animations fluides et des interactions utilisateur, tout en optimisant les performances pour une expérience de jeu fluide.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- PHP -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/php.svg" class="mx-auto my-3" data-translate-alt="phpImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">PHP</h5>
                    <p class="card-text" data-key="phpDesc">
                      Maîtrise de PHP pour le développement d'applications web dynamiques et évolutives. Capacité à créer des systèmes robustes, à intégrer et développer des API RESTful, à gérer les sessions utilisateur, et à assurer la sécurité des données, tout en appliquant les meilleures pratiques du secteur.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- SQL -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/mysql.svg" class="mx-auto my-3" data-translate-alt="mysqlImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">MySQL</h5>
                    <p class="card-text" data-key="mysqlDesc">
                      Compétence dans l'utilisation de MySQL pour la gestion et l'interrogation de bases de données relationnelles. Capacité à concevoir des schémas de données, à optimiser les requêtes et à assurer l'intégrité des données, tout en mettant en œuvre des pratiques de sécurité adaptées.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- MongoDB -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/mongodb.svg" class="mx-auto my-3" data-translate-alt="mongodbImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Mongo DB</h5>
                    <p class="card-text" data-key="mongodbDesc">
                      Expertise dans l'utilisation de MongoDB pour le développement d'applications basées sur des bases de données NoSQL. Capacité à concevoir des schémas flexibles, à effectuer des requêtes complexes et à gérer des ensembles de données volumineux, tout en garantissant la performance et la scalabilité des applications.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- WORDPRESS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/wordpress.svg" class="mx-auto my-3" data-translate-alt="wordpressImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">WordPress</h5>
                    <p class="card-text" data-key="wordpressDesc">
                      Maîtrise de WordPress pour la création et la gestion de sites web dynamiques et personnalisables. Capacité à développer des thèmes et des plugins sur mesure, à optimiser les performances SEO et à garantir une expérience utilisateur fluide et engageante.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- UE5 -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/ue5.svg" class="mx-auto my-3" data-translate-alt="ueImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Unreal Engine 5</h5>
                    <p class="card-text" data-key="ueDesc">
                      Expertise dans l'utilisation d'Unreal Engine 5 pour le développement de jeux vidéo haut de gamme et d'expériences interactives. Capacité à tirer parti des fonctionnalités avancées telles que le rendu en temps réel, le système de particules et le Blueprint Visual Scripting pour créer des environnements immersifs et des mécaniques de jeu captivantes.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- DISPO -->
      <section class="py-5 text-center" id="available">
        <div class="py-3">
          <h2 class="pb-3" data-key="availableTitle">Je suis disponible</h2>
          <p data-key="availableDesc1">
            Je suis actuellement disponible pour des opportunités d'embauche en entreprise ainsi que pour des missions freelance.
          </p>
          <p data-key="availableDesc2">
            N'hésitez pas à me contacter pour discuter de vos besoins en développement.
          </p>
          <a class="btn btn-primary text-uppercase fw-medium mt-5 text-light" href="#contact" data-key="contactTitle">Me contacter</a>
        </div>
      </section>

      <!-- COMPETENCES COMPLEMENTAIRES -->
      <section class="py-5" id="competences-adds">
        <div class="container">
          <div class="row text-center mt-5 mb-5 justify-content-center">
            <h2 data-key="competencesAddsTitle">Mes compétences complémentaires</h2>
            <p data-key="competencesAddsDesc">
              En plus de mes compétences techniques, je maîtrise divers outils et logiciels qui enrichissent mes projets et facilitent la collaboration.
            </p>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 mt-4 competences-card">
              <!-- GIT -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/git.svg" class="mx-auto my-3" data-translate-alt="gitImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Git</h5>
                    <p class="card-text" data-key="gitDesc">
                      Compétence dans l'utilisation de Git pour le contrôle de version, permettant de gérer les modifications de code de manière collaborative et efficace. Expérience avec des plateformes telles que GitHub pour le partage de projets.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- TRELLO -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/trello.svg" class="mx-auto my-3" data-translate-alt="trelloImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Trello</h5>
                    <p class="card-text" data-key="trelloDesc">
                      Utilisation de Trello pour la gestion de projets, permettant une organisation visuelle des tâches et une collaboration efficace au sein d'une équipe.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                  </div>
                </div>
              </div>
              <!-- JIRA -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/jira.png" class="mx-auto my-3" data-translate-alt="jiraImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Jira</h5>
                    <p class="card-text" data-key="jiraDesc">
                      Expérience dans l'utilisation de Jira pour le suivi des tickets et la gestion agile de projets, facilitant la communication et le suivi des progrès.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- FIGMA -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/figma.svg" class="mx-auto my-3" data-translate-alt="figmaImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Figma</h5>
                    <p class="card-text" data-key="figmaDesc">
                      Compétence dans Figma pour la conception d'interfaces utilisateur, permettant de créer des prototypes interactifs et des designs collaboratifs.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- PHOTOSHOP -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/ps.svg" class="mx-auto my-3" data-translate-alt="photoshopImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Photoshop</h5>
                    <p class="card-text" data-key="photoshopDesc">
                      Compétence avancée en retouche photo, création de compositions graphiques et manipulation d'images pour des visuels percutants.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- ILLUSTRATOR -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/illustrator.svg" class="mx-auto my-3" data-translate-alt="illustratorImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Illustrator</h5>
                    <p class="card-text" data-key="illustratorDesc">
                      Maîtrise de la création de graphiques vectoriels, de logos et d'illustrations personnalisées, permettant une grande flexibilité de design.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- INDESIGN -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/indesign.svg" class="mx-auto my-3" data-translate-alt="indesignImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">InDesign</h5>
                    <p class="card-text" data-key="indesignDesc">
                      Utilisation d'InDesign pour la mise en page de documents imprimés et numériques, assurant une présentation professionnelle et cohérente.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- PREMIERE PRO -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/pp.svg" class="mx-auto my-3" data-translate-alt="ppImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Premiere Pro</h5>
                    <p class="card-text" data-key="ppDesc">
                      Compétence dans le montage vidéo et la création de contenus audiovisuels dynamiques, en utilisant des techniques avancées de montage.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- AFTER EFFECTS -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/ae.svg" class="mx-auto my-3" data-translate-alt="aeImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">After Effects</h5>
                    <p class="card-text" data-key="aeDesc">
                      Maîtrise de l'animation et des effets spéciaux pour la création de vidéos engageantes et de présentations dynamiques.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- BLENDER -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/blender.svg" class="mx-auto my-3" data-translate-alt="blenderImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Blender</h5>
                    <p class="card-text" data-key="blenderDesc">
                      Compétence dans la modélisation 3D et l'animation, permettant de créer des rendus réalistes et des projets interactifs.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- WORD -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/word.svg" class="mx-auto my-3" data-translate-alt="wordImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Microsoft Word</h5>
                    <p class="card-text" data-key="wordDesc">
                      Compétence dans la rédaction et la mise en forme de documents professionnels, facilitant la communication écrite et la documentation.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- EXCEL -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/excel.svg" class="mx-auto my-3" data-translate-alt="excelImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Microsoft Excel</h5>
                    <p class="card-text" data-key="excelDesc">
                      Maîtrise des outils d'analyse de données, des formules avancées et des graphiques, permettant une gestion efficace des informations.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
              <!-- POWERPOINT -->
              <div class="p-3">
                <div class="card bg-transparent text-dark border-secondary h-100" role="article">
                  <img src="/assets/img/powerp.svg" class="mx-auto my-3" data-translate-alt="powerpImg"/>
                  <div class="card-body d-flex flex-column justify-content-center">
                    <h5 class="card-title">Microsoft PowerPoint</h5>
                    <p class="card-text" data-key="powerpDesc">
                      Compétence dans la création de présentations visuelles impactantes, en utilisant des mises en page efficaces et des éléments graphiques.
                    </p>
                  </div>
                  <div class="card-footer bg-transparent border-secondary text-secondary">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <i class="bi bi-star"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- MES REALISATIONS -->
      <section class="py-5 text-center" id="realisations">
        <div class="container py-3">
          <h2 class="pb-3" data-key="realisationTitle">Mes réalisations</h2>
          <p data-key="realisationsDesc">Découvrez ici un aperçu de mes projets et réalisations graphiques, illustrant mon parcours créatif et mes compétences en développement et design.</p>
          <div id="carousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true" role="region" aria-live="polite">
            <div class="carousel-indicators mb-0">
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="/assets/img/realisations/gamestore.png" class="w-50" data-translate-alt="gamestoreImg">
                  <div class="py-3">
                    <a href="https://gamestore.mkcodecreations.dev/" target="_blank" class="text-uppercase fw-medium" data-translate-aria="gamestoreLabel">Gamestore</a>
                    <p data-key="realisations1">Projet de formation (HTML/CSS/SASS/JS/Bootstrap/PHP/MySQL/MongoDB)</p>
                  </div>
              </div>
              <div class="carousel-item">
                <img src="/assets/img/realisations/lunarplay.png" class="w-50" data-translate-alt="lunarplayImg">
                  <div class="py-3">
                    <a href="https://lunarplay-system.mkcodecreations.dev/" target="_blank" class="text-uppercase fw-medium" data-translate-aria="lunarplayLabel">LunarPlay System</a>
                    <p data-key="realisations2">Projet personnel - Site de mini-jeux avec classement (HTML/CSS/JS/Three.js/PHASER/PHP/MongoDB)</p>
                  </div>
              </div>
              <div class="carousel-item">
                <img src="/assets/img/realisations/portfolio.png" class="w-50" data-translate-alt="portfolioImg">
                  <div class="py-3">
                    <a href="https://myriamkuhn.com" target="_blank" class="text-uppercase fw-medium" data-translate-aria="portfolioLabel">Mon portfolio</a>
                    <p data-key="realisations3">Le site sur lequel vous vous trouvez actuellement (HTML/CSS/SASS/JS/Bootstrap/PHP)</p>
                  </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
              <span class="bi bi-chevron-left text-primary fs-1" aria-hidden="true"></span>
              <span class="visually-hidden" data-key="previous">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
              <span class="bi bi-chevron-right text-primary fs-1" aria-hidden="true"></span>
              <span class="visually-hidden" data-key="next">Suivant</span>
            </button>
          </div>
        </div>
      </section>

      <!-- CONTACT -->
      <section class="py-5 text-center" id="contact">
        <div class="container py-5">
          <h2 data-key="contactTitle" class="pb-3">Me contacter</h2>
          <p data-key="contactDesc">
            N'hésitez pas à me contacter pour toute question, collaboration ou simplement pour échanger autour de nos passions créatives et digitales.
          </p>
          <div class="row row-cols-1 row-cols-md-3 px-3">
            <div class="contact-container">
              <div class="contact-header">
                <i class="bi bi-telephone-fill text-primary mb-1"></i>
                <h3 class="fw-medium" data-key="contactCall">Appelez-moi</h3>
              </div>
              <div class="contact-body">
                <a class="fw-medium" href="tel:+33682499706">+33 6 82 49 97 06</a>
              </div>
            </div>
            <div class="contact-container">
              <div class="contact-header">
                <i class="bi bi-envelope-fill text-primary mb-1"></i>
                <h3 class="fw-medium" data-key="contactMail">EMail</h3>
              </div>
              <div class="contact-body">
                <a class="text-uppercase fw-medium" href="mailto:contact@myriamkuhn.com?subject=Je vous contacte depuis votre site">contact@myriamkuhn.com</a>
              </div>
            </div>
            <div class="contact-container">
              <div class="contact-header">
                <i class="bi bi-house-fill text-primary mb-1"></i>
                <h3 class="fw-medium" data-key="contactHome">Chez moi</h3>
              </div>
              <div class="contact-body">
                <a class="text-uppercase fw-medium" href="https://fr.mappy.com/plan/57230-bitche">57230 Bitche, FRANCE</a>
              </div>
            </div>
          </div>
          <h3 class="mt-5" data-key="contactSendMe">Envoyez-moi un message</h3>
          <p class="mb-5" data-key="contactAnswer">Je vous répondrai dans les plus brefs délais.</p>
          <?php 
            if (isset($_SESSION['form_message'])):
              $message = $_SESSION['form_message'];
              if ($alertType = $message['type'] === 'success'): ?>
                <div class="alert alert-success" role="alert" id="successMessage" data-key="successMessage">
                  Votre message a bien été envoyé. Merci !
                </div>
              <?php else: ?>
                <div class="alert alert-danger" role="alert" id="errorMessage" data-key="errorMessage">
                  Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer.
                </div>
              <?php endif;
              unset($_SESSION['form_message']);
            endif ?>
          <form id="contactForm" action="/App/sendContact.php" method="post" class="needs-validation" novalidate>
          <input type="hidden" id="csrf_token" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="input-group mb-3">
              <label for="name" class="input-group-text" data-key="contactName">Nom</label>
              <input type="text" class="form-control" id="name" name="name" required aria-describedby="nameFeedback" minlength="3" maxlength="100">
              <div id="nameFeedback" class="invalid-feedback" aria-live="assertive" data-key="errorName">
                Entrez un nom valide.
              </div>        
            </div>
            <div class="input-group mb-3">
              <label for="email" class="input-group-text" data-key="contactMail">Email</label>
              <input type="email" class="form-control" id="email" name="email" required aria-describedby="emailFeedback">
              <div id="emailFeedback" class="invalid-feedback" aria-live="assertive" data-key="errorMail">
                Entrez une adresse mail valide.
              </div> 
            </div>
            <div class="input-group mb-3">
              <label for="subject" class="input-group-text" data-key="contactSubject">Objet</label>
              <input type="text" class="form-control" id="subject" name="subject" required aria-describedby="subjectFeedback" minlength="10" maxlength="200">
              <div id="subjectFeedback" class="invalid-feedback" aria-live="assertive" data-key="errorSubject">
                Entrez un objet valide.
              </div> 
            </div>
            <div class="input-group mb-3">
              <label for="message" class="input-group-text" data-key="contactMessage">Message</label>
              <textarea class="form-control" id="message" name="message" required rows="5" aria-describedby="messageFeedback" minlength="50"></textarea>
              <div id="messageFeedback" class="invalid-feedback" aria-live="assertive" data-key="errorMessage">
                Entrez un message valide.
              </div> 
            </div>
            <button type="submit" class="btn btn-primary text-uppercase fw-medium g-recaptcha" data-sitekey="<?= $_ENV['SITE_RECAPTCHA_KEY'] ?>" data-callback='onSubmit' data-key="contactSend">Envoyer</button>
          </form>
        </div>
      </section>

      <!-- Back To Top -->
      <button class="btn btn-outline-primary scroll-top" id="scrollTopButton" data-translate-aria="scroll">
        <i class="bi bi-chevron-up"></i>
      </button>

      <!-- Ajout du sélecteur de langue -->
      <div id="language-selector">
        <div class="language-picker d-flex flex-column align-items-center">
          <button id="fr-button" class="btn btn-outline-primary d-flex justify-content-center align-items-center mb-2 fw-medium" aria-label="Changer la langue en Français">FR</button>
          <button id="en-button" class="btn btn-outline-primary d-flex justify-content-center align-items-center mb-2 fw-medium" aria-label="Change language to English">EN</button>
          <button id="de-button" class="btn btn-outline-primary d-flex justify-content-center align-items-center fw-medium" aria-label="Sprache in Deutsch ändern">DE</button>
        </div>
        <div class="setting-button">
          <button class="btn btn-outline-primary" id="showPanelButton" aria-controls="settingsPanel" aria-expanded="false" data-translate-aria="languages">
            <i class="bi bi-gear-fill"></i>
          </button>
        </div>
      </div>

    </main>
    <!-- END : Main -->

    <!-- START : Footer -->
    <footer class="text-center py-4 bg-light">
      <div class="my-3">
        <nav aria-label="Liens vers les réseaux sociaux" class="d-flex justify-content-center align-items-center">
          <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://github.com/MyriamKuhn" target="_blank" data-translate-aria="github">
            <i class="bi bi-github"></i>
          </a>
          <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://www.linkedin.com/in/myriam-k%C3%BChn/" target="_blank" data-translate-aria="linkedin">
            <i class="bi bi-linkedin"></i>
          </a>
          <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://www.facebook.com/myriam.kuhn.9" target="_blank" data-translate-aria="facebook">
            <i class="bi bi-facebook"></i>
          </a>
          <a class="me-2 btn btn-outline-primary align-content-center align-self-center" href="https://x.com/mimkuhn" target="_blank" data-translate-aria="twitter">
            <i class="bi bi-twitter-x"></i>
          </a>
          <a class="btn btn-outline-primary align-content-center align-self-center" href="https://www.instagram.com/myriam_kuhn82/" target="_blank" data-translate-aria="instagram">
            <i class="bi bi-instagram"></i>
          </a>
        </nav>
      </div>
      <div class="text-center" data-key="footer">
        ©2024 Myrian Kühn - Tous droits réservés
      </div>
      <a href="" class="text-uppercase fw-medium" data-bs-toggle="modal" data-bs-target="#legalModal" data-key="legal">Mentions légales</a>
    </footer>
    <!-- END : Footer -->

    <!-- START : Modal legal -->
    <div class="modal fade" id="legalModal" tabindex="-1" aria-labelledby="legalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="dialog" aria-modal="true">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="legalTitle" data-key="legalTitle">Mentions légales</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" data-translate-aria="close"></button>
          </div>
          <div class="modal-body">
            <h3 data-key="legalResponisble">Responsable de publication</h3>
            <ul class="list-unstyled">
              <li>Myriam Kühn</li>
              <li><a href="mailto:contact@myriamkuhn.com" data-translate-aria="sendEmail">contact@myriamkuhn.com</a></li>
            </ul>
            <h3 data-key="legalPublisher">Hébergeur</h3>
            <ul class="list-unstyled">
              <li>IONOS SARL</li>
              <li>7, place de la Gare - BP 70109 - 57200 Sarreguemines Cedex (France)</li>
              <li><a href="https://www.ionos.fr/" target="_blank" data-translate-aria="openUrl">https://www.ionos.fr/</a></li>
            </ul>
            <h3 data-key="legalIntel">Propriété intellectuelle</h3>
            <p data-key="legalIntelDesc">Tous les éléments présents sur ce site (textes, images, logos, etc.) sont la propriété exclusive de Myriam Kühn, sauf mention contraire. Toute reproduction, distribution, modification ou utilisation de ces éléments sans autorisation préalable est interdite.</p>
            <h3 data-key="legalPrivate">Données personnelles</h3>
            <p data-key="legalPrivateDesc">Dans le cadre de l'utilisation du formulaire de contact, certaines informations personnelles sont collectées, notamment l'adresse e-mail et l'adresse IP des utilisateurs. Ces données sont recueillies dans le but de permettre le traitement des messages envoyés et de répondre aux sollicitations.</p>
            <ul>
              <li data-key="legalPrivateDesc1">Utilisation de reCAPTCHA : Ce site utilise reCAPTCHA pour protéger le formulaire de contact contre les abus. reCAPTCHA est un service fourni par Google, et son utilisation est soumise aux Conditions d'utilisation de Google et à leur Politique de confidentialité.</li>
              <li data-key="legalPrivateDesc2">Finalité des données collectées : Les données recueillies via le formulaire de contact sont utilisées uniquement pour le traitement des demandes d'information ou de contact et ne sont en aucun cas cédées à des tiers à des fins commerciales.</li>
              <li data-key="legalPrivateDesc3">Conservation des données : Les données collectées via le formulaire de contact sont conservées pendant une durée de 3 ans à compter de la réception du message, puis supprimées.</li>
              <li data-key="legalPrivateDesc4">Droits des utilisateurs : Conformément à la loi "Informatique et Libertés" du 6 janvier 1978 modifiée et au Règlement Général sur la Protection des Données (RGPD) du 27 avril 2016, les utilisateurs disposent d'un droit d'accès, de rectification, de suppression et d'opposition aux données les concernant. Pour exercer ces droits, il suffit de contacter le responsable de publication par e-mail à l'adresse indiquée ci-dessus.</li>
              <li data-key="legalPrivateDesc5">Recours : Si vous estimez que vos droits ne sont pas respectés, vous pouvez adresser une réclamation à l'autorité de protection des données de votre pays (en France, la CNIL).</li>
            </ul>
            <h3>Cookies</h3>
            <p data-key="legalCookiesDesc1">Ce site utilise des cookies pour améliorer l'expérience utilisateur et analyser le trafic. Les cookies sont des fichiers stockés sur le navigateur de l'utilisateur et permettent de reconnaître son terminal lorsqu'il revient sur le site. Ils sont utilisés pour mémoriser les préférences de l'utilisateur, mesurer l'audience du site et proposer des contenus personnalisés. Ils permettent le bon fonctionnement site, notamment en lien avec reCAPTCHA.</p>
            <p data-key="legalCookiesDesc2">Les utilisateurs peuvent désactiver les cookies en modifiant les paramètres de leur navigateur. Cependant, certaines fonctionnalités du site peuvent ne pas fonctionner correctement en cas de désactivation des cookies.</p>
            <h3 data-key="legalExtLinks">Liens externes</h3>
            <p data-key="legalExtLinksDesc">Ce site contient des liens vers des sites externes. Myriam Kühn n'est pas responsable du contenu de ces sites ni des éventuels dommages causés par leur utilisation. Les utilisateurs sont invités à consulter les politiques de confidentialité et de sécurité des sites tiers avant de les visiter.</p>
            <h3 data-key="legalUpdate">Modification des mentions légales</h3>
            <p data-key="legalUpdateDesc">Myriam Kühn se réserve le droit de modifier les présentes mentions légales à tout moment et sans préavis. Il est recommandé aux utilisateurs de consulter régulièrement cette page pour prendre connaissance des éventuelles modifications.</p>
            <h3 data-key="legalLimit">Limitation de responsabilité</h3>
            <p data-key="legalLimitDesc">Ce site est mis à jour régulièrement, mais des erreurs ou des omissions peuvent subsister. Myriam Kühn ne saurait être tenue responsable des dommages directs ou indirects résultant de l'utilisation du site.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-uppercase fw-medium" data-bs-dismiss="modal" data-translate-aria="close" data-key="legalClose">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- END : Modal legal -->


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/assets/js/main.js"></script>
  </body>
</html>

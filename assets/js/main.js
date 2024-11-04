/***********/

/* IMPORTS */

/***********/
import { translations } from '/assets/js/translations.js';


/*********************/

/* APPARITION SCROLL */

/*********************/
const scrollTopButton = document.getElementById("scrollTopButton");
const hero = document.getElementById("hero");

// Création d'un observateur pour la gestion de l'apparition et de la disparition d'une section à l'écran
const observer = new IntersectionObserver((entries) => {
	entries.forEach((entry) => {
		if (entry.isIntersecting) {
			// la section est de nouveau visible sur l'écran
			scrollTopButton.classList.remove("showing"); 
		} else {
			// la section a quitté l'écran
			scrollTopButton.classList.add("showing"); 
		}
	});
}, { threshold: 0 }); // l'observation est déclenchée dès qu'une petite portion de l'élément entre ou sort de l'écran

// Observation de la section hero pour afficher ou masquer le bouton de retour en haut
observer.observe(hero);

// Nettoyer l'observateur pour éviter les fuites de mémoire
window.addEventListener('unload', () => {
	observer.disconnect();
});


/******************/

/* GESTION SCROLL */

/******************/
scrollTopButton.onclick = function () {
	window.scrollTo({ top: 0, behavior: "smooth" })
};


/****************************/

/* AU CHARGEMENT DE LA PAGE */

/****************************/
document.addEventListener('DOMContentLoaded', () => {
	let lang;
	const supportedLangs = ['en', 'fr', 'de'];

	// Récupère le chemin de l'URL
	const path = window.location.pathname; 
	if (path.startsWith('/en')) {
		lang = 'en'; 
	} else if (path.startsWith('/fr')) {
		lang = 'fr'; 
	} else if (path.startsWith('/de')) {
		lang = 'de';
	} else {
		const userLang = navigator.language || navigator.userLanguage;
		lang = userLang.startsWith('fr') ? 'fr' : userLang.startsWith('de') ? 'de' : 'en';
	}

	// Vérifie si une langue est déjà sauvegardée et valide
	const savedLang = localStorage.getItem('language');
	lang = supportedLangs.includes(savedLang) ? savedLang : lang;

	changeLanguage(lang);

	// Gestion des boutons de changement de langue
	document.getElementById('fr-button').addEventListener('click', () => updateLanguage('fr'));
	document.getElementById('en-button').addEventListener('click', () => updateLanguage('en'));
	document.getElementById('de-button').addEventListener('click', () => updateLanguage('de'));

	// Création des liens de traduction pour le SEO
	const baseDomain = window.location.origin;
	addLanguageLinks(baseDomain);

	/**
	 * @param {string} name - Le nom du cookie
	 * @returns {string} La valeur du cookie
	 * 
	 * @description Récupère la valeur d'un cookie
	 */
	function getCookie(name) {
		const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) return parts.pop().split(';').shift();
	}

	// Vérifie si un message de formulaire est présent dans les cookie, scroll jusqu'à la section contact et supprime le cookie
	const formMessage = getCookie('form_message');
	if (formMessage) {
		const contactSection = document.getElementById('contact');
    if (contactSection) {
      contactSection.scrollIntoView({ behavior: 'smooth' });
    }
		document.cookie = "form_message=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	}
});


/******************/

/* GESTION LANGUE */

/******************/
/**
 * @param {string} lang - La langue à mettre à jour
 * @returns {void}
 * 
 * @description Met à jour la langue de la page et sauvegarde la langue dans le stockage local
 */
function updateLanguage(lang) {
	// Mise à jour de la langue si elle est valide
	if (['en', 'fr', 'de'].includes(lang)) {
		localStorage.setItem('language', lang);
		changeLanguage(lang);
	}
}

/**
 * @param {string} lang - La langue à changer
 * @returns {void}
 * 
 * @description Met à jour le texte, les attributs aria-label, la langue de la page, le titre de la page, la description et les mots-clés de la méta-description, l'URL, le style des boutons
 */
function changeLanguage(lang) {
	// Mise à jour de la langue de la page et des méta-données pour le SEO
	document.querySelector('html').setAttribute('lang', lang);
	document.title = translations[lang]?.pageTitle || '';
	document.querySelector('meta[name="description"]').setAttribute("content", translations[lang]?.metaDescription || '');
	document.querySelector('meta[name="keywords"]').setAttribute("content", translations[lang]?.metaKeywords || '');
	document.querySelector('meta[property="og:title"]').setAttribute("content", translations[lang]?.pageTitle || '');
	document.querySelector('meta[property="og:description"]').setAttribute("content", translations[lang]?.metaDescription || '');

	// Mise à jour de l'URL en fonction de la langue avec validation
	if (['en', 'fr', 'de'].includes(lang)) {
		window.history.pushState({ lang }, '', `/${lang}`);
	}

	// Mise à jour du texte des éléments avec data-key
	const elements = document.querySelectorAll('[data-key]');
	elements.forEach(element => {
		const key = element.getAttribute('data-key');
		element.textContent = translations[lang][key] || ''; 
	});

	// Mise à jour des attributs aria-label et alt
	updateAttributes('data-translate-aria', translations[lang].ariaLabels);
	updateAttributes('data-translate-alt', translations[lang].altTexts);

	// Modification du style des boutons
	updateButtonStyles(lang);
}

/**
 * @param {string} attrName - Le nom de l'attribut à mettre à jour
 * @param {Object} translationObj - L'objet contenant les traductions
 * @returns {void}
 * 
 * @description Met à jour les attributs aria-label ou alt des éléments
 */
function updateAttributes(attrName, translationObj) {
	const elements = document.querySelectorAll(`[${attrName}]`);
	elements.forEach(element => {
		const key = element.getAttribute(attrName);
		if (translationObj[key]) {
			element.setAttribute(attrName === 'data-translate-aria' ? 'aria-label' : 'alt', translationObj[key]);
		}
	});
}

/**
 * @param {string} lang - La langue à mettre à jour
 * @returns {void}
 * 	
 * @description Met à jour le style des boutons de langue
 */
function updateButtonStyles(lang) {
	const buttons = {
		fr: document.getElementById('fr-button'),
		en: document.getElementById('en-button'),
		de: document.getElementById('de-button')
	};
	Object.keys(buttons).forEach(key => {
		buttons[key].classList.toggle('active', key === lang);
	});
}

/**
 * @param {string} baseDomain - Le domaine de base du site
 * @returns {void}
 * 	
 * @description Ajoute les liens de traduction pour le SEO
 */
function addLanguageLinks(baseDomain) {
	['', 'fr', 'en', 'de'].forEach(lang => {
		const link = document.createElement('link');
		link.rel = lang ? 'alternate' : 'canonical';
		link.href = `${baseDomain}/${lang}`;
		link.hreflang = lang || 'x-default';
		document.head.appendChild(link);
	});
}


/***********************/

/* SELECTEUR DE LANGUE */

/***********************/
const langButton = document.getElementById('showPanelButton');

/**
 * @returns {void}
 * 
 * @description Affiche ou masque le panneau de sélection de langue
 */
function showPanelLanguage() {
	const panel = document.getElementById("language-selector");
	const expanded = panel.style.left === "0px";
	panel.style.left = expanded ? "-100px" : "0px";
	langButton.setAttribute("aria-expanded", !expanded);
}

langButton.addEventListener('click', showPanelLanguage);


/**************/

/* FORMULAIRE */

/**************/
/**
 * @param {string} token - Le jeton reCAPTCHA
 * @returns {void}
 * 
 * @description Soumet le formulaire si les champs sont valides et réinitialise le reCAPTCHA si le formulaire n'est pas valide
 * Il est appelé par le reCAPTCHA	après avoir vérifié le jeton reCAPTCHA, c'est la fonction de callback de Google reCAPTCHA
 */
window.onSubmit = function(token) {
	const form = document.getElementById('contactForm');
	
	// Ajoute `was-validated` pour afficher les messages d’erreur si les champs ne sont pas valides
	form.classList.add('was-validated');
	
	// Vérifie si le formulaire est valide
	if (form.checkValidity()) {
		form.submit(); // Soumet le formulaire si tout est valide
	} else {
		// Réinitialise le reCAPTCHA si le formulaire n'est pas valide
		grecaptcha.reset();
	}
}

// Ecoute la soumission du formulaire
document.getElementById('contactForm').addEventListener('submit', function (event) {
	event.preventDefault(); 
	// Lance le reCAPTCHA
	grecaptcha.execute();
});
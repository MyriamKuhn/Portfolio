/***********/

/* IMPORTS */

/***********/

import { translations } from '/assets/js/translations.js';


/******************/

/* GESTION NAVBAR */

/******************/
const navbar = document.getElementById("navbar");
const scrollTopButton = document.getElementById("scrollTopButton");
const brand = document.getElementById("brand");
const hero = document.getElementById("hero");
const toggler = document.getElementById("logoToggler");

// Crée un observateur pour gérer l'apparition et la disparition de la section hero
const observer = new IntersectionObserver((entries) => {
	entries.forEach((entry) => {
		if (entry.isIntersecting) {
			// Hero est de nouveau visible sur l'écran
			navbar.classList.add("bg-transparent", "navbar-dark");
			navbar.classList.remove("bg-light", "navbar-light");
			brand.classList.remove("text-dark");
			brand.classList.add("text-light");
			toggler.classList.remove("text-dark");
			toggler.classList.add("text-light");
			scrollTopButton.classList.remove("showing"); 
		} else {
			// Hero a quitté l'écran
			navbar.classList.remove("bg-transparent", "navbar-dark");
			navbar.classList.add("bg-light", "navbar-light");
			brand.classList.add("text-dark");
			brand.classList.remove("text-light");
			toggler.classList.add("text-dark");
			toggler.classList.remove("text-light");
			scrollTopButton.classList.add("showing"); 
		}
	});
}, { threshold: 0 }); // 0 signifie que l'observation est déclenchée dès qu'une petite portion de l'élément entre ou sort de l'écran

// Observer la section hero
observer.observe(hero);


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
	// Récupère le chemin de l'URL
	const path = window.location.pathname; 
	if (path.startsWith('/en')) {
		lang = 'en'; 
	} else if (path.startsWith('/fr')) {
		lang = 'fr'; 
	} else if (path.startsWith('/de')) {
		lang = 'de';
	} else {
	const userLang = navigator.language || navigator.userLanguage; // Détecte la langue du navigateur
	const lang = userLang.startsWith('fr') ? 'fr' : userLang.startsWith('de') ? 'de' : 'en'; 
	}

	// Vérifie si une langue est déjà sauvegardée
	const savedLang = localStorage.getItem('language');

	// Met à jour la langue
	changeLanguage(savedLang || lang);

	document.getElementById('fr-button').addEventListener('click', function() {
		changeLanguage('fr');
		localStorage.setItem('language', 'fr'); 
	});
	document.getElementById('en-button').addEventListener('click', function() {
		changeLanguage('en');
		localStorage.setItem('language', 'en'); 
	});
	document.getElementById('de-button').addEventListener('click', function() {
		changeLanguage('de');
		localStorage.setItem('language', 'de');
	});

	// Création des liens de traduction pour les langues disponibles (fr, en, de) dans le head pour le SEO
	const baseDomain = window.location.origin;
	const canonicalLink = document.createElement('link');
	canonicalLink.rel = 'canonical';
	canonicalLink.href = `${baseDomain}/`;
	document.head.appendChild(canonicalLink);

	const hreflangFr = document.createElement('link');
	hreflangFr.rel = 'alternate';
	hreflangFr.hreflang = 'fr';
	hreflangFr.href = `${baseDomain}/fr`;
	document.head.appendChild(hreflangFr);

	const hreflangEn = document.createElement('link');
	hreflangEn.rel = 'alternate';
	hreflangEn.hreflang = 'en';
	hreflangEn.href = `${baseDomain}/en`;
	document.head.appendChild(hreflangEn);

	const hreflangDe = document.createElement('link');
	hreflangDe.rel = 'alternate';
	hreflangDe.hreflang = 'de';
	hreflangDe.href = `${baseDomain}/de`;
	document.head.appendChild(hreflangDe);
});


/******************/

/* GESTION LANGUE */

/******************/
/**
 * @param {string} lang - La langue à changer
 * @returns {void}
 * @description Met à jour le texte, les attributs aria-label, la langue de la page, le titre de la page, la description et les mots-clés de la méta-description, l'URL, le style des boutons
 */
function changeLanguage(lang) {
	// Mise à jour de la langue de la page et des méta-données pour le SEO
	document.querySelector('html').setAttribute('lang', lang);
	document.title = translations[lang].pageTitle;
	document.querySelector('meta[name="description"]').setAttribute("content", translations[lang].metaDescription);
	document.querySelector('meta[name="keywords"]').setAttribute("content", translations[lang].metaKeywords);
	document.querySelector('meta[property="og:title"]').setAttribute("content", translations[lang].pageTitle);
	document.querySelector('meta[property="og:description"]').setAttribute("content", translations[lang].metaDescription);

	// Changement de l'URL en fonction de la langue
	if (lang === 'en') {
		window.history.pushState({ lang: 'en' }, '', '/en');
	} else if (lang === 'fr') {
		window.history.pushState({ lang: 'fr' }, '', '/fr');
	} else if (lang === 'de') {
		window.history.pushState({ lang: 'de' }, '', '/de');
	}

	// Mise à jour du texte avec les attributs data-key
	const elements = document.querySelectorAll('[data-key]');
	elements.forEach(element => {
			const key = element.getAttribute('data-key');
			element.textContent = translations[lang][key]; 
	});

	// Mise à jour des attributs aria-label
	const ariaElements = document.querySelectorAll('[data-translate-aria]');
	ariaElements.forEach(element => {
		const ariaKey = element.getAttribute('data-translate-aria');
		if (translations[lang].ariaLabels[ariaKey]) {
			element.setAttribute('aria-label', translations[lang].ariaLabels[ariaKey]);
		}
	});

	// Modification du style des boutons
	const frButton = document.getElementById('fr-button');
	const enButton = document.getElementById('en-button');
	const deButton = document.getElementById('de-button');

	if (lang === 'fr') {
		frButton.classList.add('active');
		enButton.classList.remove('active');
		deButton.classList.remove('active');
	} else if (lang === 'en') {
		enButton.classList.add('active');
		frButton.classList.remove('active');
		deButton.classList.remove('active');
	} else if (lang === 'de') {
		deButton.classList.add('active');
		enButton.classList.remove('active');
		frButton.classList.remove('active');
	}
}


/***********************/

/* SELECTEUR DE LANGUE */

/***********************/
const langButton = document.getElementById('showPanelButton');

function showPanelLanguage(){
	let panel = document.getElementById("language-selector");
	if(panel.style.left == "0px"){
			panel.style.left = "-100px";
			langButton.setAttribute("aria-expanded", "false");
	}
	else{
			panel.style.left = "0px";
			langButton.setAttribute("aria-expanded", "true");
	}
}

langButton.addEventListener('click', showPanelLanguage);
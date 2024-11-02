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
			scrollTopButton.classList.remove("showing"); // Cache le bouton
		} else {
			// Hero a quitté l'écran
			navbar.classList.remove("bg-transparent", "navbar-dark");
			navbar.classList.add("bg-light", "navbar-light");
			brand.classList.add("text-dark");
			brand.classList.remove("text-light");
			toggler.classList.add("text-dark");
			toggler.classList.remove("text-light");
			scrollTopButton.classList.add("showing"); // Affiche le bouton
		}
	});
}, { threshold: 0 }); // 0 signifie que l'observation est déclenchée dès qu'une petite portion de l'élément entre ou sort de l'écran

// Observer la section hero
observer.observe(hero);

scrollTopButton.onclick = function () {
	window.scrollTo({ top: 0, behavior: "smooth" })
};


const translations = {
	fr: {
		pageTitle: "Portfolio de Myriam Kühn | Développeuse Web",
		metaDescription: "Découvrez le portfolio de Myriam Kühn, développeuse web spécialisée dans la création de sites modernes et interactifs.",
		metaKeywords: "portfolio, Myriam Kühn, développeuse web, sites web, compétences, réalisations, contact",
		brand: "Myriam Kühn",
		home: "Accueil",
		about: "Qui suis-je ?",
		skills: "Compétences",
		projects: "Réalisations",
		contact: "Contact",
		ariaLabels: {
			nav: "Navigation principale",
			toggle: "Basculer la navigation",
		}
	},
	en: {
		pageTitle: "Myriam Kühn's Portfolio | Developer",
		metaDescription: "Explore the portfolio of Myriam Kühn, a web developer specializing in creating modern and interactive websites.",
		metaKeywords: "portfolio, Myriam Kühn, web developer, websites, skills, projects, contact",
		brand: "Myriam Kühn",
		home: "Home",
		about: "About Me",
		skills: "Skills",
		projects: "Projects",
		contact: "Contact",
		ariaLabels: {
			nav: "Main Navigation",
			toggle: "Toggle navigation",
		}
	}
};


document.addEventListener('DOMContentLoaded', () => {
	let lang; // Déclarez lang ici

	const path = window.location.pathname; // Récupère le chemin de l'URL
	if (path.startsWith('/en')) {
		lang = 'en'; // Définit 'en' si l'URL commence par '/en'
} else if (path.startsWith('/fr')) {
		lang = 'fr'; // Définit 'fr' si l'URL commence par '/fr'
} else {
	const userLang = navigator.language || navigator.userLanguage; // Détecte la langue du navigateur
	const lang = userLang.startsWith('fr') ? 'fr' : 'en'; // Choisit 'fr' ou 'en' selon la langue du navigateur
}

	// Vérifie si une langue est déjà sauvegardée
	const savedLang = localStorage.getItem('language');
	changeLanguage(savedLang || lang); // Appelle la fonction pour afficher la langue correspondante

	document.getElementById('fr-button').addEventListener('click', function() {
			changeLanguage('fr');
			localStorage.setItem('language', 'fr'); // Sauvegarde la langue choisie
	});

	document.getElementById('en-button').addEventListener('click', function() {
			changeLanguage('en');
			localStorage.setItem('language', 'en'); // Sauvegarde la langue choisie
	});

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
        
});

function changeLanguage(lang) {
	const elements = document.querySelectorAll('[data-key]');
	elements.forEach(element => {
			const key = element.getAttribute('data-key');
			element.textContent = translations[lang][key]; // Met à jour le texte selon la langue
	});

	// Mise à jour des attributs aria-label de manière générale
	const ariaElements = document.querySelectorAll('[data-translate-aria]');
	ariaElements.forEach(element => {
			const ariaKey = element.getAttribute('data-translate-aria');
			if (translations[lang].ariaLabels[ariaKey]) {
					element.setAttribute('aria-label', translations[lang].ariaLabels[ariaKey]);
			}
	});

	document.querySelector('html').setAttribute('lang', lang);
	document.title = translations[lang].pageTitle;
	document.querySelector('meta[name="description"]').setAttribute("content", translations[lang].metaDescription);
	document.querySelector('meta[name="keywords"]').setAttribute("content", translations[lang].metaKeywords);
	document.querySelector('meta[property="og:title"]').setAttribute("content", translations[lang].pageTitle);
	document.querySelector('meta[property="og:description"]').setAttribute("content", translations[lang].metaDescription);

	// Changement de l'URL en fonction de la langue
	if (lang === 'fr') {
		window.history.pushState({ lang: 'fr' }, '', '/fr'); // Change l'URL à /fr
} else {
		window.history.pushState({ lang: 'en' }, '', '/en'); // Change l'URL à /en
}

	// Modification du style des boutons
	const frButton = document.getElementById('fr-button');
	const enButton = document.getElementById('en-button');

	if (lang === 'fr') {
			frButton.classList.add('active');
			enButton.classList.remove('active');
	} else {
			enButton.classList.add('active');
			frButton.classList.remove('active');
	}
}




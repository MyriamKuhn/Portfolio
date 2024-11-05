
# My Portfolio

This repository contains the files for my personal portfolio. It serves as an introduction to my work and skills, intended for future employers and recruiters.

This project is a web application that uses Docker to run a PHP/Apache environment. The site includes HTML, CSS, SASS, JavaScript, and PHP files, with dependencies such as Dotenv, PHPMailer, and Bootstrap.



## Requirements
Before you start, make sure you have the following components installed on your machine:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`MAILER_HOST` (the smtp for PHP Mailer)

`MAILER_PORT` (the port for the PHP Mailer)

`MMAILER_EMAIL` (the email for the PHP Mailer)

`MAILER_PASSWORD` (the password for the PHP Mailer)

`SITE_RECAPTCHA_KEY` (your site recaptcha key)

`SITE_RECAPTCHA_SECRET` (your site recaptcha secret)

## To run Locally

Clone the project

```bash
  git clone https://github.com/MyriamKuhn/Portfolio.git
```

Go to the project directory

```bash
  cd Portfolio
```

Install dependencies

```bash
  docker-compose run web composer install
  docker-compose run web npm install
```

Start all containers
```bash
  docker-compose up --build
```

Launch the application
```bash
  docker-compose up -d
```

### Stopping the application
To stop Docker containers :
```bash
  docker-compose down
```

### Compiling SASS files in CSS
The project uses SASS to manage CSS files. You can compile SASS files in CSS with :
```bash
  docker-compose run web npm run build:sass
```
This command compiles and monitors SASS files, automatically recompiling them.

## To run Locally without Docker

### Requirements
Before you start, make sure you have the following components installed on your machine:
- [PHP 8.3](https://www.php.net/docs.php)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en) and [npm](https://www.npmjs.com/)
- A web server (Apache, Nginx, etc.)

### Clone the Project
Clone the repository to your local machine:
```bash
git clone https://github.com/MyriamKuhn/Portfolio.git
cd Portfolio
```

### Install Dependencies
Install PHP dependencies with Composer:
```bash
composer install
```
Install Node.js dependencies:
```bash
npm install
```

### Environment Variables
Create an .env file in the project root and add the variables as described above.

### Configure Your Web Server
Set your web server to point to the public directory of the project.

### Compile SASS Files
Compile the SASS files into CSS:
```bash
npm run build:sass
```

### Start Your Web Server
Start your web server and navigate to your local instance of the application.
## Troubleshooting

- 500 Internal Server Error: Check web server logs and file permissions.
- Error installing dependencies: Make sure Docker and Docker Compose are correctly installed.
## Dependencies

- [PHP 8.3](https://www.php.net/docs.php) - Backend language
- [PHP Mailer 6.9](https://github.com/PHPMailer/PHPMailer) - Library for sending e-mails in PHP
- [Dotenv 5.6](https://github.com/vlucas/phpdotenv) - Management of environment variables
- [Bootstrap 5.3](https://getbootstrap.com/docs/5.3/getting-started/introduction/) - CSS framework for responsive page layout
- [Docker](https://www.docker.com/) - Application containerization
## Deployed Application

[https://myriamkuhn.com/](https://myriamkuhn.com/)


## Feedback

If you have any feedback, please reach out to us at myriam.kuehn@free.fr


## License

This project is licensed by MIT.


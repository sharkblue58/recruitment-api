# Php-Laravel-Recruitment
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=postman&logoColor=white)
![Swagger](https://img.shields.io/badge/Swagger-85EA2D?style=for-the-badge&logo=swagger&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

A recruitment management application built with Laravel that helps businesses streamline their hiring process, manage candidates, and track job applications efficiently.

 ## Installation:

1. Clone the repository :

```
git clone https://github.com/sharkblue58/php-laravel-invoice.git
```
2. Install the dependencies :

```
composer install
```
```
npm install
```

3.	Copy the ```.env.example``` file to ```.env``` and update the environment variables.

4.	Generate the app key :

```
php artisan key:generate
```
   
6.	Create the database :

```
php artisan migrate
```

7. Seed the database :
   
```
php artisan db : seed
```

8.	Start the development server

```
php artisan serve
```
```
npm run dev
```

## Usage:

The project can be accessed at ```http://127.0.0.1:8000``` in your browser.

## Features:

- Candidate Application Portal: User-friendly application form for candidates

- Application Tracking System: Track applications through various stages (New, Screening, Interview, Hired, Rejected)

- Resume Parsing: Automated extraction of candidate information from uploaded resumes

- Interview Scheduling: Generate results and managing interviews

- Candidate Communication: Email templates and communication history

- Reporting & Analytics: Generate reports on hiring metrics and pipeline status

- Multi-user Role Management: Candidate, Recruiter, Admin and Super Admin roles with appropriate permissions

- Document Management: Store and organize candidate documents and resumes

## Gallery

<div>
<img src="" width="200">
</div>

## Contributing Guidelines

To contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your contribution.
3. Make your changes.
4. Commit your changes with a descriptive message.
5. Push your branch to your fork.
6. Open a pull request against the upstream repository.


> **_NOTE:_**  Please make sure to follow the coding style guide and testing guidelines when making your contributions.

## Deployment:

To deploy the project to production, you can use a variety of methods, such as Laravel Forge, Capistrano, or Deployer.

## License:

This project is licensed under the **MIT** License.

## Credits

This project was created by **Mohamed Essam** & **Edris** .


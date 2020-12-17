# PHP CHALLENGE - INVILLIA
Test for Invillia

## Instructions for install
  1. Acess path laradoc `cd laradock`
  2. `sudo docker-compose up -d nginx mysql phpmyadmin`
  3. `sudo docker-compose exec --user=laradock workspace bash`
  4. `composer install`
  5. `php artisan migrate --seed`
  6. `php artisan storage:link`

## Run the application
  - Access http://localhost:8081

## Run the tests
  - `vendor/bin/phpunit`

## Endpoints
  - POST /api/login
  - GET  /api/peoples
  - GET  /api/peoples/{idPeople}
  - GET  /api/orders
  - GET  /api/orders/{idOrders}
  - GET  /upload

*Note: API documented in /doc*


## My Notes
  - On the home page select the two XML files and send.
  - Built authentication with JWT.
  - I returned the endpoints in JSON, however I was in doubt if it should be in XML.
  - Any questions call me.

> Author: <strong>Victor Willer Pacífico Barbosa</strong>

#

# PHP Challenge
## Brief Description:
Your customer receives two XML models from his partner. This information must be
available for both web system and mobile app. XML content can be very extensive and we must ensure the content will be fully processed.

## The challenge:
Create an application to manually upload the given XMLs and have an option
to asynchronously process them. The results of the processed data must be logged. Make the processed information available via rest APIs.

## Must have:
- Symfony/Laravel.
- Docker image(s) used.
- Any level of automated tests.
- An index page to upload the XML with a button to process it.
- Rest APIs for the XML data, only the GET methods are needed.
- README.md with the instructions to install the application.

## Bonus points:
- Authentication method to the APIs.
- Generated documentation for the APIs.

## What will be rated:
- Architectural decisions
- Data validation
- Code quality

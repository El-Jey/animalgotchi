## Required
- `NodeJS v10.19.0`
- `npm v6.14.4`
- `Composer v1.10.1`

## Setup
- `git clone https://github.com/El-Jey/animalgotchi.git`
- `cd animalgotchi`
- `cp .env.example .env`
- `docker-compose up -d`
- `docker exec app npm install`
- `docker exec app composer install`
- `docker-compose exec app php artisan key:generate`
- `npm run watch-poll`
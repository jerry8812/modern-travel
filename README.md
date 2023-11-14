# Modern Travel
https://admin.moderntravel.co.nz

# Environment (Laravel Sail)

Set up and use Laravel sail as per https://laravel.com/docs/10.x/sail

## Configure your environment file
* Run `cp .env.example .env` to copy `.env.example` to `.env` and set the config values for your environment accordingly. All of these values should already be set up to work with the docker/sail environment.

## First-time composer install

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
### Permission issues
If you are having issues spinning up your docker image and installing composer it may be a permission issue. You can try:
`chown -R mandy public/` or `sudo chown -R mandy public/`

## Starting the development environment

```sh
sail up
sail npm i
sail npm run dev
```

## Reset the DB (local dev)
`sail artisan migrate:fresh --seed`

# Deployment

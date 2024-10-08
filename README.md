# Modern Travel
https://admin.moderntravel.co.nz

# Environment (Laravel Sail)

Set up and use Laravel sail as per https://laravel.com/docs/10.x/sail

## Configure your environment file
* Run `cp .env.example .env` to copy `.env.example` to `.env` and set the config values for your environment accordingly. All of these values should already be set up to work with the docker/sail environment.

## Password
`$2y$12$cNAInnugEjtwwCCvbLKXeOgETGhKKFxODGE0U.c1WVc9zdIfr2R0W`

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

## Get live database
`sail artisan db:wipe && ssh moderntravel@mybud.nz "mysqldump -hmysql57 -ujerrydbuser -pjerrydbuser --column-statistics=0 --no-tablespaces moderntravel" | mysql -hlocalhost -uroot -p --protocol tcp laravel`

## Reset the DB (local dev)
`sail artisan migrate:fresh --seed`

# Deployment

run just once 
`git remote add live moderntravel@mybud.nz:~/repo/application.git`
`sail npm run build`
`git push live main:master`
`rsync -avhl public/build/ moderntravel@mybud.nz:/container/application/public/build/`

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

cp .env.example .env

echo "subindo containers";
vendor/bin/sail up -d

vendor/bin/sail artisan key:generate

echo "rodando migrations";
vendor/bin/sail artisan migrate

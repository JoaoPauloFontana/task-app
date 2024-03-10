echo "subindo containers";
vendor/bin/sail up -d

echo "rodando migrations";
vendor/bin/sail artisan migrate

## Instalação 
### Requisitos
 - Docker
 - Porta 8011 liberada.
 - Porta 3337 liberada para mysql.
 - Porta padrão liberada para o Redis

Execute um dos seguintes comandos na pasta raiz do projeto:

bash
```
bash install.sh
```
ou
CMD
```
install
```

## Comandos úteis
```
docker-compose exec laravel php artisan test
```
```
docker-compose exec laravel php artisan migrate
```

Endereço de acesso: http://localhost:8011

## Tecnologias utilizadas
 - PHP 8.3
 - Laravel 10
 - MySQL
 - Docker

## Instalação 
### Requisitos
 - Docker
 - Porta 8011 liberada.
 - Porta 3337 liberada para mysql.

Clone the project:
```
git clone https://github.com/JoaoPauloFontana/task-app.git
```

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
docker-compose exec app php artisan test
```
```
docker-compose exec app php artisan migrate
```

Endereço de acesso: http://localhost:8011

## Tecnologias utilizadas
 - PHP 8.3
 - Laravel 10
 - MySQL
 - Docker

## Links úteis
 - Documentação do postman: https://documenter.getpostman.com/view/19822036/2sA2xk1C4o

# Slim Skeleton API

O Slim Skeleton API é um setup inicial para desenvolvimento de APIs Rest na Autodoc.  
Ele tem como objetivo apenas fornecer um boilerplate para o setup inicial de um novo projeto.  
O Slim Skeleton foi desenvolvido para ser executado tanto em uma arquitetura serverless  
utilizando o pacote do phpbref ou sendo utilizado em um arquitetura de containers.  

Pacotes instalados por padrão:

* aws/aws-sdk-php
* slim/slim
* bref/bref
* laminas/laminas-diactoros
* monolog/monolog
* vlucas/phpdotenv
* php-di/php-di
* fig/http-message-util

# Ambiente de desenvolvimento

Para iniciar o projeto, basta fazer um git clone em sua maquina local.  

```sh
git clone git@github.com:autodocdev/slim-skeleton-api.git
```

Para dar um start no projeto, basta iniciar os serviços utilizando docker-composer ou o servidor build-in do php  

```sh
docker-compose up -d
// ou
php -S localhost:8080 -t public
```

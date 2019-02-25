# Symfony4APIBoilerplateJWTBook
[![Build Status](https://travis-ci.org/Tony133/Symfony4APIBoilerplateJWTBook.svg?branch=master)](https://travis-ci.org/Tony133/Symfony4APIBoilerplateJWTBook)

Simple Example Api Rest Book with Symfony 4.2 and Json Web Token

## Install with Composer

```
    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install or composer install
```

## Setting Environment

```
    $ cp .env.dist .env
```

## Generate the SSH keys

```
    $ mkdir config/jwt
    $ openssl genrsa -out config/jwt/private.pem -aes256 4096
    $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

## Getting phpunit

```
    $ php bin/phpunit or ./bin/phpunit
```

## Example Created using Symfony4APIBoilerplateJWT

[Symfony4APIBoilerplateJWT](https://github.com/Tony133/Symfony4APIBoilerplateJWT)

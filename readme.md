<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Sobre o fórum

Projeto fórum é um teste de um processo seletivo


## Instalação

- Excute os comando abaixo em seu terminal 
- `git clone https://github.com/l3k/forum.git`
- `cd forum`
- `cp .env.example .env`
- `composer install`
- `npm install`
- `php artisan key:generate`
- Edite o arquivo que esta na raiz do projeto `.env` e defina os detalhes da sua conexão de banco de dados
- `php artisan migrate`
- `php artisan jwt:secret`
- `npm run dev`
- `php artisan serve`
- Após isso, acesse o endereço que será exibido no terminal


## Licença

O framework Laravel é um software de código aberto licenciado sob a [MIT license](https://opensource.org/licenses/MIT).

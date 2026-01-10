<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax.
License : The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# TRELLOLITE-LARAVEL

A production-minded REST API built with **Laravel 12** that manages **Projects and Tasks** with strict **user ownership**, **JWT authentication**, and a clean architecture suitable for a legacy backend system.

This README is tailored to the current project structure and setup in this repository:

- framework: Laravel 12
- authentication: JWT (`tymon/jwt-auth`)
- database: MySQL
- API style: REST
- CI/CD: GitHub Actions
- deployment VPS: BiznetGioCloud.com
- API documentation: Postman Live Docs

This project is designed to be **secure**, **maintainable**, and **ready for future migration** (e.g. to NestJS).

---

## Prerequisites
You should have installed:
- PHP >= 8.2
- Composer
- MySQL
- Git
- Nginx / Apache

---

## Quick start (local development)
1. Clone repository

2. Environment setup
    - run `cp .env.example .env` on your terminal

3. install composer (first-time only): `composer install`

4. Generate application key & Generate JWT secret (if needed): `php artisan key:generate && php artisan jwt:secret`

5. Run migrations & seeders:
    Recommended (reset database completely), This will drop all tables, run all migrations, and seed the database:
    - `php artisan migrate:fresh --seed`
    If the database already exists , This will only run pending migrations and seeders:
    - `php artisan migrate --seed`

6. Start development server (with file watcher):
    - `php artisan serve` , Laravel will run and listen on `localhost:8000`, uses in your local development 

7. You can also tested at `https://trellolite-laravel.idkoding.com`

## Postman collection:
https://documenter.getpostman.com/view/26950655/2sBXVfiBJm

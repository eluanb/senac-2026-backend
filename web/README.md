# API de Tickets - Guia de Instalacao

Projeto academico desenvolvido em Laravel para gerenciamento de tickets.

## Pre-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js 20+ e NPM
- Banco de dados MySQL ou PostgreSQL
- Extensoes PHP comuns para Laravel (PDO, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath)

## 1. Clonar o projeto

```bash
git clone <url-do-repositorio>
cd web
```

## 2. Instalar dependencias

Dependencias PHP:

```bash
composer install
```

Dependencias front-end (Vite):

```bash
npm install
```

## 3. Configurar ambiente

Crie o arquivo de ambiente:

```bash
cp .env.example .env
```

Gere a chave da aplicacao:

```bash
php artisan key:generate
```

Edite o arquivo `.env` e configure os dados do banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=senac_tickets
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Criar estrutura no banco

```bash
php artisan migrate
```

Opcional para dados iniciais:

```bash
php artisan db:seed
```

## 5. Rodar o projeto localmente

Terminal (assets em desenvolvimento):

```bash
npm run dev
```

## Stack do projeto

- Laravel 12
- PHP 8+
- Blade
- Vite
- MySQL/PostgreSQL

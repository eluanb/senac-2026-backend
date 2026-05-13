# Instalação do Projeto

Este projeto possui 2 partes principais:

- `web/`: aplicação Laravel 12
- `chat/`: servidor Node.js para chat em tempo real

O ambiente principal de desenvolvimento sobe via Docker Compose a partir de [`devops/docker-compose.yml`](/home/dev/senac/devops/docker-compose.yml).

## Pré-requisitos

- Docker
- Docker Compose (`docker compose`)
- Node.js + npm no host
  - necessário para instalar e gerar os assets do `web/`
- Git

## Estrutura dos serviços

Ao subir o ambiente com Docker Compose, os serviços são:

- `nginx`: expõe a aplicação em `http://localhost`
- `php`: container da aplicação Laravel
- `postgres`: banco PostgreSQL
- `chat`: servidor Node.js do chat em tempo real

Portas utilizadas:

- `80`: aplicação Laravel via Nginx
- `5432`: PostgreSQL

## 1. Subir os containers

Na raiz do projeto:

```bash
docker compose -f devops/docker-compose.yml up -d --build
```

Para acompanhar os logs:

```bash
docker compose -f devops/docker-compose.yml logs -f
```

Para parar o ambiente:

```bash
docker compose -f devops/docker-compose.yml down
```

## 2. Configurar o Laravel

O Laravel fica em `web/`. Se o `.env` ainda não existir:

```bash
cp web/.env.example web/.env
```

Edite o arquivo `web/.env` para usar PostgreSQL com os mesmos dados do Docker Compose:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=app

CHAT_SECRET=senac-chat-secret-local
```

Se for usar a integração com OpenRouter, configure também:

```env
OPENROUTER_API_KEY=
OPENROUTER_BASE_URL=https://openrouter.ai/api/v1
OPENROUTER_MODEL=openai/gpt-oss-120b:free
```

## 3. Instalar dependências do Laravel

As dependências PHP devem ser instaladas dentro do container `php`:

```bash
docker compose -f devops/docker-compose.yml exec php composer install
```

Gerar a chave da aplicação:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan key:generate
```

Executar as migrations:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan migrate
```

Se quiser popular dados iniciais:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan db:seed
```

## 4. Instalar e gerar assets do frontend do Laravel

O projeto `web/` usa Vite. Os assets não são gerados automaticamente pelo Docker Compose, então rode no host:

```bash
cd web
npm install
npm run build
cd ..
```

Se quiser rodar o Vite em modo desenvolvimento no host:

```bash
cd web
npm install
npm run dev
```

## 5. Subir a aplicação

Depois de concluir os passos acima, a aplicação ficará disponível em:

```text
http://ip-do-wsl
```

O chat sobe automaticamente no serviço `chat`, e o Nginx faz o proxy do Socket.IO em:

```text
http://ip-do-wsl/socket-chat/socket.io/
```

## Comandos úteis do Laravel

Rodar comandos Artisan dentro do container `php`:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan
```

Limpar caches:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan optimize:clear
```


Abrir shell no container PHP:

```bash
docker compose -f devops/docker-compose.yml exec php sh
```


## Comandos úteis do banco

Recriar o banco da aplicação com seed:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan migrate:fresh --seed
```

## Fluxo recomendado para primeira subida

Na raiz do projeto:

```bash
docker compose -f devops/docker-compose.yml up -d --build
cp web/.env.example web/.env
docker compose -f devops/docker-compose.yml exec php composer install
docker compose -f devops/docker-compose.yml exec php php artisan key:generate
docker compose -f devops/docker-compose.yml exec php php artisan migrate
cd web && npm install && npm run build && cd ..
```

Depois acesse:

```text
http://ip-do-wsl
```

## Observações

- O serviço `chat` já executa `npm i && npm run dev` automaticamente ao subir o Compose.
- O Laravel usa PostgreSQL no ambiente Docker, não SQLite.
- Se o `composer install` falhar porque o container ainda não iniciou completamente, aguarde alguns segundos e rode o comando novamente.

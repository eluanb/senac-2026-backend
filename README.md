# SENAC Tickets

Sistema acadêmico de gerenciamento de chamados com Laravel, PostgreSQL e chat em tempo real por ticket.

O projeto é dividido em dois módulos:

- `web/`: aplicação principal em Laravel
- `chat/`: servidor Socket.IO responsável pela comunicação em tempo real

## Visão geral

A aplicação permite autenticação de usuários, abertura e acompanhamento de chamados, atendimento por responsáveis e comunicação em tempo real entre usuário e atendente dentro de cada ticket.

Também existe integração opcional com OpenRouter para geração de sugestão de resposta por IA.

## Funcionalidades

- Login e logout de usuários
- Dashboard autenticado
- Listagem de chamados
- Criação de chamados
- Atendimento de chamados por atendente
- Chat em tempo real por ticket
- Sugestão de resposta com IA
- API protegida com Laravel Sanctum

## Arquitetura

O ambiente local roda via Docker Compose com os seguintes serviços:

- `nginx`: publica a aplicação web em `http://localhost`
- `php`: executa a aplicação Laravel
- `postgres`: banco de dados PostgreSQL
- `chat`: servidor Node.js com Socket.IO

Fluxo principal:

1. O usuário acessa a aplicação Laravel pelo Nginx.
2. O Laravel gerencia autenticação, tickets, views e regras de negócio.
3. O chat em tempo real roda em um serviço separado.
4. O Nginx faz o proxy das conexões Socket.IO para o serviço `chat`.
5. O acesso ao chat usa token assinado pelo Laravel para validar entrada na sala do ticket.

## Stack

- PHP 8.3
- Laravel 12
- PostgreSQL 18
- Node.js
- Socket.IO
- Nginx
- Vite
- Tailwind CSS
- Docker Compose

## Estrutura do repositório

```text
.
├── chat/      # servidor de chat em tempo real
├── devops/    # docker-compose, Dockerfile e configuração do Nginx
└── web/       # aplicação Laravel
```

## Instalação

O passo a passo completo está em [Install.md](/home/dev/senac/Install.md).

Resumo da primeira subida:

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

## Configuração de ambiente

No ambiente Docker, o Laravel deve usar PostgreSQL com estes valores:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=app
```

Para o chat em tempo real:

```env
CHAT_SECRET=senac-chat-secret-local
```

Para a integração opcional com IA:

```env
OPENROUTER_API_KEY=
OPENROUTER_BASE_URL=https://openrouter.ai/api/v1
OPENROUTER_MODEL=openai/gpt-oss-120b:free
```

## Rotas principais

Rotas web:

- `GET /login`
- `POST /auth`
- `GET /dashboard`
- `GET /chamados`
- `POST /chamados`
- `POST /chamados/{ticket}/sugestao-ia`
- `GET /chamados/{ticket}/chat`
- `POST /chamados/{ticket}/atender`

Rotas de API:

- `POST /api/tokens/create`: gera token Sanctum
- `GET /api/tickets`: retorna tickets abertos para usuário autenticado via Sanctum

## Chat em tempo real

O chat roda no serviço `chat`, mas é acessado pela aplicação via proxy do Nginx:

```text
http://ip-do-wsl/socket-chat/socket.io/
```

Características atuais:

- autenticação por token assinado com HMAC
- salas separadas por ticket
- histórico em memória por sala
- indicação de digitação
- limite de até 200 mensagens por sala em memória

## Comandos úteis

Subir o ambiente:

```bash
docker compose -f devops/docker-compose.yml up -d --build
```

Ver logs:

```bash
docker compose -f devops/docker-compose.yml logs -f
```

Rodar migrations:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan migrate
```

Limpar caches:

```bash
docker compose -f devops/docker-compose.yml exec php php artisan optimize:clear
```

## Observações

- O serviço `chat` instala dependências e sobe automaticamente ao iniciar o Docker Compose.
- O frontend do Laravel usa Vite, então o build dos assets em `web/` faz parte da subida inicial.
- O histórico do chat está em memória no processo Node.js; reiniciar o container do chat limpa esse histórico.

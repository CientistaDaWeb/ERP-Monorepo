# Projeto Acquasana

## Pré Requisitos

- Docker

## Serviços

- API
- ERP
- Site

### API

Tecnologias: Laravel

Descrição: Aplicação para fornecimento de dados para os outros serviços

### ERP

Tecnologias: Vuejs + Quasar Framework

Descrição: Aplicação multi plataforma para o ERP da empresa

### Site

Tecnologias: Laravel

Descrição: Site institucional da empresa + painel de acesso do Cliente


## Como Configurar

1) Clonar o projeto do github
2) Criar os arquivos .env (/.env, /api/.env, /erp/.env, /site/.env) com base nos seus .env.example
3) Execute `docker-compose build` 
4) Execute `docker-compose up -d`

## Como Acessar

API - https://localhost:4431

ERP - https://localhost:4432
    
    - usuário: fernando@webscientist.com.br
    - senha: acquasana

Site - https://localhost:4433

# Projeto Acquasana

## Pré Requisitos

- docker (19+)

- docker-compose (1.25+)

*Caso não consiga rodar o docker sem ser root execute*

`sudo usermod -aG docker ${USER}`

## Serviços

- API
- ERP
- Site
- Legado

### API

Tecnologias: Laravel

Descrição: Aplicação para fornecimento de dados para os outros serviços

### ERP

Tecnologias: Vuejs + Quasar Framework

Descrição: Aplicação multi plataforma para o ERP da empresa

### Site

Tecnologias: Laravel

Descrição: Site institucional da empresa + painel de acesso do Cliente

### Legado

Tecnologias: Zend Framework

Descrição: Monolito legado que virou o desmembramento em outros serviços

## Como Configurar

1) Clonar o projeto do github
2) Criar os arquivos .env (/.env, /api/.env, /erp/.env, /site/.env) com base nos seus respectivos .env.example
3) Execute `docker-compose build` 
4) Execute `docker-compose up -d`

## Como Acessar

API - https://localhost:4461

ERP - https://localhost:4462
    
    - usuário: fernando@webscientist.com.br
    - senha: acquasana

Site - https://localhost:4463

Legado - https://localhost:4464/erp
    
    - usuário: webscientist
    - senha: acquasana

## Como parar o projeto

Execute `docker-compose down`

## Problemas conhecidos

### PermissionError: [Errno 13] Permission denied: '[...]/.docker/mysql/dbdata...'

Execute `sudo chmod 777 -Rf .docker/mysql/dbdata`

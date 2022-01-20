# app-406adbc4

## Configurações

#### Ambiente
O ambiente do projeto foi todo configurado utilizando Docker.
Basta ter o docker e o docker-compose instalado e rodar `docker-compose up -d`.

#### Scripts
Foi adicionado dois arquivos .sh para facilitar chamadas ao Artisan (do Laravel) e
do Composer. `artisan.sh` e `composer.sh` respectivamente.

Caso precise rodar os comandos no Windows, copie a linha contida nos scripts e
substitua o `$@` pelos seus argumentos.

Exemplos:
- `./composer.sh install`
- `./artisan test`

## Como verificar as funcionalidades
Após subir os containers utilizando o docker-compose as rotas podem ser
acessadas utilizando um API Client como o Insomnia ou Postman ou rodar as
suites de teste com `./artisan.sh test`.

A URL base das rotas é `localhost:8000/api`. Eu poderia ter mudado e retirado o
prefixo "api" alterando o RouteServiceProvider, mas imagino que não iria fazer
diferença pro exercício.

### Rotas
- `GET /products`: Lista todos produtos. Não era necessária mas decidi fazer
caso alguém queira fazer um teste manual.
- `POST /products`: Cria um produto. Enviar no body um json no
formato `{ name: string, sku: string, quantity: integer }`. Enviar o header
`Accept: application/json`. Sem o header, em caso de falha o usuário é redirecionado
para a última rota acessada, no caso a "home"(`/`). Com o header, em caso de falha
o usuário recebe como resposta as mensagens de erro em formato json.
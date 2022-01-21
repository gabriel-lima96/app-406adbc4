# app-406adbc4

## Configurações

#### Scripts
Foi adicionado dois arquivos .sh para facilitar chamadas ao Artisan (do Laravel) e
do Composer. `artisan.sh` e `composer.sh` respectivamente.

Caso precise rodar os comandos no Windows, copie a linha contida nos scripts e
substitua o `$@` pelos seus argumentos.

Exemplos:
- `./composer.sh install`
- `./artisan test`

#### Instalação
O ambiente do projeto foi todo configurado utilizando Docker.
É necessário ter o Docker e o Docker Compose instalados.

Com o Docker e Docker Compose instalados, seguir os passos:
```bash
./composer.sh install
cp .env.example .env
./artisan.sh key:generate
./artisan.sh migrate
```

## Como verificar as funcionalidades
Após subir os containers utilizando o docker-compose as rotas podem ser
acessadas utilizando um API Client como o Insomnia ou Postman ou rodar as
suites de teste com `./artisan.sh test`.

A URL base das rotas é `localhost:8000/api`.

Enviar o header `Accept: application/json` na requisição de todas as rotas.

### Rotas
- `GET /products`: Lista todos produtos.
- `GET /products/{{sku}}`: Responde com o produto da SKU especificada.
- `GET /products/{{sku}}/history`: Lista o histórico de alterações do produto
correspondente ao SKU.
- `POST /products`: Cria um produto. Enviar no corpo da requisição os campos
`name` (texto), `sku` (texto), `quantity` (inteiro). Em caso de sucesso,
deve receber como resposta o status 201, o objeto recém criado no corpo da resposta
e um header `Location: localhost:/8000/api/products/{{sku}}`.
- `PATCH /products/{{sku}}`: Altera, de forma absoluta, campos específicos (no
caso, somente permite a `quantity`). Enviar no body um `quantity` (inteiro).
- `PATCH /products/{{sku}}/increment`: Adiciona à `quantity` um valor
especificado no body. Enviar no body um `value` (inteiro).
- `PATCH /products/{{sku}}/decrement`: Diminui da `quantity` um valor
especificado no body. Enviar no body um `value` (inteiro).
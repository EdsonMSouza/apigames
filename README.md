# PHP API GAMES v.1.0

<code><img height="50" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/php/php.png"></code>
<code><img height="50" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/mysql/mysql.png"></code>

API simples para integração com jogos digitais, por exemplo Godot. Ela apresenta recursos para criação de usuário, login, criação de instância de jogos, salvamento, placar e ranking.
 
```html
PHP 7.4.3 (cli) (built: Jul  5 2021 15:13:35) ( NTS )
Copyright (c) The PHP Group Zend Engine v3.4.0, 
Copyright (c) Zend Technologies with Zend OPcache v7.4.3, 
Copyright (c), by Zend Technologies
```

## Como usar esse conteúdo?

Este conteúdo é livre para uso e distribuição sob a licença (CC BY-SA 4.0).

Se quiser colaborar neste repositório com melhorias ou correções, basta fazer um _fork_ e enviar um PR.

## Estrutura da API

```text
+---api
    \class\
        GameModel.php
        PDOConnection.php
        UserModel.php
    game.php
    scripts.sql
    teste.httpd
    user.php
```

## _Database_

Esta API utiliza o banco de dados MySQL 5, que pode ser alterado a qualquer momento de acordo com a necessidade de uso. O banco de dados deve ser
configurado em _\class\PDOConnection.php_.

### Scripts SQL

```sql
CREATE DATABASE name;
```

```sql
CREATE TABLE users
(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    user  VARCHAR(100) NOT NULL,
    password  VARCHAR(100) NOT NULL
);

CREATE TABLE games
(
    id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT(11),
    score INT(11)
);
```

## _Resources_

### User

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **NEW** | `http://URI/api/user.php` | **POST** |

_**header**_

```json
{
  "content-type": "application/json"
}
```

_**payload**_

```json
{
  "type": "new",
  "name": "name",
  "user": "username",
  "password": "password"
}
```

_**Success**_

```json
{
  "data": "ok",
  "value": "user_created_successfully"
}
```

_**Warnings**_

```json
{
  "data": "err",
  "value": "invalid_data"
}
```

```json
{
  "data": "err",
  "value": "user_[...]_exists"
}
```

---

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **LOGIN** | `http://URI/api/user.php` | **POST** |

_**header**_

```json
{
  "content-type": "application/json"
}
```

_**payload**_

```json
{
  "type": "login",
  "user": "username",
  "password": "password"
}
```

_**Success**_

```json
{
  "id": 5,
  "user": "username",
  "name": "name",
  "data": "ok"
}
```

_**Warnings**_

```json
{
  "data": "err",
  "value": "invalid_data"
}
```

```json
{
  "data": "err",
  "value": "user_not_found"
}
```

---

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **USERS** | `http://URI/api/user.php` | **POST** |

_**header**_

```json
{
  "content-type": "application/json"
}
```

_**payload**_

```json
{
  "type": "users"
}
```

_**Success**_

```json
{
  "0": {
    "user": "name"
  },
  "1": {
    "user": "name"
  },
  "data": "ok"
}
```

_**Warnings**_

```json
{
  "data": "err",
  "value": "invalid_data"
}
```

```json
{
  "data": "err",
  "value": "there_are_no_users_to_list"
}
```

### Game

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **NEW** | `http://URI/api/game.php` | **POST** |

_**header**_

```json
{
  "content-type": "application/json"
}
```

_**payload**_

```json
{
  "type": "new",
  "user_id": "value"
}
```

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **SAVE** | `http://URI/api/game.php` | **POST** |

```json
{
  "content-type": "application/json"
}
```

_**Payload**_

```json
{
"type":"save",
"game_id":value,
"score":3000
}
```

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **RANKING GENERAL** | `http://URI/api/game.php` | **POST** |

```json
{
  "content-type": "application/json"
}
```

```json
{
"type":"ranking_general"
}
```

| Resource |      URI      |  Method  |
|:--------:|:-------------:|:--------:|
|  **RANKING USER** | `http://URI/api/game.php` | **POST** |

```json
{
  "content-type": "application/json"
}
```

```json
{
"type":"ranking_player",
"user_id": user_id
}
```

## Como citar este conteúdo

```latex
DE SOUZA, Edson Melo (2022, October 6). PHP API GAMES v.1.0.
Available in: https://github.com/EdsonMSouza/apigames
```

Ou BibTeX for LaTeX:

```latex
@misc{desouza2022apigame,
  author = {DE SOUZA, Edson Melo},
  title = {PHP API GAMES v.1.0},
  url = {https://github.com/EdsonMSouza/apigames},
  year = {2022},
  month = {October}
}
```

## Licença

[![CC BY-SA 4.0][cc-by-sa-shield]][cc-by-sa]

Este trabalho é licenciado sob a
[Creative Commons Attribution-ShareAlike 4.0 International License][cc-by-sa].

[![CC BY-SA 4.0][cc-by-sa-image]][cc-by-sa]

[cc-by-sa]: http://creativecommons.org/licenses/by-sa/4.0/

[cc-by-sa-image]: https://licensebuttons.net/l/by-sa/4.0/88x31.png

[cc-by-sa-shield]: https://img.shields.io/badge/License-CC%20BY--SA%204.0-lightgrey.svg

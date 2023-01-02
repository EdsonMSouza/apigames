<?php

// Permite acesso de qualquer origem (requisição)
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 8640000'); // cache for 100 days
}


// Controle e Acesso para os cabeçalhos recebidos durante a requisição
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

}

# Configura o cabeçalho para requisições JSON
header("Content-Type: application/json; charset=utf-8");

# recupera as informações enviadas via serviço
$json = file_get_contents("php://input");

# decodifica os dados enviados no formato JSON para um objeto PHP
$obj = json_decode($json);

# tratar algum erro de requisição
# O nome do operador "=>" é: arrow
if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
    print(json_encode(["data" => "err", "value" => "invalid_data"]));
    die(); # para o processo
}

# Incluindo/importando o arquivo do Modelo do Usuário
include "class/UserModel.php";

# criar usuário - objeto UserModel()
# formato do payload:
# {"type":"new", "name":"Edson Melo de Souza", "user":"edson.melo", "password":"edson123"}

switch ($obj->type) {
    case 'new':
        try {
            $user = new UserModel();

            # verificar se os dados foram enviados corretamente
            if (empty($obj->name) || empty($obj->user) || empty($obj->password)) {
                print(json_encode(["data" => "err", "value" => "invalid_data"]));
                die();
            }

            # verifica se o usuário já existe (igual NULL não retornou nada)
            $result = $user->userExists($obj->user);
            if ($result != null) {
                print(json_encode(["data" => "err", "value" => "user_[" . $obj->user . "]_exists"]));
                die();
            }

            # chama o método que insere no banco
            $result = $user->new($obj->name, $obj->user, $obj->password);

            # verifica o retorno do método
            if ($result != null) {
                print(json_encode(["data" => "ok", "value" => "user_created_successfully"]));
            } else {
                print(json_encode(["data" => "err", "value" => "user_creation_failed"]));
            }
        } catch (Exception $ex) {
            print(json_encode(["data" => "err", "value" => $ex->getMessage()]));
        }
        break;

    case 'login':
        # payload:{"type":"login", "user":"edson.melo", "password":"edson123"}
        try {
            $login = new UserModel();
            if (empty($obj->user) || empty($obj->password)) {
                print(json_encode(["data" => "err", "value" => "invalid_data"]));
                die();
            }
            $result = $login->login($obj->user, $obj->password);

            # verifica se foi retornado algum dado
            if ($result != null) {
                $result["data"] = "ok"; # incluído o campo data para controle
                print(json_encode($result)); # retorna os dados de login
            } else {
                print(json_encode(["data" => "err", "value" => "user_not_found"]));
            }
        } catch (Exception $ex) {
            print(json_encode(["data" => "err", "value" => $ex->getMessage()]));
        }
        break;

    case 'users':
        try {
            $users = new UserModel();

            # retorna todos os usuários cadastrados
            $result = $users->users();

            if ($result != null) {
                $result["data"] = "ok";
                print(json_encode($result));
            } else {
                print(json_encode(["value" => "there_are_no_users_to_list"]));
            }
        } catch (Exception $ex) {
            print(json_encode(["data" => "err", "value" => $ex->getMessage()]));
        }
        break;

    default:
        print(json_encode(["data" => "err", "value" => "invalid_data"]));
        break;
}

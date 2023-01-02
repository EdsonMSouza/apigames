<?php

# envia os dados para API
$array = array("type" => "ranking_general");
$json = json_encode($array);
$ch = curl_init('http://');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($json)));

# recupera os dados retornados da API
$obj = json_decode(curl_exec($ch));

# verifica se ocorreu algum erro na requisição
if ($obj === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["Mensagem:" => "Incorrect Request"]);
    die();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Ranking Geral</title>

    <!-- Importa o Framework Bootstrap para o arquivo -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
</head>

<body>
    <!-- Container principal da aplicação -->
    <div class="container">
        <!-- Aqui vai o resultado da consulta -->
        <div class="col-md-8" style="margin: auto;">
            <br>
            <h1 class="text-center">Ranking Geral dos Jogos</h1>
            <br>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Usuário</th>
                        <th class="text-right" scope="col">Score</th>
                    </tr>
                </thead>

                <?php
                # percore o objeto JSON e mostra os dados
                $contador = 1;
                foreach ($obj as $values) {
                    print("<tr>");
                    print("<td>" . $contador++ . "</td>");
                    print("<td>" . $values->User . "</td>");
                    print("<td class=\"text-right\">" . $values->Score . "</td>");
            }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
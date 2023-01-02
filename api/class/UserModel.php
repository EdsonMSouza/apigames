<?php

/**
 * Model para manipulação de dados dos usuários
 * 
 * @author Edson Melo de Souza
 * @date 2020-03
 * 
 */


# inclusão da classe de conexão com o banco de dados
include('PDOConnection.php');
 
class UserModel
{
    private static $pdo;

    /**
     * Método Construtor da classe UserModel
     */
    function __construct()
    {
        self::$pdo = PDOConnection::connection();
    }

    /**
     * Insere um novo usuário
     * Uma ideia de implementação seria criptografar a senha
     */
    public function new($name, $user, $password): bool
    {
        # variável para armazenar a String SQL
        $sql = "INSERT INTO users (name, user, password)
                VALUES (:name, :user, :password)";

        # variável para armazenar o objeto da conexão que será utilizado para executar as operações
        $stmt = self::$pdo->prepare($sql);

        # atribuição dos valores informados para os parâmetros SQL
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":user", $user);
        $stmt->bindValue(":password", $password);

        # executa a inserção do registro no banco de dados
        $stmt->execute();

        return true;
    }

    /**
     * Método para verificar se um usuário já existe, se sim, retorna TRUE
     */
    public function userExists($user)
    {
        # variável para armazenar a String SQL
        $sql = "SELECT user FROM users 
                WHERE user = :user";

        # variável para armazenar o objeto da conexão que será utilizado para executar as operações
        $stmt = self::$pdo->prepare($sql);

        # atribuição dos valores informados para os parâmetros SQL
        $stmt->bindValue(":user", $user);

        # executa a pesquisa no banco de dados
        $stmt->execute();

        # retorna um objeto - o tratamento deve ser feito no Controller para verificar se há dados retornados
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Métodos para manipulação dos dados de login
     * Uma ideia de implementação seria criptografar a senha
     */
    public function login($user, $password)
    {
        # variável para armazenar a String SQL
        $sql = "SELECT id, user, name FROM users 
                WHERE user = :user AND password = :password";

        # variável para armazenar o objeto da conexão que será utilizado para executar as operações
        $stmt = self::$pdo->prepare($sql);

        # atribuição dos valores informados para os parâmetros SQL
        $stmt->bindValue(":user", $user);
        $stmt->bindValue(":password", $password);

        # executa a pesquisa no banco de dados
        $stmt->execute();

        # retorna um objeto - o tratamento deve ser feito no Controller para verificar se há dados retornados
        return $stmt->fetch(PDO::FETCH_ASSOC); # trocado o tipo do retorno, de objeto para ASSOCIATIVO
    }

    /**
     * Método que retorna TODOS os usuários cadastrados no banco
     * 
     */
    public function users()
    {
        $sql = "SELECT user FROM users ORDER BY name ASC";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        # retorna o conjunto de dados dos usuários
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

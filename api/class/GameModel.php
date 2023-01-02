<?php
include 'PDOConnection.php';
 
class GameModel
{
    private static $pdo;

    public function __construct()
    {
        self::$pdo = PDOConnection::connection();
    }

    function new ($userId) {
        $sql = "INSERT INTO games (user_id) VALUES (:userId)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);

        $stmt->execute();

        # retorna o último ID criado na tabela
        # ID do jogo (game)
        return self::$pdo->lastInsertId();
    }

    /**
     * Salva/Atualiza um jogo criado anteriormente
     */
    public function save($idGame, $score): bool
    {
        $sql = "UPDATE games SET score = :score WHERE id = :idGame";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(":score", $score, PDO::PARAM_INT);
        $stmt->bindValue(":idGame", $idGame, PDO::PARAM_INT);
        $stmt->execute();

        # verificar se foi realmente atualizado
        if ($stmt->rowCount() === 1) { # então atualizou algo
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o ranking de todos os jogadores
     * Ou, se for apenas um usuário (mono), o seu ranking
     */
    public function rankingGeneral()
    {
        $sql = 'SELECT users.user AS User, max(games.score) AS Score
                FROM games
                INNER JOIN users
                ON games.user_id = users.id
                GROUP BY users.name
                HAVING Score > 0
                ORDER BY Score DESC';

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Ranking por jogador
     */
    public function rankingByPlayer($userId)
    {
        $sql = "SELECT users.user AS User, games.id AS IDGame, games.score AS Score
                FROM games
                INNER JOIN users
                ON games.user_id = users.id
                WHERE games.user_id = :userId
                HAVING Score > 0
                ORDER BY Score DESC";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

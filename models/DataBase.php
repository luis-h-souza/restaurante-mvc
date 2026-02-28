<?php

# estabelece a conexão com o banco de dados
class DataBase
{
    # atributo privado e estático
    private static $conexao = null;

    # método público e estático
    public static function getConexao()
    {

        # self faz referencia a própria classe
        # testa se a conexão já exite para evitar uma nova conexão
        if (self::$conexao == null) {
            # Configurações do banco - suporte a Docker e local
            $host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: "localhost";
            $nomeDoBanco = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: "restaurante-mvc";
            $usuario = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: "root";
            $senha = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?: "";

            try {
                self::$conexao = new PDO(   // crio a conexão
                    "mysql:host=$host;dbname=$nomeDoBanco",
                    $usuario,
                    $senha
                );
                self::$conexao->setAttribute( // como será tratado o erro caso houver
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            } catch (PDOException $erro) {  // classe do php que trata erros
                echo "Erro de conexão: " . $erro->getMessage();
            }
        }
        return self::$conexao; // devolvo a conexão já existente
    }
}

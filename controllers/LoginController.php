<?php
# inclui o arquivo model
require_once "models/LoginModel.php";

class LoginController
{
    private $LoginModel;

    public function __construct()
    {
        $this->LoginModel = new Login();
    }

    public function index()
    {
        # recebe o valor da propriedade $url e fica disponível para uso da view
        $baseUrl = BASE_URL;
        $erro = "";
        require "views/LoginForm.php";
    }

    // $usuario = "adm";
    // $senha = "admin";

    public function criar()
    {
        $nome = "";
        $usuario = "";
        $senha = "";
        $nivelAcesso = "";
        $this->LoginModel->insert($nome, $usuario, $senha, $nivelAcesso);
    }

    public function autenticar()
    {
        # recupera os valores informados no formulário de login
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        $manter_logado = isset($_POST["manter_logado"]) ? true : false;

        # chama o model para verificar se os dados são válidos
        $autenticado = $this->LoginModel->getByUsuarioESenha($usuario, $senha, $manter_logado);

        # Se a autenticação falhou, exibimos o formulário novamente com mensagem de erro
        if (!$autenticado) {
            $erro = "<div class='alert alert-danger'><small>Não foi possível efetuar o login. Tente novamente</small></div>";
            $baseUrl = BASE_URL;
            require "views/LoginForm.php";
            return;
        }

        # Login bem-sucedido: redireciona para mesa-adm
        $destino = BASE_URL . "/mesa-adm";

        if (!headers_sent()) {
            header("Location: " . $destino);
            exit();
        }

        // Fallback caso os headers já tenham sido enviados
        echo "<script>window.location.href = '" . $destino . "';</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=" . htmlspecialchars($destino, ENT_QUOTES, 'UTF-8') . "'></noscript>";
        exit();
    }
}

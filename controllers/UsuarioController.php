<?php
require_once "models/UsuarioModel.php";

class UsuarioController
{
    # url é uma propriedade pois está sendo criada dentro da classe
    # criar uma propriedade que receba o endereço absoluto do site
    # este endereço será usado para compor as rotas
    
    private $usuarioModel;

    public function __construct()
    {
        # instancia a classe Mesa para obter os dados do model
        $this->usuarioModel = new Usuario;
    }

    public function index()
    {
        $lista_usuarios = $this->usuarioModel->getUsuarios();

        # recebe o valor da propriedade $url e fica disponível para uso da view
        $baseUrl = $this->baseUrl;
        $erro = "";
        require "views/UsuarioView.php";
    }

    public function inserir()
    {
        validaSessao();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Método inválido.";
            header("Location: " . $this->baseUrl . "/usuario-adm/criar");
            exit;
        }

        $nome = $_POST['nome'] ?? '';
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $nivelAcesso = $_POST['nivelAcesso'] ?? '';

        // Validação dos campos obrigatórios
        if (empty($nome) || empty($usuario) || empty($senha) || empty($nivelAcesso)) {
            $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
            $baseUrl = $this->baseUrl;
            $acao = "criar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
            exit;
        }

        // Verificar se o usuário já existe
        if ($this->usuarioModel->usuarioExists($usuario)) {
            $_SESSION['error'] = "O usuário '$usuario' já existe. Escolha outro.";
            $baseUrl = $this->baseUrl;
            $acao = "criar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
            exit;
        }

        // Inserir o usuário
        $resultado = $this->usuarioModel->insert($nome, $usuario, $senha, $nivelAcesso);

        if ($resultado) {
            $_SESSION['success'] = "Usuário criado com sucesso.";
            header("Location: " . $this->baseUrl . "/usuario-adm");
        } else {
            $_SESSION['error'] = "Erro ao criar usuário.";
            $baseUrl = $this->baseUrl;
            $acao = "criar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
        }
    }

    public function criar()
    {
        validaSessao();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->inserir(); // Chama o método inserir para processar o formulário
            exit;
        }

        $baseUrl = $this->baseUrl;
        $nome = "";
        $usuario_nome = "";
        $senha = "";
        $nivelAcesso = "";
        $idUsuario = "";
        $acao = "criar";
        require "views/UsuarioForm.php";
    }

    public function excluir($id)
    {
        # executa o método da classe de Mdel
        $this->usuarioModel->delete($id);
        # redireciona o usuário para a listagem de mesas
        header("location: " . $this->baseUrl . "/usuario-adm");
    }

    # método usado para chamar o formulário de alteração de senha - passo 1
    # usuario/alterarSenha
    public function alterarSenha($idUsuario)
    {
        $baseUrl = $this->baseUrl;
        require "views/AtualizarSenha.php";
    }

    # método utilizado para receber dados do formulário de alteração de senha - passo 2
    # /usuario/atualizarSenha
    public function atualizarSenha($idUsuario = null)
    {
        $senha = $_POST['senha'];
        $this->usuarioModel->updateSenha($idUsuario, $senha);
        header("Location: " . $this->baseUrl . "/usuario-adm");
    }

    # UsuarioController.php
    public function editar($idUsuario)
    {
        validaSessao();
        $usuario = $this->usuarioModel->getById($idUsuario);

        if (!$usuario || !is_array($usuario)) {
            $_SESSION['error'] = "Usuário não encontrado ou dados inválidos.";
            header("Location: " . $this->baseUrl . "/usuario-adm");
            exit;
        }

        $baseUrl = $this->baseUrl;
        $nome = $usuario['nome'] ?? '';
        $usuario_nome = $usuario['usuario'] ?? '';
        $nivelAcesso = $usuario['nivelAcesso'] ?? '';
        $idUsuario = $usuario['idUsuario'] ?? $idUsuario;
        $acao = "atualizar";
        require "views/UsuarioForm.php";
    }

    # UsuarioController.php
    public function atualizar()
    {
        validaSessao();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Método inválido.";
            header("Location: " . $this->baseUrl . "/usuario-adm");
            exit;
        }

        $idUsuario = $_POST['idUsuario'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $usuario = $_POST['usuario'] ?? '';
        $nivelAcesso = $_POST['nivelAcesso'] ?? '';

        // Validação dos campos obrigatórios
        if (empty($idUsuario) || empty($nome) || empty($usuario) || empty($nivelAcesso)) {
            $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
            $baseUrl = $this->baseUrl;
            $acao = "atualizar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
            exit;
        }

        // Verificar se o usuário já existe (exceto o próprio)
        $existingUser = $this->usuarioModel->usuarioExists($usuario);
        $currentUser = $this->usuarioModel->getById($idUsuario);
        if ($existingUser && $currentUser['usuario'] !== $usuario) {
            $_SESSION['error'] = "O usuário '$usuario' já existe. Escolha outro.";
            $baseUrl = $this->baseUrl;
            $acao = "atualizar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
            exit;
        }

        // Atualizar usuário (sem senha)
        $resultado = $this->usuarioModel->update($idUsuario, $nome, $usuario, $nivelAcesso);

        if ($resultado) {
            $_SESSION['success'] = "Usuário atualizado com sucesso.";
            header("Location: " . $this->baseUrl . "/usuario-adm");
        } else {
            $_SESSION['error'] = "Erro ao atualizar usuário.";
            $baseUrl = $this->baseUrl;
            $acao = "atualizar";
            $usuario_nome = $usuario;
            $nome = $nome;
            $nivelAcesso = $nivelAcesso;
            require "views/UsuarioForm.php";
        }
    }
}

<?php
# inclui o arquivo model
require_once "models/ReservaModel.php";
require_once "models/MesaModel.php";

class ReservaController
{
  # url é uma propriedade pois está sendo criada dentro da classe
  # criar uma propriedade que receba o endereço absoluto do site
  # este endereço será usado para compor as rotas

  private $baseUrl;
  private $reservaModel;
  private $mesaModel;

  public function __construct()
  {
    # instancia as classes para obter os dados dos models
    $this->reservaModel = new Reserva();
    $this->mesaModel = new Mesa();
    $this->baseUrl = BASE_URL;
  }

  # Página pública de reservas
  public function index()
  {
    $baseUrl = $this->baseUrl;
    $erro = "";
    $sucesso = "";
    require "views/ReservaView.php";
  }

  # Página administrativa de reservas
  public function adm()
  {
    validaSessao();
    $lista_reservas = $this->reservaModel->getAllReservas();
    $estatisticas = $this->reservaModel->getEstatisticas();
    $baseUrl = $this->baseUrl;
    require "views/ReservaAdmView.php";
  }

  # Formulário de nova reserva
  public function nova() {
    $baseUrl = $this->baseUrl;
    $nome = "";
    $email = "";
    $telefone = "";
    $data_reserva = "";
    $hora_reserva = "";
    $numero_pessoas = "";
    $observacoes = "";
    require "views/ReservaForm.php";
}

  # Processar nova reserva
  public function criar()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $baseUrl = $this->baseUrl;
      $nome = "";
      $email = "";
      $telefone = "";
      $data_reserva = "";
      $hora_reserva = "";
      $numero_pessoas = "";
      $observacoes = "";
      require "views/ReservaForm.php";
      return;
    }

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_reserva = $_POST['data_reserva'] ?? '';
    $hora_reserva = $_POST['hora_reserva'] ?? '';
    $numero_pessoas = $_POST['numero_pessoas'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($email) || empty($telefone) || empty($data_reserva) || empty($hora_reserva) || empty($numero_pessoas)) {
      $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
      $baseUrl = $this->baseUrl;
      $erro = $_SESSION['error'];
      require "views/ReservaForm.php";
      return;
    }

    // Verificar disponibilidade
    $mesas_disponiveis = $this->reservaModel->checkDisponibilidade($data_reserva, $hora_reserva, $numero_pessoas);

    if (empty($mesas_disponiveis)) {
      $_SESSION['error'] = "Não há mesas disponíveis para esta data e horário.";
      $baseUrl = $this->baseUrl;
      $erro = $_SESSION['error'];
      require "views/ReservaForm.php";
      return;
    }

    // Usar a primeira mesa disponível
    $idMesa = $mesas_disponiveis[0]['id'];

    // Criar reserva
    $resultado = $this->reservaModel->insert($nome, $email, $telefone, $data_reserva, $hora_reserva, $numero_pessoas, $idMesa, $observacoes);

    if ($resultado) {
      $_SESSION['success'] = "Reserva criada com sucesso.";
        $baseUrl = $this->baseUrl;
        $success_redirect = $this->baseUrl . "/reserva/adm"; // URL para redirecionamento
        require "views/ReservaForm.php"; // Renderiza a view com a mensagem
    } else {
      $_SESSION['error'] = "Erro ao criar reserva. Tente novamente.";
      $baseUrl = $this->baseUrl;
      $erro = $_SESSION['error'];
      require "views/ReservaForm.php";
    }
  }

  # Verificar disponibilidade via AJAX
  public function verificar_disponibilidade()
  {
    try {
      $data = $_POST['data'] ?? null;
      $hora = $_POST['hora'] ?? null;
      $numero_pessoas = $_POST['numero_pessoas'] ?? null;
      $idReserva = $_POST['idReserva'] ?? null; // Para edição

      if (!$data || !$hora || !$numero_pessoas) {
        throw new Exception('Dados incompletos');
      }

      $mesasDisponiveis = $this->reservaModel->checkDisponibilidade($data, $hora, $numero_pessoas, $idReserva);

      header('Content-Type: application/json');
      echo json_encode(['disponivel' => !empty($mesasDisponiveis)]);
    } catch (Exception $e) {
      header('Content-Type: application/json', true, 400);
      echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
  }

  # Editar reserva (admin)
  public function editar($idReserva)
  {
    validaSessao();
    $reserva = $this->reservaModel->getById($idReserva);
    $mesas = $this->mesaModel->getAllMesas();
    $baseUrl = $this->baseUrl;

    if (!$reserva) {
      $_SESSION['error'] = "Reserva não encontrada.";
      header("Location: " . $this->baseUrl . "/reserva-adm");
      exit;
    }

    require "views/ReservaEditForm.php";
  }

  # Atualizar reserva (admin)
  public function atualizar($idReserva)
  {
    validaSessao();
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $_SESSION['error'] = "Método inválido.";
      header("Location: " . $this->baseUrl . "/reserva-adm");
      exit;
    }

    // Validação dos campos obrigatórios
    $requiredFields = ['nome', 'telefone', 'data_reserva', 'hora_reserva', 'numero_pessoas', 'status'];
    foreach ($requiredFields as $field) {
      if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $_SESSION['error'] = "Preencha todos os campos obrigatórios.";
        $reserva = $this->reservaModel->getById($idReserva);
        $mesas = $this->mesaModel->getAllMesas();
        $baseUrl = $this->baseUrl;
        require "views/ReservaEditForm.php";
        exit;
      }
    }

    // Dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'];
    $data_reserva = $_POST['data_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $numero_pessoas = (int)$_POST['numero_pessoas'];
    $idMesa = !empty($_POST['idMesa']) ? (int)$_POST['idMesa'] : null;
    $observacoes = $_POST['observacoes'] ?? '';
    $status = $_POST['status'];

    // Validar status
    $validStatuses = ['pendente', 'confirmada', 'cancelada'];
    if (!in_array($status, $validStatuses)) {
      $_SESSION['error'] = "Status inválido.";
      $reserva = $this->reservaModel->getById($idReserva);
      $mesas = $this->mesaModel->getAllMesas();
      $baseUrl = $this->baseUrl;
      require "views/ReservaEditForm.php";
      exit;
    }

    // Atualizar a reserva
    $resultado = $this->reservaModel->update($idReserva, $nome, $email, $telefone, $data_reserva, $hora_reserva, $numero_pessoas, $idMesa, $observacoes, $status);

    if ($resultado) {
      $_SESSION['success'] = "Reserva atualizada com sucesso.";
      header("Location: " . $this->baseUrl . "/reserva-adm");
    } else {
      $_SESSION['error'] = "Erro ao atualizar reserva.";
      $reserva = $this->reservaModel->getById($idReserva);
      $mesas = $this->mesaModel->getAllMesas();
      $baseUrl = $this->baseUrl;
      require "views/ReservaEditForm.php";
    }
  }

  # Atualizar status da reserva
  public function atualizar_status($idReserva)
  {
    validaSessao();
    if (!isset($_POST['status']) || empty($_POST['status'])) {
      $_SESSION['error'] = "Status não fornecido.";
      header("location: " . $this->baseUrl . "/reserva/adm");
      exit;
    }
    $status = $_POST['status'];
    $validStatuses = ['pendente', 'confirmada', 'cancelada']; // Status válidos
    if (!in_array($status, $validStatuses)) {
      $_SESSION['error'] = "Status inválido.";
      header("location: " . $this->baseUrl . "/reserva/adm");
      exit;
    }
    $this->reservaModel->updateStatus($idReserva, $status);
    header("location: " . $this->baseUrl . "/reserva/adm");
  }

  # Excluir reserva
  public function excluir($idReserva)
  {
    validaSessao();
    $this->reservaModel->delete($idReserva);
    header("location: " . $this->baseUrl . "/reserva/adm");
  }
}

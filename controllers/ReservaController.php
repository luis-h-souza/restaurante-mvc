<?php
# inclui o arquivo model
require_once "models/ReservaModel.php";
require_once "models/MesaModel.php";

class ReservaController
{
  # url é uma propriedade pois está sendo criada dentro da classe
  # criar uma propriedade que receba o endereço absoluto do site
  # este endereço será usado para compor as rotas
  public $baseUrl = "http://localhost:8080";
  private $reservaModel;
  private $mesaModel;

  public function __construct()
  {
    # instancia as classes para obter os dados dos models
    $this->reservaModel = new Reserva();
    $this->mesaModel = new Mesa();
  }

  # Página pública de reservas
  public function index() {
    $baseUrl = $this->baseUrl;
    $erro = "";
    $sucesso = "";
    require "views/ReservaView.php";
  }

  # Página administrativa de reservas
  public function adm() {
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
    $mesas_disponiveis = [];
    $erro = "";
    require "views/ReservaForm.php";
  }

  # Processar nova reserva
  public function criar() {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_reserva = $_POST['data_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $numero_pessoas = $_POST['numero_pessoas'];
    $observacoes = $_POST['observacoes'];

    # Verificar disponibilidade
    $mesas_disponiveis = $this->reservaModel->checkDisponibilidade($data_reserva, $hora_reserva, $numero_pessoas);
    
    if (empty($mesas_disponiveis)) {
      $erro = "Não há mesas disponíveis para esta data e horário.";
      $baseUrl = $this->baseUrl;
      require "views/ReservaForm.php";
      return;
    }

    # Usar a primeira mesa disponível
    $idMesa = $mesas_disponiveis[0]['id'];

    # Criar reserva
    $resultado = $this->reservaModel->insert($nome, $email, $telefone, $data_reserva, $hora_reserva, $numero_pessoas, $idMesa, $observacoes);

    if ($resultado) {
      header("location: " . $this->baseUrl . "/reserva?sucesso=1");
    } else {
      $erro = "Erro ao criar reserva. Tente novamente.";
      $baseUrl = $this->baseUrl;
      require "views/ReservaForm.php";
    }
  }

  # Verificar disponibilidade via AJAX
  public function verificar_disponibilidade() {
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $numero_pessoas = $_POST['numero_pessoas'];
    
    $mesas_disponiveis = $this->reservaModel->checkDisponibilidade($data, $hora, $numero_pessoas);
    
    header('Content-Type: application/json');
    echo json_encode([
      'disponivel' => !empty($mesas_disponiveis),
      'mesas' => $mesas_disponiveis
    ]);
  }

  # Editar reserva (admin)
  public function editar($idReserva) {
    validaSessao();
    $reserva = $this->reservaModel->getById($idReserva);
    $mesas = $this->mesaModel->getAllMesas();
    $baseUrl = $this->baseUrl;
    require "views/ReservaEditForm.php";
  }

  # Atualizar reserva (admin)
  public function atualizar($idReserva) {
    validaSessao();
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $data_reserva = $_POST['data_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $numero_pessoas = $_POST['numero_pessoas'];
    $idMesa = $_POST['idMesa'];
    $observacoes = $_POST['observacoes'];
    $status = $_POST['status'];

    $resultado = $this->reservaModel->update($idReserva, $nome, $email, $telefone, $data_reserva, $hora_reserva, $numero_pessoas, $idMesa, $observacoes, $status);

    if ($resultado) {
      header("location: " . $this->baseUrl . "/reserva/adm");
    } else {
      $erro = "Erro ao atualizar reserva.";
      $reserva = $this->reservaModel->getById($idReserva);
      $mesas = $this->mesaModel->getAllMesas();
      $baseUrl = $this->baseUrl;
      require "views/ReservaEditForm.php";
    }
  }

  # Atualizar status da reserva
  public function atualizar_status($idReserva) {
    validaSessao();
    $status = $_POST['status'];
    $this->reservaModel->updateStatus($idReserva, $status);
    header("location: " . $this->baseUrl . "/reserva/adm");
  }

  # Excluir reserva
  public function excluir($idReserva) {
    validaSessao();
    $this->reservaModel->delete($idReserva);
    header("location: " . $this->baseUrl . "/reserva/adm");
  }
}
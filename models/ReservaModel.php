<?php

# incluir o arquivo com a conexão com o banco de dados
require_once "DataBase.php";

class Reserva
{
  # criar um atributo privado para receber a conexão com o banco de dados
  private $db;

  # método construtor da classe. Ele será executado, quando a classe for instanciada.
  public function __construct()
  {
    # executa o método estático para estabelecer a conexão com o banco de dados
    $this->db = DataBase::getConexao();
  }

  # criar um método para retornar todas as reservas
  public function getAllReservas() {
    $sql = $this->db->prepare("
      SELECT r.*, m.lugares, m.tipo 
      FROM reservas r 
      LEFT JOIN mesas m ON r.idMesa = m.id 
      ORDER BY r.data_reserva DESC, r.hora_reserva DESC
    ");
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  # método para retornar uma reserva específica
  public function getById($idReserva) {
    $sql = $this->db->prepare("
      SELECT r.*, m.lugares, m.tipo 
      FROM reservas r 
      LEFT JOIN mesas m ON r.idMesa = m.id 
      WHERE r.idReserva = ?
    ");
    $sql->execute([$idReserva]);
    return $sql->fetch(PDO::FETCH_ASSOC);
  }

  # método para retornar reservas por data
  public function getByDate($data) {
    $sql = $this->db->prepare("
      SELECT r.*, m.lugares, m.tipo 
      FROM reservas r 
      LEFT JOIN mesas m ON r.idMesa = m.id 
      WHERE r.data_reserva = ? 
      ORDER BY r.hora_reserva ASC
    ");
    $sql->execute([$data]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  # método para verificar disponibilidade de mesa
  public function checkDisponibilidade($data, $hora, $numeroPessoas) {
    $sql = $this->db->prepare("
      SELECT m.* 
      FROM mesas m 
      WHERE m.lugares >= ? 
      AND m.id NOT IN (
        SELECT r.idMesa 
        FROM reservas r 
        WHERE r.data_reserva = ? 
        AND r.hora_reserva = ? 
        AND r.status IN ('pendente', 'confirmada')
      )
      ORDER BY m.lugares ASC
    ");
    $sql->execute([$numeroPessoas, $data, $hora]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  # método para criar nova reserva
  public function insert($nome, $email, $telefone, $dataReserva, $horaReserva, $numeroPessoas, $idMesa, $observacoes) {
    $sql = $this->db->prepare("
      INSERT INTO reservas (nome, email, telefone, data_reserva, hora_reserva, numero_pessoas, idMesa, observacoes, status) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendente')
    ");
    return $sql->execute([$nome, $email, $telefone, $dataReserva, $horaReserva, $numeroPessoas, $idMesa, $observacoes]);
  }

  # método para atualizar reserva
  public function update($idReserva, $nome, $email, $telefone, $dataReserva, $horaReserva, $numeroPessoas, $idMesa, $observacoes, $status) {
    $sql = $this->db->prepare("
      UPDATE reservas 
      SET nome=?, email=?, telefone=?, data_reserva=?, hora_reserva=?, numero_pessoas=?, idMesa=?, observacoes=?, status=? 
      WHERE idReserva=?
    ");
    return $sql->execute([$nome, $email, $telefone, $dataReserva, $horaReserva, $numeroPessoas, $idMesa, $observacoes, $status, $idReserva]);
  }

  # método para atualizar status da reserva
  public function updateStatus($idReserva, $status) {
    $sql = $this->db->prepare("UPDATE reservas SET status=? WHERE idReserva=?");
    return $sql->execute([$status, $idReserva]);
  }

  # método para excluir reserva
  public function delete($idReserva) {
    $sql = $this->db->prepare("DELETE FROM reservas WHERE idReserva=?");
    return $sql->execute([$idReserva]);
  }

  # método para obter estatísticas
  public function getEstatisticas() {
    $sql = $this->db->query("
      SELECT 
        COUNT(*) as total_reservas,
        SUM(CASE WHEN status = 'confirmada' THEN 1 ELSE 0 END) as confirmadas,
        SUM(CASE WHEN status = 'pendente' THEN 1 ELSE 0 END) as pendentes,
        SUM(CASE WHEN status = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
        SUM(CASE WHEN data_reserva = CURDATE() THEN 1 ELSE 0 END) as hoje
      FROM reservas
    ");
    return $sql->fetch(PDO::FETCH_ASSOC);
  }
}

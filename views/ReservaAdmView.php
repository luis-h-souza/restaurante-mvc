<?php
$header = file_get_contents("views/templates/html/header.html");
$footer = file_get_contents("views/templates/html/footer.html");
$header = str_replace("[[base-url]]", $baseUrl, $header);
$footer = str_replace("[[base-url]]", $baseUrl, $footer);

echo $header;
?>

<main>
  <section class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <span class="fs-3"><span class="text-primary"><i class="bi bi-calendar-check me-2"></i></span><strong>Gerenciamento de Reservas</strong></span>
      </div>
      <div class="col-md-6 text-end">
        <a href="<?= $baseUrl ?>/reserva/nova" class="btn btn-sm btn-primary btns">
          <b><i class="bi bi-plus-circle me-1"></i></b>Nova Reserva
        </a>
        <a href="<?= $baseUrl ?>/reserva" class="btn btn-sm btn-info btns" target="_blank">
          <b><i class="bi bi-eye me-1"></i></b>Ver Site
        </a>
      </div>
    </div>
  </section>

  <!-- Estatísticas -->
  <section class="container mt-4">
    <div class="row">
      <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4><?= $estatisticas['total_reservas'] ?></h4>
                <p class="mb-0">Total de Reservas</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-calendar3 fs-1"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4><?= $estatisticas['confirmadas'] ?></h4>
                <p class="mb-0">Confirmadas</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-check-circle fs-1"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4><?= $estatisticas['pendentes'] ?></h4>
                <p class="mb-0">Pendentes</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-clock fs-1"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h4><?= $estatisticas['hoje'] ?></h4>
                <p class="mb-0">Hoje</p>
              </div>
              <div class="align-self-center">
                <i class="bi bi-calendar-day fs-1"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Lista de Reservas -->
  <section class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Lista de Reservas</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Contato</th>
                <th>Data/Hora</th>
                <th>Pessoas</th>
                <th>Mesa</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($lista_reservas as $reserva): ?>
                <tr>
                  <td><?= $reserva['idReserva'] ?></td>
                  <td><?= htmlspecialchars($reserva['nome']) ?></td>
                  <td>
                    <small>
                      <?= htmlspecialchars($reserva['email']) ?><br>
                      <?= htmlspecialchars($reserva['telefone']) ?>
                    </small>
                  </td>
                  <td>
                    <small>
                      <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?><br>
                      <?= date('H:i', strtotime($reserva['hora_reserva'])) ?>
                    </small>
                  </td>
                  <td><?= $reserva['numero_pessoas'] ?></td>
                  <td>
                    <?php if ($reserva['idMesa']): ?>
                      Mesa #<?= $reserva['idMesa'] ?> (<?= $reserva['lugares'] ?> lugares)
                    <?php else: ?>
                      <span class="text-muted">Não atribuída</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php
                    $statusClass = '';
                    switch ($reserva['status']) {
                      case 'confirmada':
                        $statusClass = 'success';
                        break;
                      case 'pendente':
                        $statusClass = 'warning';
                        break;
                      case 'cancelada':
                        $statusClass = 'danger';
                        break;
                      default:
                        $statusClass = 'secondary';
                    }
                    ?>
                    <span class="badge bg-<?= $statusClass ?>">
                      <?= ucfirst($reserva['status']) ?>
                    </span>
                  </td>
                  <td>
                    <div class="btn-group" role="group">
                      <a href="<?= $baseUrl ?>/reserva/editar/<?= $reserva['idReserva'] ?>" 
                         class="btn btn-sm btn-outline-primary" title="Editar">
                        <i class="bi bi-pencil"></i>
                      </a>
                      
                      <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                data-bs-toggle="dropdown" title="Status">
                          <i class="bi bi-gear"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="<?= $baseUrl ?>/reserva/atualizar_status/<?= $reserva['idReserva'] ?>" 
                                 onclick="return confirm('Confirmar reserva?')">
                            <i class="bi bi-check-circle text-success me-2"></i>Confirmar
                          </a></li>
                          <li><a class="dropdown-item" href="<?= $baseUrl ?>/reserva/atualizar_status/<?= $reserva['idReserva'] ?>" 
                                 onclick="return confirm('Cancelar reserva?')">
                            <i class="bi bi-x-circle text-danger me-2"></i>Cancelar
                          </a></li>
                        </ul>
                      </div>
                      
                      <a href="<?= $baseUrl ?>/reserva/excluir/<?= $reserva['idReserva'] ?>" 
                         class="btn btn-sm btn-outline-danger" title="Excluir"
                         onclick="return confirm('Tem certeza que deseja excluir esta reserva?')">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
echo $footer;
?>

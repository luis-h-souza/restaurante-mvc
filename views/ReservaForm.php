<?php
$header = file_get_contents("views/templates/html/header_site.html");
$footer = file_get_contents("views/templates/html/footer_site.html");
$header = str_replace("[[base-url]]", $baseUrl, $header);
$footer = str_replace("[[base-url]]", $baseUrl, $footer);

echo $header;
?>

<main>
  <section class="container mt-5">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Nova Reserva</h2>
          </div>
          <div class="card-body">
            
            <?php if (isset($erro) && $erro != ""): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erro:</strong> <?= $erro ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/reserva/criar" method="post">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nome" class="form-label">Nome Completo *</label>
                  <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">E-mail *</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="telefone" class="form-label">Telefone *</label>
                  <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= $telefone ?>" placeholder="(11) 99999-9999" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="numero_pessoas" class="form-label">Número de Pessoas *</label>
                  <select class="form-select" id="numero_pessoas" name="numero_pessoas" required>
                    <option value="">Selecione...</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                      <option value="<?= $i ?>" <?= $numero_pessoas == $i ? 'selected' : '' ?>>
                        <?= $i ?> pessoa<?= $i > 1 ? 's' : '' ?>
                      </option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="data_reserva" class="form-label">Data da Reserva *</label>
                  <input type="date" class="form-control" id="data_reserva" name="data_reserva" value="<?= $data_reserva ?>" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="hora_reserva" class="form-label">Horário *</label>
                  <select class="form-select" id="hora_reserva" name="hora_reserva" required>
                    <option value="">Selecione...</option>
                    <?php
                    $horarios = ['18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00'];
                    foreach ($horarios as $horario):
                    ?>
                      <option value="<?= $horario ?>" <?= $hora_reserva == $horario ? 'selected' : '' ?>>
                        <?= $horario ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Alguma observação especial? (aniversário, alergias, etc.)"><?= $observacoes ?></textarea>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= $baseUrl ?>/reserva" class="btn btn-secondary me-md-2">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-calendar-check me-2"></i>Fazer Reserva
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
echo $footer;
?>

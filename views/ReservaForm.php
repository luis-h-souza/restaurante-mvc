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
          <div class="card-header bgd-primary text-white">
            <h2 class="mb-0"><i class="bi bi-calendar-plus me-2"></i>Nova Reserva</h2>
          </div>
          <div class="card-body">

            <?php if (isset($_SESSION['error']) && $_SESSION['error']): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erro:</strong> <?= htmlspecialchars($_SESSION['error'] ?? '') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Sucesso:</strong> <?= htmlspecialchars($_SESSION['success'] ?? '') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['success']); ?>
              <?php if (isset($success_redirect)): ?>
                <script>
                  setTimeout(function() {
                    window.location.href = "<?= $success_redirect ?>";
                  }, 3000); // Redireciona após 3 segundos
                </script>
              <?php endif; ?>
            <?php endif; ?>

            <?php if (!isset($success_redirect)): ?>

              <form action="<?= $baseUrl ?>/reserva/criar" method="post">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome ?? '') ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail *</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone *</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($telefone ?? '') ?>" placeholder="(11) 99999-9999" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="numero_pessoas" class="form-label">Número de Pessoas *</label>
                    <select class="form-select" id="numero_pessoas" name="numero_pessoas" required>
                      <option value="">Selecione...</option>
                      <option value="1">1 pessoa</option>
                      <option value="2">2 pessoas</option>
                      <option value="3">3 pessoas</option>
                      <option value="4">4 pessoas</option>
                      <option value="5">5 pessoas</option>
                      <option value="6">6 pessoas</option>
                      <option value="7">7 pessoas</option>
                      <option value="8">8 pessoas</option>
                      <option value="9">9 pessoas</option>
                      <option value="10">10 pessoas</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="data_reserva" class="form-label">Data da Reserva *</label>
                    <input type="date" class="form-control" id="data_reserva" name="data_reserva" value="<?= htmlspecialchars($data_reserva ?? '') ?>" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="hora_reserva" class="form-label">Horário *</label>
                    <select class="form-select" id="hora_reserva" name="hora_reserva" required>
                      <option value="">Selecione...</option>
                      <option value="18:00">18:00</option>
                      <option value="18:30">18:30</option>
                      <option value="19:00">19:00</option>
                      <option value="19:30">19:30</option>
                      <option value="20:00">20:00</option>
                      <option value="20:30">20:30</option>
                      <option value="21:00">21:00</option>
                      <option value="21:30">21:30</option>
                      <option value="22:00">22:00</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea class="form-control" id="observacoes" name="observacoes" placeholder="Alguma observação especial? (aniversário, alergias, etc.)"><?= htmlspecialchars($observacoes ?? '') ?></textarea>
                  </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a href="<?= $baseUrl ?>/reserva/adm" class="btn btn-secondary me-md-2">
                    <i class="bi bi-arrow-left me-2"></i>Voltar
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Fazer Reserva
                  </button>
                </div>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
echo $footer;
?>

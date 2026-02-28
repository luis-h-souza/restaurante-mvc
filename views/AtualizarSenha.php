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
            <h2 class="mb-0"><i class="bi bi-lock-fill me-2"></i>Atualizar Senha</h2>
          </div>
          <div class="card-body">
            
            <?php if (isset($_SESSION['error']) && $_SESSION['error']): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erro:</strong> <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Sucesso:</strong> <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/usuario-adm/atualizarSenha" method="post">
              <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario) ?>">
              
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="senha" class="form-label">Nova Senha *</label>
                  <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= $baseUrl ?>/usuario/adm" class="btn btn-secondary me-md-2">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save me-2"></i>Salvar Alterações
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

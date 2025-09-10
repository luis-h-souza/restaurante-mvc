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
            <h2 class="mb-0"><i class="bi bi-person-plus me-2"></i><?= $acao == 'criar' ? 'Criar Usuário' : 'Editar Usuário' ?></h2>
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
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/usuario-adm/<?= $acao ?>" method="post">
              <?php if ($idUsuario): ?>
                <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($idUsuario) ?>">
              <?php endif; ?>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nome" class="form-label">Nome Completo *</label>
                  <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="usuario" class="form-label">Usuário *</label>
                  <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($usuario_nome ?? '') ?>" required>
                </div>
              </div>

              <?php if ($acao == 'criar'): ?>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="senha" class="form-label">Senha *</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                  </div>
                </div>
              <?php endif; ?>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nivelAcesso" class="form-label">Nível de Acesso *</label>
                  <select class="form-select" id="nivelAcesso" name="nivelAcesso" required>
                    <option value="">Selecione...</option>
                    <option value="admin" <?= $nivelAcesso == 'admin' ? 'selected' : '' ?>>Administrador</option>
                    <option value="usuario" <?= $nivelAcesso == 'usuario' ? 'selected' : '' ?>>Usuário</option>
                  </select>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= $baseUrl ?>/usuario-adm" class="btn btn-secondary me-md-2">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save me-2"></i><?= $acao == 'criar' ? 'Criar Usuário' : 'Salvar Alterações' ?>
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
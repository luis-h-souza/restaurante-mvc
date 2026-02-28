<?php

$header = file_get_contents("views/templates/html/header.html");
$footer = file_get_contents("views/templates/html/footer.html");
$header = str_replace("[[base-url]]", $baseUrl, $header);
$footer = str_replace("[[base-url]]", $baseUrl, $footer);

echo $header;
?>

<main>
  <section class="container mt-5">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="card shadow">
          <div class="card-header bgd-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
              <i class="bi bi-journal-text me-2"></i>
              <?= $acao == 'criar' ? 'Criar Item de Cardápio' : 'Editar Item de Cardápio' ?>
            </h2>
            
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

            <form action="<?= $baseUrl ?>/cardapio-adm/atualizar" method="post">
              <div class="row">
                <div class="col-md-8 mb-3">
                  <label for="nome" class="form-label">Nome do prato *</label>
                  <input
                    class="form-control"
                    type="text"
                    name="nome"
                    id="nome"
                    value="<?= htmlspecialchars($nome ?? '') ?>"
                    required
                    placeholder="Digite o nome do prato"
                  >
                </div>
                <div class="col-md-4 mb-3">
                  <label for="preco" class="form-label">Preço *</label>
                  <input
                    class="form-control"
                    type="number"
                    name="preco"
                    id="preco"
                    min="0"
                    step="0.01"
                    value="<?= htmlspecialchars($preco ?? '') ?>"
                    required
                    placeholder="Valor do prato"
                  >
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="tipo" class="form-label">Tipo *</label>
                  <select name="tipo" id="tipo" class="form-select" required>
                    <?= $tipo ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="foto" class="form-label">URL da foto *</label>
                  <input
                    class="form-control"
                    type="url"
                    name="foto"
                    id="foto"
                    value="<?= htmlspecialchars($foto ?? '') ?>"
                    required
                    placeholder="https://exemplo.com/imagem.jpg"
                  >
                </div>
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição *</label>
                <textarea
                  class="form-control"
                  name="descricao"
                  id="descricao"
                  placeholder="Descrição detalhada do item"
                  required
                  minlength="30"
                  rows="3"
                ><?= htmlspecialchars($descricao ?? '') ?></textarea>
              </div>

              <div class="form-check form-switch mb-4">
                <input
                  class="form-check-input"
                  value="1"
                  type="checkbox"
                  name="status"
                  id="status"
                  <?= $status ?>
                >
                <label class="form-check-label" for="status">Item ativo no cardápio</label>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= $baseUrl ?>/cardapio-adm" class="btn btn-secondary me-md-2">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-save me-2"></i><?= $acao == 'criar' ? 'Criar Item' : 'Salvar Alterações' ?>
                </button>
              </div>

              <input type="hidden" name="acao" value="<?= htmlspecialchars($acao) ?>">
              <input type="hidden" name="idCardapio" value="<?= htmlspecialchars($idCardapio ?? '') ?>">
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

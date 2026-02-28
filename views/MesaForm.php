<?php

$somente_leitura = $acao == "criar" ? "" : "readonly";

$header = file_get_contents("views/templates/html/header.html");
$footer = file_get_contents("views/templates/html/footer.html");
$header = str_replace("[[base-url]]", $baseUrl, $header);
$footer = str_replace("[[base-url]]", $baseUrl, $footer);

echo $header;
?>

<main>
  <section class="container mt-5">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow">
          <div class="card-header bgd-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
              <i class="bi bi-grid-3x3-gap-fill me-2"></i>
              <?= $acao == 'criar' ? 'Criar Mesa' : 'Editar Mesa' ?>
            </h2>
          </div>

          <div class="card-body">
            <form action="<?= $baseUrl ?>/mesa-adm/atualizar" method="post">
              <div class="row">
                <div class="col-md-3 mb-3">
                  <label for="id" class="form-label">Número da mesa *</label>
                  <input
                    class="form-control"
                    type="number"
                    name="id"
                    id="id"
                    min="1"
                    value="<?= htmlspecialchars($id ?? '') ?>"
                    required
                    <?= $somente_leitura ?>>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="lugares" class="form-label">Quantidade de lugares *</label>
                  <input
                    class="form-control"
                    type="number"
                    name="lugares"
                    id="lugares"
                    min="2"
                    max="8"
                    value="<?= htmlspecialchars($lugares ?? '') ?>"
                    required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="tipo" class="form-label">Tipo de mesa *</label>
                  <select
                    class="form-select"
                    name="tipo"
                    id="tipo"
                    required>
                    <?= $tipo ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 mb-3">
                  <div class="card h-100">
                    <div class="card-header">
                      <strong>Características</strong>
                    </div>
                    <div class="card-body">
                      <?= checkboxCaracteristicas("fumantes", "Fumantes", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("pet-friendly", "Pet Friendly", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("ar-condicionado", "Ar condicionado", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("area-aberta", "Área aberta", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("acessibilidade", "Acessibilidade", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("privacidade", "Privacidade", $arrayCaracteristicas) ?>
                      <?= checkboxCaracteristicas("espaco-kids", "Espaço kids", $arrayCaracteristicas) ?>
                    </div>
                  </div>
                </div>

                <div class="col-md-8 mb-3">
                  <div class="card h-100">
                    <div class="card-header">
                      <strong>Disponibilidade</strong>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Segunda-feira</span>
                        <?= checkboxDisponibilidade("segunda-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("segunda-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("segunda-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Terça-feira</span>
                        <?= checkboxDisponibilidade("terça-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("terça-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("terça-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Quarta-feira</span>
                        <?= checkboxDisponibilidade("quarta-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("quarta-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("quarta-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Quinta-feira</span>
                        <?= checkboxDisponibilidade("quinta-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("quinta-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("quinta-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Sexta-feira</span>
                        <?= checkboxDisponibilidade("sexta-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("sexta-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("sexta-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="w-25">Sábado</span>
                        <?= checkboxDisponibilidade("sabado-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("sabado-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("sabado-noite", "Noite", $arrayPeriodos) ?>
                      </div>

                      <div class="d-flex justify-content-between align-items-center">
                        <span class="w-25">Domingo</span>
                        <?= checkboxDisponibilidade("domingo-manha", "Manhã", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("domingo-tarde", "Tarde", $arrayPeriodos) ?>
                        <?= checkboxDisponibilidade("domingo-noite", "Noite", $arrayPeriodos) ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                <a href="<?= $baseUrl ?>/mesa-adm" class="btn btn-secondary me-md-2">
                  <i class="bi bi-arrow-left me-2"></i>Voltar
                </a>
                <button class="btn btn-primary" type="submit">
                  <i class="bi bi-save me-2"></i><?= $acao == 'criar' ? 'Criar Mesa' : 'Salvar Alterações' ?>
                </button>
              </div>

              <input type="hidden" name="acao" value="<?= htmlspecialchars($acao) ?>">
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
echo $footer;

function checkboxCaracteristicas($id, $texto, $arrayCaracteristicas)
{

  # in_array verifica qual o valor do $id dentro do array associativo $arrayCaracteristicas e compara o valor para colocar o attibuto checked no html
  $marcado = in_array($id, $arrayCaracteristicas) ? "checked" : "";

  return "
    <div class='form-check form-switch'>
      <input class='form-check-input' name='caracteristicas[]' value='$id' $marcado type='checkbox' role='switch' id='$id'>
      <label class='form-check-label' for='$id'>$texto</label>
    </div>";
}

function checkboxDisponibilidade($id, $texto, $arrayPeriodos)
{

  # extrai apenas os dados da coluna periodo
  $periodos = array_column($arrayPeriodos, "periodo");

  # verifica se oID está no array d periodos
  $marcado = in_array($id, $periodos) ? "checked" : "";

  return "
    <div class='form-check form-switch'>
      <input class='form-check-input' name='disponibilidade[]' value='$id' $marcado type='checkbox' role='switch' id='$id'>
      <label class='form-check-label' for='$id'>$texto</label>
    </div>";
}

?>
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
            <h2 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Faça sua Reserva</h2>
          </div>
          <div class="card-body">

            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Reserva realizada com sucesso!</strong> Entraremos em contato para confirmar.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <?php if (isset($erro) && $erro != ""): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erro:</strong> <?= $erro ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/reserva/criar" method="post" id="formReserva">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nome" class="form-label">Nome Completo *</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">E-mail *</label>
                  <input type="email" class="form-control" id="email" name="email">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="telefone" class="form-label">Telefone *</label>
                  <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(11) 99999-9999" required>
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
                  <input type="date" class="form-control" id="data_reserva" name="data_reserva" min="<?= date('Y-m-d') ?>" required>
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

              <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Alguma observação especial? (aniversário, alergias, etc.)"></textarea>
              </div>

              <div id="disponibilidade" class="alert alert-info" style="display: none;">
                <i class="bi bi-info-circle me-2"></i>
                <span id="disponibilidade-texto"></span>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dataInput = document.getElementById('data_reserva');
    const horaInput = document.getElementById('hora_reserva');
    const pessoasInput = document.getElementById('numero_pessoas');
    const disponibilidadeDiv = document.getElementById('disponibilidade');
    const disponibilidadeTexto = document.getElementById('disponibilidade-texto');

    function verificarDisponibilidade() {
      let dia = dataInput.value;
      const hora = horaInput.value;
      const pessoas = pessoasInput.value;

      if (dia && hora && pessoas) {
        fetch('<?= $baseUrl ?>/reserva/verificar_disponibilidade', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `data=${dia}&hora=${hora}&numero_pessoas=${pessoas}`
          })
          .then(response => response.json())
          .then(data => {
            dia = dia.split('-').reverse().join('/');
            if (data.disponivel) {
              disponibilidadeTexto.innerHTML = `✅ Mesas disponíveis para <b>${pessoas}</b> pessoa(s) em <b>${dia}</b> às <b>${hora}</b>`;
              disponibilidadeDiv.className = 'alert alert-success';
            } else {
              disponibilidadeTexto.innerHTML = `❌ Não há mesas disponíveis para <b>${pessoas}</b> pessoa(s) em <b>${dia}</b> às <b>${hora}</b>`;
              disponibilidadeDiv.className = 'alert alert-danger';
            }
            disponibilidadeDiv.style.display = 'block';
          });
      }
    }

    dataInput.addEventListener('change', verificarDisponibilidade);
    horaInput.addEventListener('change', verificarDisponibilidade);
    pessoasInput.addEventListener('change', verificarDisponibilidade);
  });
</script>

<?php
echo $footer;
?>
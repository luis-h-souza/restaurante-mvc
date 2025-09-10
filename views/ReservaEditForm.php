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
            <h2 class="mb-0"><i class="bi bi-pencil me-2"></i>Editar Reserva</h2>
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

            <form action="<?= $baseUrl ?>/reserva/atualizar/<?= $reserva['idReserva'] ?>" method="post">
              <input type="hidden" name="idReserva" value="<?= htmlspecialchars($reserva['idReserva']) ?>">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nome" class="form-label">Nome Completo *</label>
                  <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($reserva['nome']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($reserva['email'] ?? '') ?>">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="telefone" class="form-label">Telefone *</label>
                  <input type="tel" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($reserva['telefone']) ?>" placeholder="(11) 99999-9999" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="numero_pessoas" class="form-label">Número de Pessoas *</label>
                  <select class="form-select" id="numero_pessoas" name="numero_pessoas" required>
                    <option value="">Selecione...</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                      <option value="<?= $i ?>" <?= $reserva['numero_pessoas'] == $i ? 'selected' : '' ?>>
                        <?= $i ?> pessoa<?= $i > 1 ? 's' : '' ?>
                      </option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="data_reserva" class="form-label">Data da Reserva *</label>
                  <input type="date" class="form-control" id="data_reserva" name="data_reserva" value="<?= htmlspecialchars($reserva['data_reserva']) ?>" min="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                  <label for="hora_reserva" class="form-label">Horário *</label>
                  <select class="form-select" id="hora_reserva" name="hora_reserva" required>
                    <option value="">Selecione...</option>
                    <?php
                    $horarios = ['18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00'];
                    foreach ($horarios as $horario):
                    ?>
                      <option value="<?= $horario ?>" <?= $reserva['hora_reserva'] == $horario ? 'selected' : '' ?>>
                        <?= $horario ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="idMesa" class="form-label">Mesa</label>
                  <select class="form-select" id="idMesa" name="idMesa">
                    <option value="">Nenhuma mesa selecionada</option>
                    <?php foreach ($mesas as $mesa): ?>
                      <option value="<?= $mesa['id'] ?>" <?= $reserva['idMesa'] == $mesa['id'] ? 'selected' : '' ?>>
                        Mesa #<?= $mesa['id'] ?> (<?= $mesa['lugares'] ?> lugares - <?= $mesa['tipo'] ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="status" class="form-label">Status *</label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="">Selecione...</option>
                    <?php
                    $statuses = ['pendente' => 'Pendente', 'confirmada' => 'Confirmada', 'cancelada' => 'Cancelada'];
                    foreach ($statuses as $value => $label):
                    ?>
                      <option value="<?= $value ?>" <?= $reserva['status'] == $value ? 'selected' : '' ?>>
                        <?= $label ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Alguma observação especial? (aniversário, alergias, etc.)"><?= htmlspecialchars($reserva['observacoes'] ?? '') ?></textarea>
              </div>

              <div id="disponibilidade-div" class="alert" style="display: none;">
                <span id="disponibilidade-texto"></span>
              </div>

              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="<?= $baseUrl ?>/reserva/adm" class="btn btn-secondary me-md-2">
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

  <script>
    function verificarDisponibilidade() {
      const dataInput = document.getElementById('data_reserva');
      const horaInput = document.getElementById('hora_reserva');
      const pessoasInput = document.getElementById('numero_pessoas');
      const idReservaInput = document.querySelector('input[name="idReserva"]');
      const disponibilidadeTexto = document.getElementById('disponibilidade-texto');
      const disponibilidadeDiv = document.getElementById('disponibilidade-div');

      let dia = dataInput.value;
      const hora = horaInput.value;
      const pessoas = pessoasInput.value;
      const idReserva = idReservaInput.value;

      // Converter data para dd/mm/yyyy, se necessário
      if (dia && dia.includes('-')) {
        dia = dia.split('-').reverse().join('/');
      }

      if (dia && hora && pessoas) {
        fetch('<?= $baseUrl ?>/reserva/verificar_disponibilidade', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `data=${encodeURIComponent(dia)}&hora=${encodeURIComponent(hora)}&numero_pessoas=${encodeURIComponent(pessoas)}&idReserva=${encodeURIComponent(idReserva)}`
          })
          .then(response => {
            if (!response.ok) throw new Error('Erro HTTP: ' + response.status);
            return response.json();
          })
          .then(data => {
            disponibilidadeTexto.innerHTML = data.disponivel ?
              `✅ Mesas disponíveis para ${pessoas} pessoa(s) em ${dia} às ${hora}` :
              `❌ Não há mesas disponíveis para ${pessoas} pessoa(s) em ${dia} às ${hora}`;
            disponibilidadeDiv.className = data.disponivel ? 'alert alert-success' : 'alert alert-danger';
            disponibilidadeDiv.style.display = 'block';
          })
          .catch(error => {
            console.error('Erro:', error);
            disponibilidadeTexto.innerHTML = '❌ Erro ao verificar disponibilidade.';
            disponibilidadeDiv.className = 'alert alert-danger';
            disponibilidadeDiv.style.display = 'block';
          });
      }
    }

    // Vincular ao evento de mudança nos campos
    document.getElementById('data_reserva').addEventListener('change', verificarDisponibilidade);
    document.getElementById('hora_reserva').addEventListener('change', verificarDisponibilidade);
    document.getElementById('numero_pessoas').addEventListener('change', verificarDisponibilidade);
  </script>

</main>

<?php
echo $footer;
?>
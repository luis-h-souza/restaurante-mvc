<?php

# variável para incluir os códigos HTML da página
$lista = "";

# Endereço fixo do restaurante (Google Maps embed)
$endereco_texto = "Av. Paulista, 2389 - Bela Vista, São Paulo - SP";
$horario_funcionamento = "Segunda a Domingo, das 18h às 23h";
$localizacao = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.323247957456!2d-46.66495532478867!3d-23.55683126142554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce582d158d348d%3A0x9860ea40cc0b82ff!2sAv.%20Paulista%2C%202389%20-%20Bela%20Vista%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2001311-300!5e0!3m2!1spt-BR!2sbr!4v1732140733850!5m2!1spt-BR!2sbr";

$lista = "
  <div class='col-md-12 mb-4'>
    <div class='card shadow rounded-3'>
      <div class='card-header header d-flex flex-column'>
        <h4 class='mt-2 text-white fw-semibold'>Restaurante MVC</h4>
        <p class='text-white mb-1'><span class='fw-medium'>Endereço:</span> {$endereco_texto}</p>
        <p class='text-white mb-0'><span class='fw-medium'>Horário de funcionamento:</span> {$horario_funcionamento}</p>
      </div>

      <div class='card-body'>
        <iframe src='{$localizacao}' width='100%' height='450' style='border:0' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
      </div>

      <div class='card-footer d-flex align-items-center'>
        <span class='me-2 fw-medium'>Contato rápido:</span>
        <a href='https://api.whatsapp.com/send/?phone=5511999999999&text=Olá,%20gostaria%20de%20mais%20informações%20sobre%20o%20Restaurante%20MVC' target='_blank' class='btn btn-sm btn-success rounded-4 me-2'>
          <i class='bi bi-whatsapp'></i> Whatsapp
        </a>
        <a href='mailto:contato@restaurante-mvc.com' class='btn btn-sm btn-primary rounded-4'>
          <i class='bi bi-envelope'></i> E-mail
        </a>
      </div>
    </div>
  </div>
";

# faz a leitura dos arquivos de templates e armazena nas variáveis
$header = file_get_contents("views/templates/html/header_site.html");
$footer = file_get_contents("views/templates/html/footer.html");
$html = file_get_contents("views/templates/html/modeloSite.html");

# substituir a tag [[header]] pelo conteúdo da variável $header. O mesmo acontece com as demais.
$html = str_replace("[[header]]", $header, $html);
$html = str_replace("[[titulo]]", "<span class=''><svg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 24 24' style='fill: rgba(50, 93, 136, 1);transform: ;msFilter:;'><path d='M21 2H6a2 2 0 0 0-2 2v3H2v2h2v2H2v2h2v2H2v2h2v3a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm-8 2.999c1.648 0 3 1.351 3 3A3.012 3.012 0 0 1 13 11c-1.647 0-3-1.353-3-3.001 0-1.649 1.353-3 3-3zM19 18H7v-.75c0-2.219 2.705-4.5 6-4.5s6 2.281 6 4.5V18z'></path></svg><span><span><strong class='ms-2'>CONTATO</strong></span>", $html);
$html = str_replace("[[conteudo]]", $lista, $html);
$html = str_replace("[[footer]]", $footer, $html);
$html = str_replace("[[base-url]]", $baseUrl, $html);
$html = str_replace("[[js]]", "", $html);

echo $html;

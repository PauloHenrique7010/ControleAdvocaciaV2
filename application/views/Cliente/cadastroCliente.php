<?php $this->load->view('cabecalho'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script>
  function msgDeletar(codCliente, nomeCliente) {
    Swal.fire({
      title: 'Excluir ' + nomeCliente + '?',
      text: 'Não é possível desfazer o processo!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Não',
      confirmButtonText: 'Sim'
    }).then((result) => {
      if (result.value) {
        Swal.fire({
          title: 'Excluido!',
          text: 'Registro excluído com sucesso!',
          icon: 'success',
        }).then((result) => {
          <?php echo "window.location.href = '" . base_url("ExcluirCliente/") . "'+codCliente; " ?>
        })
      }
    })
  }
  $(document).ready(function() {

    var tabelaClientes = $("#tabelaClientes").DataTable({

      columns: [{
          title: 'Código'
        },
        {
          title: 'Nome'
        },
        // {
          // title: 'Serviços'
        // },
        {
          title: 'Editar'
        },
        {
          title: 'Excluir'
        }
      ],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
      }
    });
  }); //fecha o document ready
</script>

<div class="container">
  <br><br>
  <h2>Registro de clientes</h2>
  <a href="<?php echo base_url('NovoCliente'); ?>"><button type="button" class="btn btn-success">Cadastrar</button></a>
  <br><br>
  <?php
  if (!isset($registros) || sizeof($registros) == 0) :
    echo "<h4>Nenhum registro encontrado</h4>";
  else :
  ?>
    <table class="table table-hover table-striped" id="tabelaClientes">
      <thead>
        <tr>
          <th>Código</th>
          <th>Nome Cliente</th>
          <!--<th>Serviços</th>-->
          <th>Editar</th>
          <th>Excluir</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($registros as $linha) :
          echo "<tr>";
          echo "<td>" . $linha->cod_cliente . "</td>";
          echo "<td>" . $linha->nome_cliente . "</td>";
          // echo "<td><a href=\" " . base_url("EditarCliente/" . $linha->cod_cliente) . " \"><button type=\"button\" class=\"btn btn-info\">Serviços</button></a></td>";
          echo "<td><a href=\" " . base_url("EditarCliente/" . $linha->cod_cliente) . " \"><button type=\"button\" class=\"btn btn-warning\">Editar</button></a></td>";
          echo "<td><a href=\"#\"><button type=\"button\" onClick=\"msgDeletar(" . $linha->cod_cliente . ",'" . $linha->nome_cliente . "')\" class=\"btn btn-danger\">Excluir</button></a></td>";
          echo "</tr>";
        endforeach;
        ?>
      </tbody>
    </table>

  <?php endif; ?>
</div>
<?php $this->load->view('rodape'); ?>
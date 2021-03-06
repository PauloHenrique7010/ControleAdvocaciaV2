<?php $this->load->view('Administrador/cabecalho'); ?>
<script>
  function msgDeletar(codigo, nome) {
    Swal.fire({
      title: 'Excluir ' + nome + '?',
      text: 'Não é possível desfazer o processo!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Não',
      confirmButtonText: 'Sim'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: 'post',
          url: '<?php echo base_url('eOrgaoClasse'); ?>',
          data: {
            'cod_orgao_classe': codigo
          }
        }).then(function(res) {
          if (res.type == 'success') {
            var tabela = $('#tableRegistros').DataTable();
            var linha = $('#orgao_classe_' + codigo);
            linha.fadeOut(500, function() {
              tabela.row(linha).remove().draw();
            });
            //exibirMensagemSucesso('Sucesso!', 'O registro foi excluido com exito');
          } else {
            exibirMensagemErro('Erro!', 'Não foi possível excluir!');
          }
        }, function() {
          exibirMensagemErro('Oh não!', 'Ocorreu um erro inesperado!');
        })
      }
    });
  }
</script>


<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url("assets/Administrador/plugins/datatables-bs4/css/dataTables.bootstrap4.css"); ?>">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Cadastro de orgãos de classe</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Orgão de classe</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="<?php echo base_url('Admin/NovoOrgaoClasse'); ?>">
              <button class="btn btn-success" data-toggle="modal" data-target="#createModel">
                Cadastrar
              </button>
            </a>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-sm-12" style="padding-bottom: 5px;">
              <table id="tableRegistros" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Código Orgão</th>
                    <th>Nome Orgão</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody id="tableBody">
                  <?php
                  foreach ($registros as $linha) {
                    echo "<tr id=\"orgao_classe_$linha->cod_orgao_classe\">";
                    echo "<td>" . $linha->cod_orgao_classe . "</td>";
                    echo "<td>" . $linha->nome_orgao_classe . "</td>";
                    echo "<td>";
                    echo "<a href=\"" . base_url("Admin/AlterarOrgaoClasse/" . $linha->cod_orgao_classe) . "\"<button class=\"btn btn-primary\" data-id=\"" . $linha->cod_orgao_classe . "\">Editar</button></a>&nbsp;&nbsp;";
                    echo "<button type=\"button\" onClick=\"msgDeletar(" . $linha->cod_orgao_classe . ",'" . $linha->nome_orgao_classe . "')\" class=\"btn btn-danger\">Excluir</button>";
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Código profissão</th>
                    <th>Nome profissão</th>
                    <th>Ações</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.row -->
  </section>
</div>
<!-- /.content -->


<!-- jQuery -->
<script src="<?php echo base_url("assets/Administrador/plugins/jquery/jquery.min.js"); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url("assets/Administrador/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url("assets/Administrador/plugins/datatables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("assets/Administrador/plugins/datatables-bs4/js/dataTables.bootstrap4.js"); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url("assets/Administrador/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url("assets/Administrador/dist/js/adminlte.min.js"); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url("assets/Administrador/dist/js/demo.js"); ?>"></script>
<!-- page script -->
<script>
  $(function() {

    $('#tableRegistros').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
<?php $this->load->view('Administrador/rodape'); ?>
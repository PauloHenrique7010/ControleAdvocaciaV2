<?php $this->load->view('Administrador/cabecalho'); ?>

<link rel="stylesheet" href="<?php echo base_url("assets/Administrador/plugins/datatables-bs4/css/dataTables.bootstrap4.css"); ?>">
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
<!-- DataTables -->


<script>
  $(document).ready(function() {
    function msgDeletar(codigo, nome) {

    }

    var tabelaTipoServico = $("#tabelaTipoServico").DataTable({
     columns: [{
          title: 'Código'

        },
        {
          title: 'Nome'
        },
        {
          title: 'Ações'
        }
      ],
      columnDefs: [{
          "width": "10%",
          "targets": 0
        }, //codigo
        {
          "width": "70%",
          "targets": 1
        }, //nome       
        {
          "width": "20%",
          "targets": 2
        }

      ],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
      }
    });

    //Assim que carregar a pagina, pesquisa no banco
    pesquisar();

    $("#btnPesquisar").on('click', async function() {
      pesquisar();
    });

  
    $('#tabelaTipoServico').on('click', 'tbody tr .btnExcluir',async function(e) {
      let codigo = $(this).data("codigo");
      let nome = $(this).data("nome");

      Swal.fire({
        title: 'Deseja realmente excluir ' + nome + '?',
        text: 'Não é possível desfazer o processo!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then(async (result) => {
        if (result.value) {
          let linha = $(this).parent().parent(); //pego a linha antes de ser excluida ??? na faz sentido.. mas se o bd excluir e o datatable tentar pegar.. ele n faz nada
          $.ajax({
            type: 'DELETE',
            url: await pegarRotaBack('tipoServico/'),
            contentType: 'application/json',
            data: JSON.stringify({
              'codigo': codigo
            })
          }).done(function(resposta, status, response) {

            let titulo = response.responseJSON.title;
            let msg = response.responseJSON.message;
            let tipo = response.responseJSON.tipo;

            if (response.status == 200) { //excluiu
              linha.fadeOut(500, function() {
                tabelaTipoServico.row(linha).remove().draw();
              });

            } else
              exibirMensagem(titulo, msg, tipo);

          }).fail(function(jqXHR, status, err) {
            exibirMensagem('Erro!', 'Ocorreu um erro inesperado', 'error');
          });
        }
      });
    });


    async function pesquisar() {
      $.ajax({
        url: await pegarRotaBack('tipoServico/'),
        type: "GET"
        //data: filtro
      }).done(function(resposta) {
        var dataSet = [];
        console.log(resposta);
        $.each(resposta.registros, function(index, data) {
          dataSet.push([
            data.cod_tipo_servico,
            data.nome_tipo_servico,
            '<a href="./AlterarTipoServico/'+data.cod_tipo_servico+'"><button type="button" class="btn btn-warning">Alterar</button></a> &nbsp;&nbsp;' +
            '<button type="button" class="btn btn-danger btnExcluir" data-codigo="' + data.cod_tipo_servico + '" data-nome="' + data.nome_tipo_servico + '">Excluir</button>'
          ]);
        });

        tabelaTipoServico.clear();
        tabelaTipoServico.rows.add(dataSet).draw();
      }).fail(function(jqXHR, status, err) {
        if (StrToInt(status) == 0) {
          exibirMensagemAviso('Aviso!', 'Servidor não encontrado');
        }
      });
    }

  });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Cadastro tipo serviço</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="Configuracoes">Home</a></li>
            <li class="breadcrumb-item active">Tipo Serviço</li>
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
            <a href="<?php echo base_url('Admin/NovoTipoServico'); ?>">
              <button class="btn btn-success" id="btnConfirmar">
                Cadastrar
              </button>
            </a>
            <button class="btn btn-success" id="btnPesquisar">
                Pesquisar
            </button>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-sm-12" style="padding-bottom: 5px;">
              <table id="tabelaTipoServico" class="table table-bordered table-striped">

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


<?php $this->load->view('Administrador/rodape'); ?>
<?php $this->load->view('cabecalho'); ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js"); ?>"></script>
<script>
  $(document).ready(function() {

    $('#tabelaServicos').on('click', 'tbody tr .btnVerDetalhes', function() {
      var itemEscolhido = tabelaServicos.row($(this)).data();
      itemEscolhido = tabelaServicos.row($(this).parents('tr')).data();
      

      codServicoPagamento = StrToInt(itemEscolhido[0]);      

      $.ajax({
        url: pegarRotaBack('servico/partes'),
        type: "GET",
        data: "codigo="+codServicoPagamento
      }).done(function(resposta) {
        console.log(resposta.partes);
      }).fail(function(jqXHR, status, err) {
        if (StrToInt(status) == 0) {
          exibirMensagemAviso('Aviso!', 'Servidor não está respondendo');
        }
      });
    });


    var tabelaServicos = $("#tabelaServicos").DataTable({
      paging: false,
      searching: false,
      ordering: false,
      info: false,
      columns: [
        {
          title: 'Cód servico pagamento',
          visible:false
        },
        {
          title: 'Nº Prestação'
        },
        {
          title: 'Data'
        },
        {
          title: 'Valor'
        },
        {
          title: 'Ações'
        }
      ],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
      }
    });

    pesquisarServico();

    function pesquisarServico() {
      let dataAtual = new Date();
      let dtInicial, dtFinal;


      dtInicial = new Date(dataAtual.getFullYear(), dataAtual.getMonth(), 1);
      dtFinal = new Date(dataAtual.getFullYear(), dataAtual.getMonth(), dataAtual.getDate());

      var filtro = new Object();
      filtro.dtInicial = dtInicial;
      filtro.dtFinal = dtFinal;
      $.ajax({
        url: pegarRotaBack('servico/'),
        type: "GET",
        data: filtro
      }).done(function(resposta) {
        var dataSet = [];
        $.each(resposta.servicos, function(index, data) {
          dataSet.push([
            data.cod_servico,
            data.numero_parcela,
            data.data_vencimento,
            data.valor_parcela,
            '<button type="button" class="btn btn-warning btnBoleto">Boleto</button>' +
            '<button type="button" class="btn btn-success btnDarBaixa">Dar Baixa</button>' +
            '<button type="button" class="btn btn-info btnVerDetalhes" data-toggle="modal" data-target="#mdlDetalhesServico">Detalhes</button>'
          ]);
        });

        tabelaServicos.clear();
        tabelaServicos.rows.add(dataSet).draw();
      }).fail(function(jqXHR, status, err) {
        if (StrToInt(status) == 0) {
          exibirMensagemAviso('Aviso!', 'Servidor não encontrado');
        }
      });
    }

  });
</script>


<div class="container-fluid">
  <div class="container">
    <h3>Controle financeiro e de Clientes para advogados</h3>
    Mostrando pagamentos pendentes do mes atual
  </div>
  <table class="table table-hover table-striped" id="tabelaServicos">

  </table>
</div>



<!-- modais -->
<div class="modal fade" id="mdlDetalhesServico" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detalhes do serviço</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="container"></div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table class="table table-hover table-striped" id="tabelaDetalhesServico">
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">

        <!--<a data-toggle="modal" href="#mdlAdicionarPartesProcessoSemCadastro" class="btn btn-warning">Sem cadastro</a>
                <a data-toggle="modal" href="#mdlAdicionarPartesProcesso" class="btn btn-primary">Adicionar</a>                -->
        <a href="#" data-dismiss="modal" class="btn btn-danger">Fechar</a>
      </div>
    </div>
  </div>
</div>


<footer class="footer fixed-bottom">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">

    Feito por <b>Paulo Henrique</b> © 2020 Copyright:
    <!--<a href="https://mdbootstrap.com/"> MDBootstrap.com</a>-->
  </div>
  <!-- Copyright -->

</footer>

<?php $this->load->view('rodape'); ?>
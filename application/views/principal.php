<?php $this->load->view('cabecalho'); ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js"); ?>"></script>
<script>
  $(document).ready(function() {
    var tabelaServicos = $("#tabelaServicos").DataTable({
      paging: false,
      searching: false,
      ordering: false,
      info: false,
      columns: [{
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
      pesquisa = "";
      pesquisa = "data_vencimento <= Date(now())";
      $.ajax({
        url: '<?php echo base_url('PesquisarServico'); ?>',
        type: "get",
        data: "pesquisa=" + pesquisa
      }).done(function(resposta) {

        var dataSet = [];
        $.each(resposta, function(index, data) {
          dataSet.push([
            data.cod_servico,
            data.cod_servico,
            data.cod_servico,
            '<button type="button" class="btn btn-warning btnExcluirParte">Boleto</button>'
          ]);
        });

        tabelaServicos.clear();
        tabelaServicos.rows.add(dataSet).draw();
      });
    }

  });
</script>


<div class="container-fluid">
  <div class="container">
    <h3>Controle financeiro e de Clientes para advogados</h3>
    <p>Feito por Paulo Henrique.</p>
  </div>


  Mostrando pagamentos pendentes do mes atual
  <table class="table table-hover table-striped" id="tabelaServicos">

  </table>
</div>
<footer class="footer fixed-bottom">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
  </div>
  <!-- Copyright -->

</footer>

<?php $this->load->view('rodape'); ?>
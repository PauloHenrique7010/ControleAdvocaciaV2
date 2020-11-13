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
      let dataAtual = new Date();
      let dtInicial, dtFinal;
      

      dtInicial = new Date(dataAtual.getFullYear(), dataAtual.getMonth(), 1);
      dtFinal   = new Date(dataAtual.getFullYear(), dataAtual.getMonth(),dataAtual.getDate()); 
      
      var filtro = new Object();
      filtro.dtInicial = dtInicial;
      filtro.dtFinal = dtFinal;
      $.ajax({
        url: pegarRotaBack('servico/'),
        type:"GET",
        data: filtro
      }).done(function(resposta) {
        var dataSet = [];
        $.each(resposta.servicos, function(index, data) {
          dataSet.push([
            data.numero_parcela,
            data.data_vencimento,
            data.cod_servico,
            '<button type="button" class="btn btn-warning btnExcluirParte">Boleto</button>'+
            '<button type="button" class="btn btn-success btnDarBaixa">Dar Baixa</button>'
          ]);
        });

        tabelaServicos.clear();
        tabelaServicos.rows.add(dataSet).draw();
      }).fail(function(jqXHR,status,err){        
        if (StrToInt(status) == 0){
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
<footer class="footer fixed-bottom">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">
  
    Feito por <b>Paulo Henrique</b> © 2020 Copyright:
    <!--<a href="https://mdbootstrap.com/"> MDBootstrap.com</a>-->
  </div>
  <!-- Copyright -->

</footer>

<?php $this->load->view('rodape'); ?>
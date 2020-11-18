﻿<?php $this->load->view('cabecalho'); ?>
<style>
  /*deixa o modal com scrool*/
  .tabela {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }

  /*deixa o modal com scrool*/
  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
  }
</style>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js"); ?>"></script>
<script>
  $(document).ready(function() {

    $('#tabelaServicos').on('click', 'tbody tr .btnVerDetalhes', function() {
      var itemEscolhido = tabelaServicos.row($(this)).data();
      itemEscolhido = tabelaServicos.row($(this).parents('tr')).data();


      codServico = StrToInt(itemEscolhido[0]);

      $.ajax({
        url: pegarRotaBack('servico/partes'),
        type: "GET",
        data: "codigo=" + codServico
      }).done(function(resposta) {
        console.log(resposta.partes);
      }).fail(function(jqXHR, status, err) {
        if (StrToInt(status) == 0) {
          exibirMensagemAviso('Aviso!', 'Servidor não está respondendo');
        }
      });
    });

    $('#tabelaServicos').on('click', 'tbody tr .btnBoleto', function() {
      var itemEscolhido = tabelaServicos.row($(this)).data();
      itemEscolhido = tabelaServicos.row($(this).parents('tr')).data();
      codServicoPagamento = StrToInt(itemEscolhido[1]);


      var json = new Object();
      json.valor = itemEscolhido[4];
      json.dataVencimento = itemEscolhido[3];

      $.ajax({
        url: pegarRotaBack('boleto/'),
        type: "GET",
        data: json
      }).done(function(resposta) {
        setTimeout(function() {
          window.open(resposta.diretorio);
        }, 2000);

      }).fail(function(jqXHR, status, err) {
        if (StrToInt(status) == 0) {
          exibirMensagemAviso('Aviso!', 'Servidor não está respondendo');
        }
      });
    });

    $('#tabelaServicos').on('click', 'tbody tr .btnDarBaixa', function() {
      var itemEscolhido = tabelaServicos.row($(this)).data();
      itemEscolhido = tabelaServicos.row($(this).parents('tr')).data();

      var json = new Object();
      json.codigo = StrToInt(itemEscolhido[1]);


      $.ajax({
        url: pegarRotaBack('servico/darBaixaPagamento'),
        type: "post",
        data: JSON.stringify(json),
        contentType: 'application/json',
      }).done(function(resposta, status, response) {

        let titulo = response.responseJSON.title;
        let msg = response.responseJSON.message;

        if (response.status == 200) {
          exibirMensagemSucesso(titulo, msg);
        } else {
          exibirMensagemAviso(titulo, msg);
        }
      }).fail(function(jqXHR, status, err) {
        exibirMensagemErro(jqXHR.responseJSON.title, jqXHR.responseJSON.message);
      });
    });

    $('#edtDtInicial').on('keyup', function() {
      data = $(this).val();
      if (data.length == 10) { //quando completar a data joga pro data time
        var json = new Object();
        json.data = $('#edtDtInicial').val(),
        json.formato = "DD/MM/YYYY"
        $.ajax({
          url: pegarRotaBack('funcoes/strToDate'),
          type: "get",
          data: json,
          contentType: 'application/json',          
        }).done(function(resposta, status, response) {
          let titulo = response.responseJSON.title;
          let msg = response.responseJSON.message;
          
          novaData = new Date(resposta.retorno);
                    
          if (response.status == 200) {
            datePicker.data('datepicker').selectDate(novaData);
          } else {
            exibirMensagemAviso(titulo, msg);
          }
        }).fail(function(jqXHR, status, err) {
          exibirMensagemErro(jqXHR.responseJSON.title, jqXHR.responseJSON.message);
        });

        /*var dp = $('.datepicker-here').datepicker().data('datepicker');

        dp.selectDate(new Date(2019,11,20));*/

      }

    });

    var datePicker = $('.datepicker-here').datepicker({
      language: {
        days: ['Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado'],
        daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        daysMin: ['Do', 'Se', 'Te', 'Qa', 'Qi', 'Se', 'Sa'],
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembr', 'Outubro', 'Novembro', 'Dezembro'],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        today: 'Hoje',
        clear: 'Limpar',
        dateFormat: 'dd/mm/yyyy',
        timeFormat: 'hh:ii aa',
        firstDay: 0
      },
      onRenderCell: function(date, cellType) {
        if (cellType == 'day' && date.getDate() == 11) {
          return {
            classes: 'my-class',
            disabled: true
          }
        }
      }
    });


    var tabelaServicos = $("#tabelaServicos").DataTable({
      paging: false,
      searching: false,
      ordering: false,
      info: false,
      columns: [{
          title: 'Cód servico',
          visible: false
        },
        {
          title: 'Cód servico pagamento',
          visible: false
        },
        {
          title: 'Nº Parcela'
        },
        {
          title: 'Data'
        },
        {
          title: 'Valor'
        },
        {
          title: 'Partes'
        },
        {
          title: 'Ações'
        }
      ],
      columnDefs: [{
          "width": "2%",
          "targets": 2
        }, //n prestaacao
        {
          "width": "2%",
          "targets": 3
        }, //data
        {
          "width": "2%",
          "targets": 4
        }, //valor
        {
          "width": "15%",
          "targets": 6
        } //ações

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
        //console.log(resposta);
        $.each(resposta.servicos, function(index, data) {
          dataVencimentoFormatada = formatDateTime(data.data_vencimento);

          dataSet.push([
            data.cod_servico,
            data.cod_servico_pagamento,
            data.numero_parcela,
            dataVencimentoFormatada,
            data.valor_parcela.toLocaleString('pt-BR', {
              style: 'currency',
              currency: 'BRL'
            }),
            data.nomeParte,
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

  <div class="col-12">
    <div class="panel-group form-group">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse1">Filtros</a>
          </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
          <div class="panel-body">
            <label> Data Inicial </label>
            <input type='text' class="datepicker-here" id="edtDtInicial" maxlength="10" onKeyPress="MascaraData(this)" data-position='bottom right' />
          </div>
          <div class="panel-footer">Panel Footer</div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-12 tabela">
    <table class="table table-hover table-striped" id="tabelaServicos">
    </table>
  </div>
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
            <!--<table class="table table-hover table-striped" id="tabelaDetalhesServico">--->
            <table class="" id="tabelaDetalhesServico">
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
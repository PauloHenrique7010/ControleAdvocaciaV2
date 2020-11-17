<?php $this->load->view('cabecalho'); ?>
<style>
    /*deixa o modal com scrool*/
    .modal-dialog {
        overflow-y: initial !important
    }

    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    .tabela{
        max-height: calc(100vh - 450px);
      overflow-y:auto;
    }
</style>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //ao apertar enter pula para o proximo campo
        //----------------------------------------------------------------------------------------
        jQuery('body').on('keydown', 'input, select, textarea, button', function(e) {
            var self = $(this),
                form = self.parents('form:eq(0)'),
                focusable, next;

            //se pressionar ctrl + enter, confirma o cadastro
            if (e.ctrlKey && e.keyCode == 13) {
                $("#enviar").trigger('click');
            } else if (e.keyCode == 13) {
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this) + 1);
                if (next.length) {
                    next.focus();
                } else {
                    form.submit();
                }
                return false;
            }

        });
        //----------------------------------------------------------------------------------------
        $('#edtPesquisaCliente').on('keyup', function(e) {
            pesquisaCliente();
        });


        var tabelaPesquisaCliente = $("#tabelaPesquisaCliente").DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            columns: [{
                    title: 'Código'
                },
                {
                    title: 'Nome'
                },
                {
                    title: 'CPF/CNPJ'
                }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
        });

        var tabelaPartesServico = $("#tabelaPartesServico").DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            columns: [{
                    title: 'Código'
                },
                {
                    title: 'Nome'
                },
                {
                    title: 'Excluir'
                }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }

        });

        //pega os elementos criados dinamicamente
        $('#tabelaPartesServico').on('click', 'tbody tr .btnExcluirParte', function() {
            tabelaPartesServico.row($(this).parents('tr')).remove().draw(true);
        });

        //se der duplo clique, exclui
        $('#tabelaPartesServico').on('dblclick', 'tbody tr', function() {
            tabelaPartesServico.row($(this).parents('tr')).remove().draw(true);
        });


        //acao de confirmar o cliente selecionado
        $('#btnConfirmaPesquisaCliente').on('click', function() {
            var itemEscolhido = tabelaPesquisaCliente.row($('tr.selected')).data();
            if (itemEscolhido == undefined) {
                exibirMensagemAviso('Aviso!', 'Escolha uma registro para confirmar.');
            } else {
                itemEscolhido.splice(2, 1);
                tabelaPartesServico.row.add(itemEscolhido).draw();
                $("#btnFecharPesquisaCliente").trigger("click");
            }
        });

        $('#btnConfirmaSemCadastro').on('click', function() {
            let nomeParteSemCadastro = $("#edtNomeSemCadastro").val();
            tabelaPartesServico.row.add(["",
                nomeParteSemCadastro,
                '<button type="button" class="btn btn-danger btnExcluirParte">Excluir</button>'
            ]).draw();
            $("#btnFecharSemCadastro").trigger("click");
        });



        //se der duplo clique, seleciona e fecha o modal
        $('#tabelaPesquisaCliente tbody').on('dblclick', 'tr', function() {
            $(this).removeClass('selected');
            $(this).addClass('selected');
            $("#btnConfirmaPesquisaCliente").trigger("click");
        });

        //Seleciona os registros
        $('#tabelaPesquisaCliente tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                tabelaPesquisaCliente.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        //pesquisa o cliente informado no modal de pesquisar cliente
        function pesquisaCliente() {
            let pesquisa = $('#edtPesquisaCliente').val();

            $.ajax({
                url: '<?php echo base_url('pCliente'); ?>',
                type: "get",
                data: "pesquisa=" + pesquisa //+"&cod_foro="+codForo                
            }).done(function(resposta) {
                let itens = resposta.registros;

                var dataSet = [];
                $.each(itens, function(index, data) {
                    dataSet.push([
                        data.cod_cliente,
                        data.nome_cliente,
                        data.cpf,
                        '<button type="button" class="btn btn-danger btnExcluirParte">Excluir</button>'


                    ]);
                });

                tabelaPesquisaCliente.clear();
                tabelaPesquisaCliente.rows.add(dataSet).draw();
            });
        }

        $('#edtNumeroPrestacoes').on('change keyup', function() {
            calcularPrestacoes();
        });

        $('#edtVlDinheiro').on('keyup', function() {
            calcularPrestacoes();
        });

        function calcularPrestacoes() {
            var vlTotalServico = $("#edtValorServico").val();
            vlTotalServico = vlTotalServico.replaceAll(".", "");
            vlTotalServico = vlTotalServico.replaceAll(",", ".");
            vlTotalServico = parseFloat(vlTotalServico).toFixed(2);
            if (isNaN(vlTotalServico)) {
                vlTotalServico = 0;
            }

            var vlDinheiroOuEntrada = $("#edtVlDinheiro").val();
            vlDinheiroOuEntrada = vlDinheiroOuEntrada.replaceAll(".", "");
            vlDinheiroOuEntrada = vlDinheiroOuEntrada.replaceAll(",", ".");
            vlDinheiroOuEntrada = parseFloat(vlDinheiroOuEntrada).toFixed(2);
            if (isNaN(vlDinheiroOuEntrada)) {
                vlDinheiroOuEntrada = 0;
            }

            qtdePrestacoes = parseFloat($("#edtNumeroPrestacoes").val());
            if (isNaN(qtdePrestacoes)) {
                qtdePrestacoes = 0;
            }
            //fim declaracao variavel

            if (qtdePrestacoes == 0) {
                tabelaPrestacoesCartao.clear();
            }
            //se possuir numero de parcela, calcula as prestacoes com base no valorServico - valorEntrada
            else {

                let vlTotalAPagarParcelado = vlTotalServico - vlDinheiroOuEntrada;
                let vlParcelaUnitaria = parseFloat((vlTotalAPagarParcelado / qtdePrestacoes).toFixed(2)); //arredondar

                let vlPrimeiraParcelaCorrigida = vlParcelaUnitaria + (vlTotalAPagarParcelado - (vlParcelaUnitaria * qtdePrestacoes));
                var dataSet = [];
                for (var n = 1; n <= qtdePrestacoes; n++) {
                    let dataParcela = new Date();
                    let valorVez = vlParcelaUnitaria;
                    if (n == 1) {
                        valorVez = vlPrimeiraParcelaCorrigida;
                    }
                    valorVez = parseFloat(valorVez.toFixed(2));


                    if (n > 1) {
                        dataParcela = new Date(dataParcela.getFullYear(), dataParcela.getMonth() + (n - 1), dataParcela.getDate())
                    }
                    dataParcela = dataParcela.toLocaleDateString('pt-BR');
                    dataParcela = dataParcela.toString();


                    dataSet.push([
                        n,
                        '<input type="text" maxlength="10" class="form-control" style="text-align:center" onKeyUp="MascaraData(this);" value="' + dataParcela + '">',
                        '<input type="text" class="form-control" style="text-align:right" onKeyUp="formatarMoeda(this);" value="' + valorVez + '">',
                        //Formas de pagamento
                        '<select class="form-control cmbFormaPagamento"> ' +
                        '</select> '
                    ]);

                    tabelaPrestacoesCartao.clear();
                    tabelaPrestacoesCartao.rows.add(dataSet);
                }
            }

            tabelaPrestacoesCartao.draw();
            carregarFormasPagamento();
        }

        function carregarFormasPagamento() {
            let formaPagamento = [];
            $.ajax({
                url: '<?php echo base_url('pFormaPagamento'); ?>',
                type: "get",
            }).done(function(resposta) {
                formaPagamento = resposta.registros;
                $(".cmbFormaPagamento").each(function(index) {
                    $('.cmbFormaPagamento option').remove();
                    $('.cmbFormaPagamento').append(new Option("", 0));

                    $.each(formaPagamento, function(index, linha) {
                        $('.cmbFormaPagamento').append(new Option(linha.nome_forma_pagamento, linha.cod_forma_pagamento));
                    });
                    $('.cmbFormaPagamento').val("2"); //fica predefinido o cartao

                });
            });
        }

        var tabelaPrestacoesCartao = $("#tabelaPrestacoesCartao").DataTable({
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
                    title: 'Forma Pagamento'
                }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
        });

        $('#enviar').on('click', function(e) {
            Confirmar(e);
        });

        function Confirmar(event) {
            //declara todas as variaveis 
            let tipoServico = StrToInt($("#cmbTipoServico").val());
            let tipoAcao = StrToInt($("#cmbTipoAcao").val());
            let tipoProcesso = StrToInt($("#cmbTipoProcesso").val());

            event.preventDefault();
            OPConfirmar = true;
            msgConfirmacao = "";

            let vlTotalServico = StrToFloat($("#edtValorServico").val());

            if (vlTotalServico == 0) {
                msgConfirmacao += "Informe o valor do serviço<br>";
                OPConfirmar = false;
            }

            if (tipoServico == 0) {
                msgConfirmacao += "Informe o tipo do serviço<br>";
            }

            if (tipoAcao == 0) {
                OPConfirmar = false;
                msgConfirmacao += "Informe o tipo da ação<br>";
            }

            if (tipoProcesso == 0) {
                OPConfirmar = false;
                msgConfirmacao += "Informe o tipo de processo<br>";
            }


            if (OPConfirmar == false) {
                exibirCamposObrigatorios(msgConfirmacao);
            } else {
                //monto o json para mandaar pro back
                var objeto = new Object();
                objeto.valorServico = vlTotalServico;
                objeto.tipoServico = tipoServico;
                objeto.tipoAcao = tipoAcao;
                objeto.tipoProcesso = tipoProcesso;

                let dataSet = [];

                tabelaPrestacoesCartao.data().each(function(value, index) {
                    dataVencimento = tabelaPrestacoesCartao.cell(index, 1).nodes().to$().find('input').val();

                    dataVencimento = StrToDate(dataVencimento); //se nao for valida, volta como null

                    var novoObjeto = new Object();
                    novoObjeto.numParcela = tabelaPrestacoesCartao.cell(index, 0).data();
                    novoObjeto.dataVencimento = dataVencimento;
                    novoObjeto.valor = tabelaPrestacoesCartao.cell(index, 2).nodes().to$().find('input').val();
                    novoObjeto.formaPagamento = tabelaPrestacoesCartao.cell(index, 3).nodes().to$().find('select').val();

                    dataSet.push(novoObjeto);
                });
                objeto.prestacoesCartao = dataSet;

                datasetPartesServico = [];
                tabelaPartesServico.data().each(function(value, index) {
                    var objPartesServico = new Object();
                    objPartesServico.codigo = StrToInt(tabelaPartesServico.cell(index, 0).data());
                    objPartesServico.nome = tabelaPartesServico.cell(index, 1).data();
                    datasetPartesServico.push(objPartesServico);
                });
                objeto.partesServico = datasetPartesServico;

                var json = JSON.stringify(objeto);

                $.ajax({
                    url: '<?php echo base_url('ConfirmarNovoServico'); ?>',
                    type: "POST",
                    data: {
                        MyData: json
                    }
                }).done(function(resposta) {
                    window.location.href = "http://localhost/ControleAdvocaciaV2";//voltar para a pagina inicial
                });
            }
        }
    });
</script>

<div class="container">
    <form action="/action_page.php">
        <div class="form-row">
            <div class="col-4">
                <h4>Tipo serviço</h4>
                <?php
                echo form_dropdown(
                    array(
                        'class' => 'form-control',
                        'name' => 'cmbTipoServico',
                        'id' => 'cmbTipoServico'
                    ),
                    $tipoServico,
                    set_value('cmbTipoServico')
                );
                ?>
            </div>
            <div class="col-4">
                <h4>Tipo processo</h4>
                <?php
                echo form_dropdown(
                    array(
                        'class' => 'form-control',
                        'name' => 'cmbTipoProcesso',
                        'id' => 'cmbTipoProcesso'
                    ),
                    $tipoProcesso,
                    set_value('cmbTipoProcesso')
                );
                ?>
            </div>
            <div class="col-4">
                <h4>Tipo Ação</h4>
                <?php
                echo form_dropdown(
                    array(
                        'class' => 'form-control',
                        'name' => 'cmbTipoAcao',
                        'id' => 'cmbTipoAcao'
                    ),
                    $tipoAcao,
                    set_value('cmbTipoAcao')
                );
                ?>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col-4">
                <h4>Escolha as partes do processo</h4>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlPartesProcesso">
                    Partes processo
                </button>
            </div>
            <div class="col-2">
                <h4>Valor serviço</h4>
                <?php
                echo form_input(
                    array(
                        'id'  => 'edtValorServico',
                        'name'  => 'edtValorServico',
                        'onKeyUp' => 'formatarMoeda(this);',
                        'class' => 'form-control',
                        'style' => 'text-align:right',
                    ),
                    set_value('edtValorServico')
                );

                ?>
            </div>
            <div class="col-4">
                <h4>Forma de pagamento</h4>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mdlFormaPagamento">
                    Abrir
                </button>
            </div>
        </div>
        <div class="form-row">

        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <?php
                echo form_submit('enviar', 'Cadastrar', array(
                    'class' => 'btn btn-success form-control',
                    'id'    => 'enviar'
                ));
                ?>
            </div>
        </div>
    </form>
</div>

<!-- modais -->
<div class="modal fade" id="mdlPartesProcesso" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Partes do processo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover table-striped" id="tabelaPartesServico">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               
                <a data-toggle="modal" href="#mdlAdicionarPartesProcessoSemCadastro" class="btn btn-warning">Sem cadastro</a>
                <a data-toggle="modal" href="#mdlAdicionarPartesProcesso" class="btn btn-primary">Adicionar</a>                
                <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlAdicionarPartesProcessoSemCadastro" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Digite o nome da parte <b>não</b> contratante</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" id="edtNomeSemCadastro" class="form-group col-12"></input>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" id="btnConfirmaSemCadastro">Confirmar</a>
                <a href="#" data-dismiss="modal" id="btnFecharSemCadastro" class="btn btn-secondary">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlAdicionarPartesProcesso" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pesquisar parte</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" id="edtPesquisaCliente" class="form-group col-12"></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-hover table-striped" id="tabelaPesquisaCliente">
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" id="btnConfirmaPesquisaCliente">Confirmar</a>
                <a href="#" data-dismiss="modal" id="btnFecharPesquisaCliente" class="btn btn-secondary">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlFormaPagamento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Forma de pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="container"></div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-row">
                        <div class="col-12">
                            <h4>Informe o valor da entrada</h4>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-2 form-group">
                            <?php
                            echo form_input(
                                array(
                                    'id'  => 'edtVlDinheiro',
                                    'name'  => 'edtVlDinheiro',
                                    'onKeyUp' => 'formatarMoeda(this);',
                                    'class' => 'form-control',
                                    'style' => 'text-align:right',
                                ),
                                set_value('edtVlDinheiro')
                            );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>Número de prestações</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 form-group">
                            <?php
                            echo form_input(
                                array(
                                    'id'  => 'edtNumeroPrestacoes',
                                    'name'  => 'edtNumeroPrestacoes',
                                    'class' => 'form-control',
                                    'type' => 'number'
                                ),
                                set_value('edtNumeroPrestacoes')
                            );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 tabela">
                            <table id="tabelaPrestacoesCartao" class="table table-hover table-striped">
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('rodape'); ?>
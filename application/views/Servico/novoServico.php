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

    .tabela {
        max-height: calc(100vh - 510px);
        overflow-y: auto;
    }
</style>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js"); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.1.1/jspdf.umd.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //ao apertar enter pula para o proximo campo
        //----------------------------------------------------------------------------------------        
        pularCampos();
        //----------------------------------------------------------------------------------------
        $('#edtPesquisaCliente').on('keyup', function(e) {
            pesquisaCliente();
        });

        let OPCadastro = "N";
        var codServico = 0;
        var URLAtual = window.location.href;

        //se nao for um cadastro novo, preenche o campo
        if (URLAtual.indexOf("Novo") == -1) {
            OPCadastro = "A";
            codServico = <?php if (isset($codigoCadastro)) echo $codigoCadastro;
                            else echo "0" ?>;
            $("#enviar").val("Gerar contrato");


            var filtro = new Object();
            filtro.codServico = codServico;
            $.ajax({
                url: pegarRotaBack('servico/'),
                type: "GET",
                data: filtro
            }).done(function(resposta) {
                let registro = resposta.registros[0];

                $("#cmbTipoProcesso").val(registro.cod_tipo_processo);
                $("#cmbTipoServico").val(registro.cod_tipo_servico);
                $("#cmbTipoAcao").val(registro.cod_tipo_acao);

                $("#edtValorServico").val(formatFloat(registro.valor_servico));
                $("#edtVlEntrada").val(formatFloat(registro.prestacoesCartao[0].valor_entrada));



                //partes Servico
                let partesServico = registro.partesServico;                
                tabelaPartesServico.clear();
                let dataSet = [];
                tabelaPartesServico.clear();
                $.each(partesServico, function(index, data) {
                    dataSet.push([
                        data.cod_parte,
                        data.nome_parte,
                        data.cpf,
                        data.rg,
                        ''                        
                    ]);
                });
                tabelaPartesServico.rows.add(dataSet).draw();            



                let prestacoesCartao = registro.prestacoesCartao;
                $("#edtNumeroPrestacoes").val(prestacoesCartao.length);

                dataSet = [];
                tabelaPrestacoesCartao.clear();
                $.each(prestacoesCartao, function(index, data) {
                    let dataPago = formatDateTime(data.data_pago);
                    if (dataPago == "")
                        dataPago = "<b>Em aberto</b>";


                    /*let checkado = "";
                    if (data.data_pago != null)
                        checkado = "checked";*/
                    dataSet.push([data.numero_parcela,
                        '<input type="text" maxlength="10" class="form-control" style="text-align:center" onKeyUp="MascaraData(this);" value="' + formatDateTime(data.data_vencimento) + '">',
                        '<input type="text" class="form-control" style="text-align:right" onKeyUp="formatarMoeda(this);" value="' + formatFloat(data.valor_parcela) + '">',
                        //Formas de pagamento
                        '<select class="form-control cmbFormaPagamento"> ' +
                        '<option value="' + data.cod_forma_pagamento + '">' + data.nome_forma_pagamento + '</option>' +
                        '</select> ',
                        dataPago
                        //'<input class="form-check-input mx-auto px-auto" type="checkbox" class="chcPago" ' + checkado + '>'
                    ]);
                });
                tabelaPrestacoesCartao.rows.add(dataSet).draw();


                //no final, desabilito todos os campos..
                $(".form-control").prop("disabled", true);
                $(".desabilitar").remove();
                $(".form-check-input").prop("disabled", true);
                $("#enviar").prop("disabled", false);
            }).fail(function(jqXHR, status, err) {
                if (StrToInt(status) == 0) {
                    exibirMensagemAviso('Aviso!', 'Servidor não encontrado');
                }
            });
        }



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
                },
                {
                    title: 'RG'
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
                    title: 'CPF'
                },
                {
                    title: 'RG'
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
                //itemEscolhido.splice(2, 1);
                tabelaPartesServico.row.add(itemEscolhido).draw();
                $("#btnFecharPesquisaCliente").trigger("click");
            }
        });

        $('#btnConfirmaSemCadastro').on('click', function() {
            let nomeParteSemCadastro = $("#edtNomeSemCadastro").val();
            tabelaPartesServico.row.add(["",
                nomeParteSemCadastro,
                "",
                "",
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

        //quando clicar no botao de abrir a forma de pagamento, verifica se ja digitou algum valor
        $("#btnAbrirFormaPagamento").on('click', function(e) {
            let vlServico = $("#edtValorServico").val();
            vlServico = StrToFloat(vlServico);

            if (vlServico == 0)
                exibirMensagem('Aviso!', 'Não é possível adicionar forma de pagamento sem o valor do serviço definido!', 'info');
            else {
                $('#mdlFormaPagamento').modal('show');
                /*if ($("#edtNumeroPrestacoes").val() == "") {
                    $("#edtNumeroPrestacoes").val("1");
                    calcularPrestacoes();
                }*/
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
                        data.rg,
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

        $('#edtVlEntrada').on('keyup', function() {
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

            var vlEntrada = $("#edtVlEntrada").val();
            vlEntrada = vlEntrada.replaceAll(".", "");
            vlEntrada = vlEntrada.replaceAll(",", ".");
            vlEntrada = parseFloat(vlEntrada).toFixed(2);
            if (isNaN(vlEntrada)) {
                vlEntrada = 0;
            }

            qtdePrestacoes = parseFloat($("#edtNumeroPrestacoes").val());
            if (isNaN(qtdePrestacoes)) {
                qtdePrestacoes = 0;
            }
            //fim declaracao variavel

            if (qtdePrestacoes == 0) {
                tabelaPrestacoesCartao.clear();
            }
            //se possuir numero de parcela, calcula as prestacoes com base no valorServico - valorEntrada -valordinheiro
            else {

                let vlTotalAPagarParcelado = vlTotalServico - vlEntrada;
                let vlParcelaUnitaria = parseFloat((vlTotalAPagarParcelado / qtdePrestacoes).toFixed(2)); //arredondar

                let vlPrimeiraParcelaCorrigida = vlParcelaUnitaria + (vlTotalAPagarParcelado - (vlParcelaUnitaria * qtdePrestacoes));
                var dataSet = [];
                for (var n = 1; n <= qtdePrestacoes; n++) {
                    let dataParcela = new Date();
                    let valorVez = vlParcelaUnitaria;
                    if (n == 1) {
                        valorVez = vlPrimeiraParcelaCorrigida;
                    }
                    valorVez = valorVez.toFixed(2);
                    var v = valorVez.replace(/\D/g, '');
                    v = (v / 100).toFixed(2) + '';
                    v = v.replace(".", ",");
                    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
                    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
                    valorVez = v;


                    //pega um mes afrente
                    dataParcela = new Date(dataParcela.getFullYear(), dataParcela.getMonth() + (n), dataParcela.getDate())
                    dataParcela = formatDateTime(dataParcela);


                    dataSet.push([
                        n,
                        '<input type="text" maxlength="10" class="form-control" style="text-align:center" onKeyUp="MascaraData(this);" value="' + dataParcela + '">',
                        '<input type="text" class="form-control" style="text-align:right" onKeyUp="formatarMoeda(this);" value="' + valorVez + '">',
                        //Formas de pagamento
                        '<select class="form-control cmbFormaPagamento"> ' +
                        '</select> ',
                        '<input class="form-check-input mx-auto px-auto" type="checkbox" class="chcPago">'
                    ]);

                    tabelaPrestacoesCartao.clear();
                    tabelaPrestacoesCartao.rows.add(dataSet);
                }
            }

            tabelaPrestacoesCartao.draw();
            carregarFormasPagamento();
        }

        function carregarFormasPagamento() {
            if (OPCadastro == "N") {

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
                },
                {
                    title: 'Pago'
                }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            }
        });

        $('#enviar').on('click', function(e) {
            Confirmar(e);
        });

        async function Confirmar(event) {
            //declara todas as variaveis 
            let tipoServico = StrToInt($("#cmbTipoServico").val());
            let tipoAcao = StrToInt($("#cmbTipoAcao").val());
            let tipoProcesso = StrToInt($("#cmbTipoProcesso").val());

            event.preventDefault();
            msgConfirmacao = "";

            let vlTotalServico = StrToFloat($("#edtValorServico").val());
            let vlEntrada = StrToFloat($("#edtVlEntrada").val());

            if (vlTotalServico == 0) {
                msgConfirmacao += "Informe o valor do serviço.<br>";
            }

            if (tipoServico == 0) {
                msgConfirmacao += "Informe o tipo do serviço.<br>";
            }

            if (tipoAcao == 0) {
                msgConfirmacao += "Informe o tipo da ação.<br>";
            }

            if (tipoProcesso == 0) {
                msgConfirmacao += "Informe o tipo de processo.<br>";
            }

            let somaParcelas = 0;
            tabelaPrestacoesCartao.data().each(function(value, index) {
                valorParcela = StrToFloat(tabelaPrestacoesCartao.cell(index, 2).nodes().to$().find('input').val());
                somaParcelas += valorParcela; //valor
            });
            somaParcelas = parseFloat(somaParcelas.toFixed(2));

            if (vlEntrada + somaParcelas != vlTotalServico) {
                msgConfirmacao += "Valor de serviço em aberto. <br> Total: R$ " + formatFloat(vlTotalServico) +
                    "<br> Entrada: R$ " + formatFloat(vlEntrada) +
                    "<br> Soma das parcelas: R$ " + formatFloat(somaParcelas) + ".<br>";

            }

            if (tabelaPartesServico.data().count() == 0)
                msgConfirmacao += "Informe pelo menos uma parte no processo.<br>";



            if (msgConfirmacao != "") {
                exibirCamposObrigatorios(msgConfirmacao);
            } else {

                //monto o json para mandaar pro back
                var objeto = new Object();
                objeto.valorServico = vlTotalServico;
                objeto.valorEntrada = vlEntrada;
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
                    novoObjeto.valor = StrToFloat(tabelaPrestacoesCartao.cell(index, 2).nodes().to$().find('input').val());
                    novoObjeto.formaPagamento = tabelaPrestacoesCartao.cell(index, 3).nodes().to$().find('select').val();
                    novoObjeto.OPPago = tabelaPrestacoesCartao.cell(index, 4).nodes().to$().find('input').is(':checked');

                    dataSet.push(novoObjeto);
                });
                objeto.prestacoesCartao = dataSet;


                datasetPartesServico = [];
                tabelaPartesServico.data().each(function(value, index) {
                    var objPartesServico = new Object();
                    objPartesServico.codigo = StrToInt(tabelaPartesServico.cell(index, 0).data());
                    objPartesServico.nome = tabelaPartesServico.cell(index, 1).data();
                    objPartesServico.cpf = tabelaPartesServico.cell(index, 2).data();
                    objPartesServico.rg = tabelaPartesServico.cell(index, 3).data();
                    datasetPartesServico.push(objPartesServico);
                });
                objeto.partesServico = datasetPartesServico;

                var json = JSON.stringify(objeto);


                let OPGerarContrato = await exibirPergunta('Deseja gerar o contrato?', '', 'question');

                if (OPGerarContrato) {

                    OPGerarContrato = await exibirPergunta('Contrato de risco?', '', 'question');
                    if (OPGerarContrato == true) {
                        porcentagem = await exibirInput('Informe a porcentagem ','', 'info');
                        objeto.porcentagemRiscoContrato = StrToFloat(porcentagem);
                        gerarContrato(objeto);

                    } else
                        gerarContrato(objeto);
                }
                
                
                if (OPCadastro == "N") {
                    $.ajax({
                        url: pegarRotaBack('servico/cadastrar'),
                        contentType: 'application/json',
                        data: json,
                        type: 'post'
                    }).done(function(resposta, status, response) {
                        if (response.status != 200)
                            exibirMensagem(resposta.titulo, resposta.message, resposta.tipo)
                        else
                            window.location.href = "http://localhost/ControleAdvocaciaV2"; //voltar para a pagina inicial                        


                    }).fail(function(jqXHR, status, err) {
                        exibirMensagem('Erro!', 'Ocorreu um erro inesperado!', 'error');
                    });
                }
            }
        }

        async function gerarContrato(json) {
            async function calcularNewLine(texto) {
                var qtdeLinha = pdf.splitTextToSize(texto, 169);
                qtdeLinha = qtdeLinha.length;
                return (qtdeLinha * pdf.getLineHeight() / 2.3);
            }

            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF();
            const {
                valorServico,
                valorEntrada,
                prestacoesCartao,
                partesServico,
                porcentagemRiscoContrato
            } = json;

            valorServicoExtenso = valorMonetarioPorExtenso(valorServico); //true para valor quebrados(centavos)
            valorServicoMonetario = valorServico.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            valorEntradaMonetario = valorEntrada.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            let pagamento = "";
            if (json.porcentagemRiscoContrato == undefined) { //contrato normal
                pagamento += "no valor de ";
                if (valorServico > 0) {
                    pagamento = valorServicoMonetario + " (" + valorServicoExtenso + ")";
                }
                if (valorEntrada == valorServico)
                    pagamento += ", já pagos " + valorEntradaMonetario
                else if (valorEntrada > 0)
                    pagamento += ", pagos " + valorEntradaMonetario + " iniciais ";
                if (prestacoesCartao.length > 0) {
                    pagamento += "e demais parcelas mensais e consecutivas a partir de " + formatDateTime(prestacoesCartao[0].dataVencimento, 'DD/MM/YY');
                }
            } else { //contrato de risco
                let porcentagemRiscoContratoExtenso = valorMonetarioPorExtenso(porcentagemRiscoContrato);
                porcentagemRiscoContratoExtenso = porcentagemRiscoContratoExtenso.replace(/reais/gi, '');
                porcentagemRiscoContratoExtenso = porcentagemRiscoContratoExtenso.replace(/real/gi, '');
                porcentagemRiscoContratoExtenso = porcentagemRiscoContratoExtenso.replace(/centavo/gi, '');
                porcentagemRiscoContratoExtenso = porcentagemRiscoContratoExtenso.replace(/centavos/gi, '');

                pagamento = "o valor relativo a " + porcentagemRiscoContrato + "% ("+porcentagemRiscoContratoExtenso+"porcento) " +
                    "de todo o valor recebido ao final do processo, independentemente de título";
            }


            let stringPartesServico = "";
            for (let i = 0; i < partesServico.length; i++) {
                if (partesServico[i].codigo > 0) {
                    if (stringPartesServico != "")
                        stringPartesServico += ", ";
                    stringPartesServico += partesServico[i].nome;
                }
            }

            let margemEsquerda = 20;
            let limiteLinha = 169;
            let YPos = 29;
            let texto = "";

            await pdf.setFontSize(12);
            await pdf.setFont('helvetica'); //sinonimo para Arial

            //var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }; //quintafeira, 22 de dezembro de 2333
            let dataAtual = new Date();
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            let formato = dataAtual.toLocaleString('pt-BR', options);


            await pdf.text("São José dos Campos, " + formato + ".", margemEsquerda, YPos);
            YPos = 48.5;
            texto = "       Prezados Sr(s). " + stringPartesServico;
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto) * 1.3;


            texto = "       Cordiais saudações:";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto) * 2;


            texto = "    Venho por meio desta, confirmar nossos atendimentos, segundo os quais estou disposta a " +
                "prestar-lhe os meus serviços profissionais, consistentes nas ações: Embargos de Terceiro " +
                "contra ação de Imissão de posse do imóvel sito Rua Benedito Henrique, 20, Campo dos Alemães. ";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto);



            texto = "    Por tais serviços, V. S.a me pagará os honorários, certos e ajustados por esta carta com " +
                "força de contrato, " + pagamento + ", sendo que os honorários de sucumbência também " +
                "serão como definidos em lei, exclusivos do advogado.";

            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto);

            texto = "   Caso haja desistência por parte do cliente, ou qualquer outro ato que venha perder o objeto " +
                "da ação, ficará obrigado ao pagamento de honorários, à época do ato, no valor mínimo tabelado na " +
                "OAB, independente do estado em que se encontrar a ação, ainda, importa destacar, que os honorários " +
                "pactuados serão devidos, na ocorrência de outro advogado assumir as ações, seja por renúncia ou por rescisão.";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto) / 1.2;

            texto = "   Fica pactuado que os herdeiros e sucessores se obrigarão a cumprir os termos desta minuta de contrato. ";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto);

            texto = "   Estando V. S.a de acordo, e ciente que a presente contratação é serviço meio, onde " +
                "a contratada não se responsabiliza pela decisão feita pelo magistrado, queira devolver-me " +
                "a inclusa cópia, devidamente assinada e com o seu ACEITO.";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto);

            texto = "       Sendo só para o momento, agradecendo a distinção de sua preferência e confiança, subscrevo-me, atenciosamente.";
            await pdf.text(texto, margemEsquerda, YPos, {
                maxWidth: limiteLinha,
                align: 'justify'
            });
            YPos += await calcularNewLine(texto) * 2;


            //assinaturas

            let XPos = 140;
            for (let i = 0; i < partesServico.length; i++) {
                //so imprime no contrato se for cliente cadastrado
                if (partesServico[i].codigo > 0) {
                    //alterna entre esquerda e direita
                    if (XPos == 140)
                        XPos = 60
                    else
                        XPos = 140;

                    yposicao = YPos;

                    texto = "__________________________";
                    await pdf.text(texto, XPos, YPos, {
                        align: 'center'
                    });
                    YPos += await calcularNewLine(texto)

                    texto = partesServico[i].nome;
                    await pdf.text(texto, XPos, YPos, {
                        align: 'center'
                    });
                    YPos += await calcularNewLine(texto)

                    if (partesServico[i].cpf != "") {
                        texto = "CPF nº " + partesServico[i].cpf; // nº 48545815";
                        await pdf.text(texto, XPos, YPos, {
                            align: 'center'
                        });
                        YPos += await calcularNewLine(texto);
                    }


                    if (partesServico[i].rg != "") {
                        texto = "RG nº " + partesServico[i].rg; // nº 48545815";
                        await pdf.text(texto, XPos, YPos, {
                            align: 'center'
                        });
                        YPos += await calcularNewLine(texto);
                    }


                    YPos = yposicao;

                    if (XPos == 140)
                        YPos += 30;
                }
            } //fecha o for
            if (XPos == 140)
                XPos = 60
            else
                XPos = 140;

            texto = "__________________________";
            await pdf.text(texto, XPos, YPos, {
                align: 'center'
            });
            YPos += await calcularNewLine(texto);

            texto = 'TAIZ PRISCILA DA SILVA';
            await pdf.text(texto, XPos, YPos, {
                align: 'center'
            });
            YPos += await calcularNewLine(texto)

            texto = "OAB/SP 335.199";
            await pdf.text(texto, XPos, YPos, {
                align: 'center'
            });
            YPos += await calcularNewLine(texto);




            await pdf.output("dataurlnewwindow");
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
                        'id' => 'cmbTipoServico',
                        'autofocus' => 'true'
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
                <button type="button" class="btn btn-primary" id="btnAbrirFormaPagamento">
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

                <a data-toggle="modal" href="#mdlAdicionarPartesProcessoSemCadastro" class="btn btn-warning desabilitar">Sem cadastro</a>
                <a data-toggle="modal" href="#mdlAdicionarPartesProcesso" class="btn btn-primary desabilitar">Adicionar</a>
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
                                    'id'  => 'edtVlEntrada',
                                    'name'  => 'edtVlEntrada',
                                    'onKeyUp' => 'formatarMoeda(this);',
                                    'class' => 'form-control',
                                    'style' => 'text-align:right',
                                ),
                                set_value('edtVlEntrada')
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

                <a href="#" data-dismiss="modal" class="btn btn-secondary btnFecharModalFormaPagamento">Fechar</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('rodape'); ?>
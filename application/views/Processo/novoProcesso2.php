<?php $this->load->view('cabecalho'); ?>
<script>
    $(document).ready(function() {
        desativarBuscarCompetencia();
        //campos desativados e outros
        function desativarBuscarCompetencia(){
            $("#btnBuscarCompetencia").attr("disabled", true); 
        }

        if ($('input[name="cod_foro"]').val() != ""){
            $("#btnBuscarCompetencia").attr("disabled", false);
        }

        function confirmar(){            
            var retorno = true;
            var msg = "";

            var tipoAcao = $('select[name="tipo_acao"]').val();
            if (tipoAcao == ""){
                retorno = false;
                msg = msg + "- Tipo da ação<br>";
            }

            var grauPeticionamento = $('select[name="grau_peticionamento"]').val();
            if (grauPeticionamento == ""){
                retorno = false;
                msg = msg + "- Grau de peticionamento<br>";
            }

            var codForo = $('input[name="cod_foro"]').val();
            if (codForo == ""){
                retorno = false;
                msg = msg + "- Nome do foro<br>";
            }

            var codCompetencia = $('input[name="cod_competencia"]').val();
            if (codForo == ""){
                retorno = false;
                msg = msg + "- Competência<br>";
            }


            var assuntoPrincipal = $('input[name="assunto_principal"]').val();
            if (assuntoPrincipal == ""){
                retorno = false;
                msg = msg + "- Assunto principal<br>";

            }

            var classeProcesso = $('input[name="classe_processo"]').val();
            if (classeProcesso == ""){
                retorno = false;
                msg = msg + "- Classe do processo<br>";
            }

            //parseFloat($("#fullcost").text().replace(',', '.'));
            var valorAcao = parseFloat($('input[name="valor_acao"]').val().replace(',','.'));
            if ((isNaN(valorAcao)) || (valorAcao <= 0)){
                retorno = false;
                msg = msg + "Informe um valor para a ação<br>";
            }


            var dataDistribuicao = $('input[name="data_distribuicao"]').val();
            if ((dataDistribuicao != "") && (ValidaData(dataDistribuicao) == false)){
                retorno = false;
                msg = msg + "Informe uma data válida<br>";
            }

            //verifica se o processo tem algum advogado
            var advogadoNoProcesso = false;
            
            var table = $('#tabelaAdvogadoProcesso');
            table.find('tr').each(function(indice){
                var codAdvogadoProcesso = $(this).attr("data-cod");
                if (codAdvogadoProcesso > 0){
                    advogadoNoProcesso = true;
                }
            });

            if (advogadoNoProcesso == false){
                retorno = false;
                msg = msg + "Informe pelo menos um advogado para colocar no processo<br>";
            }






            
            if (retorno == false){
                exibirCamposObrigatorios(msg);                
            }
            return retorno;
        }


        $("#btnConfirmar").on('click', function(e){
            if (confirmar() == false){
                e.preventDefault();
            };


            
            /*
            var table = $('#tabelaAdvogadoProcesso');
            var advogados = "";
            table.find('tr').each(function(indice){
                var codAdvogadoProcesso = $(this).attr("data-cod");
                
                if (codAdvogadoProcesso == codAdvogado){
                    existe = true;
                }                
            });
            if (advogados != "")
                    advogados = advogados + ';';
                advogados = advogados + codAdvogadoProcesso;



                $('input[name="advogados"]').val(advogados);*/
        });

        //LIMPAR CAMPOS
        //-----------------------------------------------------------------------------------------
        $("#btnLimparForo").on('click', function(){
            $('input[name="cod_foro"]').val("");//pega pelo name
            $("#foro").val("");
            desativarBuscarCompetencia();
            $("#competencia").val("");
            $('input[name="cod_competencia"]').val("");//pega pelo name
        });
        $("#btnLimparCompetencia").on('click', function(){
            $("#competencia").val(""); 
            $('input[name="cod_competencia"]').val("");//pega pelo name
        });
        //-----------------------------------------------------------------------------------------

        //Competencia
        $('#competenciaModal').on('show.bs.modal', function(e){
            pesquisarCompetencia();
        });

        $('#iptPesqCompetencia').on('keyup', function(e){            
            pesquisarCompetencia();
        });
        
        function pesquisarCompetencia(){
            let codForo = $('input[name="cod_foro"]').val();
            let pesquisa = $("#iptPesqCompetencia").val();
            $.ajax({
                url: '<?php echo base_url('pCompetencia');?>',
                type: "post",
                data: "pesquisa="+pesquisa+"&cod_foro="+codForo                
            }).done(function(resposta){
                $("#tabelaCompetencia tr").remove(); //limpa os itn 
                $("#tabelaCompetencia h2").remove();
                let itens = resposta.registros;


                if (itens.length == 0){
                    $("#tabelaCompetencia").append("<h2>Não há registros</h2>");
                }
                for(var i=0;itens.length>i;i++){
                    //Adicionando registros retornados na tabela
                    $("#tabelaCompetencia tbody").append("<tr>"+
                                            "<td></td>"+
                                            "<td>"+
                                                "<input class=\"form-check-input\" type=\"radio\" name=\"rdbCompetencia\" id=\""+itens[i].cod_competencia+"\" value=\""+itens[i].nome_competencia+"\">"+
                                            "</td>"+
                                            "<td>"+
                                                "<label class=\"form-check-label\" name=\"lbl\" for=\""+itens[i].cod_competencia+"\">"+
                                                    itens[i].nome_competencia+
                                                "</label>"+
                                            "</td>"+
                                        "</tr>");
                }
            });           
        }

        //adicionar novo competencia
        $("#btnAdicionarCompetencia").on('click', function(e){
            let nomeCompetencia = $("#iptNomeCompetencia").val();
            
            $.ajax({
                url: '<?php echo base_url('aCompetencia');?>',
                type: "post",
                data: {'nome_competencia': nomeCompetencia},
            }).done(function(resposta){
                if (resposta.type != 'success'){
                    exibirCamposObrigatorios(resposta.message);
                }
                else if (resposta.type == 'success'){
                    pesquisarCompetencia();
                    $("#iptNomeCompetencia").val("");
                    exibirMensagemSucesso('Competência adicionada com sucesso!');
                }                              
            });

        });

        

        $('#competenciaModal').on('hide.bs.modal', function(e){
            var selecionado = $("input[name='rdbCompetencia']:checked").val();
            if (selecionado != undefined){
                var idSelecionado = $("input[name='rdbCompetencia']:checked")[0].id;

                $('input[name="cod_competencia"]').val(idSelecionado);
                $("#competencia").val(selecionado);
                $("#btnBuscarCompetencia").attr("disabled", false);
                $("#cod_competencia").val(idSelecionado);
            }
        });  

        //foro
        //-----------------------------------------------------------------------------------------
        $('#iptPesqForo').on('keyup', function(e){            
            pesquisarForo();
        }); 

        //adicionar novo foro
        $("#btnAdicionarForo").on('click', function(e){
            let nomeForo = $("#iptNomeForo").val();
            
            $.ajax({
                url: '<?php echo base_url('aForo');?>',
                type: "post",
                data: "nome_foro="+nomeForo                
            }).done(function(resposta){
                if (resposta.type != 'success'){
                    exibirCamposObrigatorios(resposta.message);
                }
                else if (resposta.type == 'success'){
                    pesquisarForo();
                    $("#iptNomeForo").val("");
                    exibirMensagemSucesso('Foro adicionado com sucesso!');
                }                              
            });

        });

        //pesquisar foro
        function pesquisarForo(){
            let pesquisa = $("#iptPesqForo").val();
            $.ajax({
                url: '<?php echo base_url('pForo');?>',
                type: "post",
                data: "pesquisa="+pesquisa                
            }).done(function(resposta){
                $("#tabelaForo tr").remove(); //limpa os itn               
                let itens = resposta.registros;    
            
                
                for(var i=0;itens.length>i;i++){
                    //Adicionando registros retornados na tabela
                    $("#tabelaForo").append("<tr id='foro_"+itens[i].cod_foro+"'>"+
                                            "<td></td>"+
                                            "<td>"+
                                            "<input class=\"form-check-input\" type=\"radio\" name=\"rdbForo\" id=\""+itens[i].cod_foro+"\" value=\""+itens[i].nome_foro+"\">"+
                                                "<label name=\"lbl\" for=\""+itens[i].cod_foro+"\">"+
                                                    itens[i].nome_foro+
                                                "</label>"+
                                            "</td>"+
                                            "<td>"+
                                                "<button type=\"button\" data-id=\""+itens[i].cod_foro+"\" class=\"btnExcluirForo btn btn-danger\">X</button>"+
                                            "</td>"+
                                        "</tr>");
                }                
            });            

        }        

        //excluir foro
        $('#tabelaForo').on('click', '.btnExcluirForo', function(e){
            var codForo = $(this).data('id')
            $.ajax({
				type: 'post',
				url: 'eForo',
				data: {'cod_foro': codForo}
			}).done(function(resposta){
                if (resposta.type == 'success'){
                    $('#foro_'+codForo).remove();    
                    pesquisarForo(); //pesquisa de novo após excluir                
                }
                else{
                    exibirMensagemErro('Ocorreu o seguinte erro', resposta.message);
                }
            });
        });

        $('#foroModal').on('hide.bs.modal', function(e){
            var selecionado = $("input[name='rdbForo']:checked").val();            

            desativarBuscarCompetencia();            

            if (selecionado != undefined){
                var idSelecionado = $("input[name='rdbForo']:checked")[0].id;

                $('input[name="cod_foro"]').val(idSelecionado);
                $("#foro").val(selecionado);
                $("#btnBuscarCompetencia").attr("disabled", false);
                $("#cod_foro").val(idSelecionado);
            }

            //se fechou o modal e o cod_foro ja tinha algum valor..
            if ($('input[name="cod_foro"]').val() != ""){
                $("#btnBuscarCompetencia").attr("disabled", false);
            }


        });   


        $('#foroModal').on('show.bs.modal', function(e){
            pesquisarForo();            
        });
        //-----------------------------------------------------------------------------------------

        //Advogado processo
        //-----------------------------------------------------------------------------------------
        $('#advogadoModal').on('show.bs.modal', function(e){
            pesquisarAdvogado();            
        });

        $("#tabelaAdvogadoProcesso").on('dblclick','tr', function() {
            //var codAdvogado = $(this).attr("data-cod");
            $(this).fadeOut(250,function (){$(this).remove()});
        });

        $("#tabelaAdvogado").on('dblclick','tr', function() {
            var codAdvogado = $(this).attr("data-cod");
            var nomeAdvogado = $(this).attr("data-nome");
            var existe = false;

            //verifica se o advogado ja esta no processo
            var table = $('#tabelaAdvogadoProcesso');
            table.find('tr').each(function(indice){
                var codAdvogadoProcesso = $(this).attr("data-cod");
                if (codAdvogadoProcesso == codAdvogado){
                    existe = true;
                }                
            });
        
            if (existe){
                exibirMensagemAviso('Aviso!','Advogado já está no processo.');
            }

            if (existe == false){
                $("#tabelaAdvogadoProcesso tbody").append("<tr data-nome=\""+nomeAdvogado+"\" data-cod=\""+codAdvogado+"\">"+
                                            "<td>"+
                                                "<label class=\"form-check-label\" name=\"lbl\" f>"+
                                                nomeAdvogado+
                                                "</label>"+
                                            "</td>"+
                                            "<td>"+
                                                "<button type=\"button\" class=\"btn btn-danger\">x</button>"+
                                            "</td>"+
                                        "</tr>");
            }  
        });

        function pesquisarAdvogado(){
            $.ajax({
                url: '<?php echo base_url('pAdvogado');?>',
                type: "post"
                //data: "pesquisa="+pesquisa                
            }).done(function(resposta){
                $("#tabelaAdvogado tr").remove(); //limpa os itn 
                $("#tabelaAdvogado h2").remove();
                let itens = resposta.registros;


                if (itens.length == 0){
                    $("#tabelaAdvogado").append("<h2>Não há registros</h2>");
                }
                for(var i=0;itens.length>i;i++){
                    //Adicionando registros retornados na tabela
                    $("#tabelaAdvogado tbody").append("<tr data-nome=\""+itens[i].nome_advogado+"\" data-cod=\""+itens[i].cod_advogado+"\">"+
                                            "<td>"+
                                                "<label class=\"form-check-label\" name=\"lbl\" for=\""+itens[i].cod_advogado+"\">"+
                                                    itens[i].nome_advogado+
                                                "</label>"+
                                            "</td>"+
                                            "<td>"+
                                                "<button type=\"button\" class=\"btn btn-success\">+</button>"+
                                            "</td>"+
                                        "</tr>");
                }
            });           
        }
        //-----------------------------------------------------------------------------------------

        //pesquisar token

        $('#pesquisar_token').on('keyup', function(e){            
            pesquisarForo();
        }); 
        function pesquisarForo(){
            let codForo = $('input[name="cod_foro"]').val();
            let pesquisa = $("#iptPesqCompetencia").val();
            let a = [];
            $.ajax({
                url: '<?php echo base_url('pTokenEscavador');?>',
                type: "post",
                //data: "pesquisa="+pesquisa+"&cod_foro="+codForo                
            }).done(function(resposta){
                let itens = resposta.registros[0];
                //console.log(itens);
                
                $.ajax({                    
                    url: 'https://api.escavador.com/api/v1/quantidade-creditos',
                    type:"get",
                    crossdomain: true,
                    dataType:"application/json",
                    contentType: 'application/json',
                    headers: {
                        "Authorization": "Bearer "+itens.access_token
                        //'Access-Control-Allow-Origin': '*'
                        //Access-Control-Allow-Headers: x-requested-with 
                    }
                }).done(function(resposta){
                    console.log(resposta);
                });

                var jzao =[{"id":119627788,"numero_antigo":null,"numero_novo":"2135935-80.2020.8.26.0000","created_at":"2020-06-22 05:21:29","updated_at":"2020-06-22 05:21:29","diario_sigla":"DJSP","diario_nome":"Di\u00e1rio de Justi\u00e7a do Estado de S\u00e3o Paulo (S\u00e3o Paulo)","estado":"SP","data_movimentacoes":"22\/06\/2020 a 05\/10\/2020","quantidade_movimentacoes":4,"ultimas_movimentacoes_resumo":[{"id":541697808,"data":"2020-10-05 00:00:00","link_api":"https:\/\/api.escavador.com\/api\/v1\/movimentacoes\/541697808","envolvidos_resumo":[{"id":17972548,"nome":"Adriano de Assis Antonio","objeto_type":"Pessoa","pivot_tipo":"AGRAVANTE","pivot_outros":"NAO","pivot_extra_nome":"(Justi\u00e7a Gratuita)","link":"https:\/\/www.escavador.com\/sobre\/136793350\/adriano-de-assis-antonio","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/26583678","nome_sem_filtro":"Adriano de Assis Antonio","envolvido_tipo":"Agravante","envolvido_extra_nome":"(Justi\u00e7a Gratuita)","oab":"","advogado_de":null},{"id":1301,"nome":"Banco Santander (Brasil) S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/25150225\/banco-santander-brasil-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/612738","nome_sem_filtro":"Banco Santander (Brasil) S\/A","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":16322139,"nome":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/129157621\/cooperativa-credito-mutuo-servidores-municipais-vale-paraiba-litoral-norte-serra","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/5366194","nome_sem_filtro":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":42601,"nome":"Caixa Seguradora S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADA","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/24799580\/caixa-seguradora-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/262093","nome_sem_filtro":"Caixa Seguradora S\/A","envolvido_tipo":"Agravada","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":15486232,"nome":"Maia da Rocha","objeto_type":"Pessoa","pivot_tipo":"RELATOR","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/126370064\/maia-da-rocha","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/24522726","nome_sem_filtro":"Maia da Rocha","envolvido_tipo":"Relator","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":1273802,"nome":"Taiz Priscila da Silva","objeto_type":"Pessoa","pivot_tipo":"ADVOGADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/10101271\/taiz-priscila-da-silva","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/9858488","nome_sem_filtro":"Taiz Priscila da Silva","envolvido_tipo":"Advogado","envolvido_extra_nome":"","oab":"335199\/SP","advogado_de":null}],"quantidade_envolvidos":9,"conteudo_resumo":"Processo Digital. Peti\u00e7\u00f5es para juntada devem ser apresentadas exclusivamente por meio eletr\u00f4nico, n... "},{"id":527090317,"data":"2020-07-21 00:00:00","link_api":"https:\/\/api.escavador.com\/api\/v1\/movimentacoes\/527090317","envolvidos_resumo":[{"id":17972548,"nome":"Adriano de Assis Antonio","objeto_type":"Pessoa","pivot_tipo":"AGRAVANTE","pivot_outros":"NAO","pivot_extra_nome":"(Justi\u00e7a Gratuita)","link":"https:\/\/www.escavador.com\/sobre\/136793350\/adriano-de-assis-antonio","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/26583678","nome_sem_filtro":"Adriano de Assis Antonio","envolvido_tipo":"Agravante","envolvido_extra_nome":"(Justi\u00e7a Gratuita)","oab":"","advogado_de":null},{"id":1301,"nome":"Banco Santander (Brasil) S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/25150225\/banco-santander-brasil-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/612738","nome_sem_filtro":"Banco Santander (Brasil) S\/A","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":16322139,"nome":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/129157621\/cooperativa-credito-mutuo-servidores-municipais-vale-paraiba-litoral-norte-serra","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/5366194","nome_sem_filtro":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":42601,"nome":"Caixa Seguradora S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADA","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/24799580\/caixa-seguradora-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/262093","nome_sem_filtro":"Caixa Seguradora S\/A","envolvido_tipo":"Agravada","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":15486232,"nome":"Maia da Rocha","objeto_type":"Pessoa","pivot_tipo":"RELATOR","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/126370064\/maia-da-rocha","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/24522726","nome_sem_filtro":"Maia da Rocha","envolvido_tipo":"Relator","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":1273802,"nome":"Taiz Priscila da Silva","objeto_type":"Pessoa","pivot_tipo":"ADVOGADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/10101271\/taiz-priscila-da-silva","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/9858488","nome_sem_filtro":"Taiz Priscila da Silva","envolvido_tipo":"Advogado","envolvido_extra_nome":"","oab":"335199\/SP","advogado_de":null}],"quantidade_envolvidos":9,"conteudo_resumo":"Processo Digital. Peti\u00e7\u00f5es para juntada devem ser apresentadas exclusivamente por meio eletr\u00f4nico, n... "},{"id":521433242,"data":"2020-06-22 00:00:00","link_api":"https:\/\/api.escavador.com\/api\/v1\/movimentacoes\/521433242","envolvidos_resumo":[{"id":74568889,"nome":"1011360-32.2020.8.26.0577","objeto_type":"Pessoa","pivot_tipo":"N\u00b0 ORIGEM","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/759274127\/1011360-3220208260577","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/78735990","nome_sem_filtro":"1011360-32.2020.8.26.0577","envolvido_tipo":"N\u00b0 Origem","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":17972548,"nome":"Adriano de Assis Antonio","objeto_type":"Pessoa","pivot_tipo":"AGRAVANTE","pivot_outros":"NAO","pivot_extra_nome":"(Justi\u00e7a Gratuita)","link":"https:\/\/www.escavador.com\/sobre\/136793350\/adriano-de-assis-antonio","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/26583678","nome_sem_filtro":"Adriano de Assis Antonio","envolvido_tipo":"Agravante","envolvido_extra_nome":"(Justi\u00e7a Gratuita)","oab":"","advogado_de":null},{"id":1273802,"nome":"Taiz Priscila da Silva","objeto_type":"Pessoa","pivot_tipo":"ADVOGADA","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/10101271\/taiz-priscila-da-silva","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/9858488","nome_sem_filtro":"Taiz Priscila da Silva","envolvido_tipo":"Advogada","envolvido_extra_nome":"","oab":"335199\/SP","advogado_de":null},{"id":1301,"nome":"Banco Santander (Brasil) S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/25150225\/banco-santander-brasil-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/612738","nome_sem_filtro":"Banco Santander (Brasil) S\/A","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":10869571,"nome":"Joao Thomaz Prazeres Gondim","objeto_type":"Pessoa","pivot_tipo":"ADVOGADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/11892728\/joao-thomaz-prazeres-gondim","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/11670192","nome_sem_filtro":"Joao Thomaz Prazeres Gondim","envolvido_tipo":"Advogado","envolvido_extra_nome":"","oab":"62192\/RJ, 162337\/MG, 270757\/SP, 6219200\/RJ, 18694\/ES, 60602\/BA, 43218\/GO, 63682\/PR, 6060200\/BA, 24862\/MS","advogado_de":null},{"id":16322139,"nome":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/129157621\/cooperativa-credito-mutuo-servidores-municipais-vale-paraiba-litoral-norte-serra","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/5366194","nome_sem_filtro":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null}],"quantidade_envolvidos":7,"conteudo_resumo":"Processo Digital. Peti\u00e7\u00f5es para juntada devem ser apresentadas exclusivamente por meio eletr\u00f4nico, n... "},{"id":521436927,"data":"2020-06-22 00:00:00","link_api":"https:\/\/api.escavador.com\/api\/v1\/movimentacoes\/521436927","envolvidos_resumo":[{"id":17972548,"nome":"Adriano de Assis Antonio","objeto_type":"Pessoa","pivot_tipo":"AGRAVANTE","pivot_outros":"NAO","pivot_extra_nome":"(Justi\u00e7a Gratuita)","link":"https:\/\/www.escavador.com\/sobre\/136793350\/adriano-de-assis-antonio","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/26583678","nome_sem_filtro":"Adriano de Assis Antonio","envolvido_tipo":"Agravante","envolvido_extra_nome":"(Justi\u00e7a Gratuita)","oab":"","advogado_de":null},{"id":1273802,"nome":"Taiz Priscila da Silva","objeto_type":"Pessoa","pivot_tipo":"ADVOGADA","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/10101271\/taiz-priscila-da-silva","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/9858488","nome_sem_filtro":"Taiz Priscila da Silva","envolvido_tipo":"Advogada","envolvido_extra_nome":"","oab":"335199\/SP","advogado_de":null},{"id":1301,"nome":"Banco Santander (Brasil) S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/25150225\/banco-santander-brasil-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/612738","nome_sem_filtro":"Banco Santander (Brasil) S\/A","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":10869571,"nome":"Joao Thomaz Prazeres Gondim","objeto_type":"Pessoa","pivot_tipo":"ADVOGADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/11892728\/joao-thomaz-prazeres-gondim","link_api":"https:\/\/api.escavador.com\/api\/v1\/pessoas\/11670192","nome_sem_filtro":"Joao Thomaz Prazeres Gondim","envolvido_tipo":"Advogado","envolvido_extra_nome":"","oab":"62192\/RJ, 162337\/MG, 270757\/SP, 6219200\/RJ, 18694\/ES, 60602\/BA, 43218\/GO, 63682\/PR, 6060200\/BA, 24862\/MS","advogado_de":null},{"id":16322139,"nome":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","objeto_type":"Instituicao","pivot_tipo":"AGRAVADO","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/129157621\/cooperativa-credito-mutuo-servidores-municipais-vale-paraiba-litoral-norte-serra","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/5366194","nome_sem_filtro":"Cooperativa de Credito Mutuo dos Servidores Municipais do Vale do Paraiba Litoral Norte e Serra da Mantiqueira Cressem","envolvido_tipo":"Agravado","envolvido_extra_nome":"","oab":"","advogado_de":null},{"id":42601,"nome":"Caixa Seguradora S\/A","objeto_type":"Instituicao","pivot_tipo":"AGRAVADA","pivot_outros":"NAO","pivot_extra_nome":null,"link":"https:\/\/www.escavador.com\/sobre\/24799580\/caixa-seguradora-s-a","link_api":"https:\/\/api.escavador.com\/api\/v1\/instituicoes\/262093","nome_sem_filtro":"Caixa Seguradora S\/A","envolvido_tipo":"Agravada","envolvido_extra_nome":"","oab":"","advogado_de":null}],"quantidade_envolvidos":6,"conteudo_resumo":"Processo Digital. Peti\u00e7\u00f5es para juntada devem ser apresentadas exclusivamente por meio eletr\u00f4nico, n... "}]}];
                jzao = jzao[0];
                console.log(jzao);


                
            });    

                
        }
    });
</script>

<!-- Modal Foro-->
<div class="modal fade" id="foroModal" tabindex="-1" role="dialog"  aria-labelledby="foroModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content lg-modal">
      <div class="modal-header">
          <h5> Pesquisar Foros </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0"> <!-- o pt padding-top -->        
        <div class="row sticky-top py-2 mr-0 px-1 bg-white">
            <div class="col-8">
            <?php
                echo form_input(array(  'name'  => 'pesquisa',
                                        'id' => 'iptPesqForo',
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'), 
                                        set_value('pesquisa'));
            ?>
            </div>
            <div class="col-4">
                <?php echo form_submit('enviar','Confirmar',array( 'class' => 'btn btn-success form-control', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
        
        <div class="form-row">
            <table id='tabelaForo' class="table table-hover">
                
            </table>
        </div>
        
      </div>
      <div class="form-row px-3 py-3 mb-2 bg-white">      
            <div class="col-9">
            <?php
                echo form_input(array(  'id' => 'iptNomeForo',
                                        'name'  => 'iptNomeForo',
                                        'placeHolder' => 'Não encontrou? Adicione aqui!',
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'), 
                                        set_value('iptNomeForo'));
            ?>
            </div>
            <div class="col-3">
                <?php echo form_submit('Enviar','Adicionar',array( 'class' => 'btn btn-primary form-control', 'id'=>'btnAdicionarForo')); ?>
            </div>
            
        </div>
      
    </div>
  </div>
</div>

<!-- Modal Competencia-->
<div class="modal fade" id="competenciaModal" tabindex="-1" role="dialog"  aria-labelledby="competenciaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content" >
      <div class="modal-header">
          <h5> Pesquisar Competências </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pt-0"> <!-- o pt padding-top -->        
        <div class="row sticky-top pt-2 pb-2 mr-2 bg-white">
            <div class="col-9">
            <?php
                echo form_input(array(  'name'  => 'pesquisa',
                                        'id' => 'iptPesqCompetencia',
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'), 
                                        set_value('pesquisa'));
            ?>
            </div>
            <div class="col-3">
                <?php echo form_submit('enviar','Confirmar',array( 'class' => 'btn btn-success form-control', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
        <div class="form-row"></div>
        <div class="form-row">
            <table id='tabelaCompetencia' class="table table-hover">
                <tr></tr>                                 
            </table>
        </div>
        
      </div>
      <!--<div class="form-row px-3 py-2 bg-white">
            <div class="col-9">
            <?php
                /*echo form_input(array(  'id' => 'iptNomeCompetencia',
                                        'name'  => 'iptNomeCompetencia',
                                        'placeHolder' => 'Não encontrou? Adicione aqui!',
                                        'autofocus' => 'autofocus',
                                        'class' => 'form-control',
                                        'autocomplete' => 'off'), 
                                        set_value('iptNomeCompetencia'));*/
            ?>
            </div>
            <div class="col-3">
                <?php //echo form_submit('Enviar','Adicionar',array( 'class' => 'btn btn-primary form-control', 'id'=>'btnAdicionarCompetencia')); ?>
            </div>
            
        </div>-->
      
    </div>
  </div>
</div>

<!-- Modal AdvogadosProcesso-->
<div class="modal fade" id="advogadoModal" tabindex="-1" role="dialog"  aria-labelledby="advogadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5> Pesquisar Advogados </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
            <div class="col-12">
                <p class="text-primary">Duplo clique para adicionar ou remover</p>
            </div>
        </div>
        <div class="form-row">
            
            <div class="col-6">
                <b><p class="">Advogados</p></b>
                <table id='tabelaAdvogado' class="table table-hover">
                    <tr></tr>                                 
                </table>            
            </div>
            <div class="col-6">
                <b><p class="">Advogados no processo</p></b>
                <table id='tabelaAdvogadoProcesso' class="table table-hover">
                    <tr></tr>                                 
                </table> 
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container">
    <?php 
        $hidden = ['cod_foro' => set_value('cod_foro',''),
                   'cod_competencia'=> set_value('cod_competencia',''), 
                   'advogados'=>set_value('advogados','')];
                   
        echo form_open('NovoProcesso','',$hidden); 
        if (isset($validacaoForm)){
            if ($validacaoForm != ""){      
                $validacaoForm = str_replace("\n","<br>",$validacaoForm);           
            
                echo "<script>exibirCamposObrigatorios(\"".$validacaoForm."\");</script>";
            }
        }
    ?>
    <div class="form-row">
        <div class="form-group col-md-6">        
            <label>Tipo ação</label>
            <?php 
                echo form_dropdown(array(   'class'=>'form-control',
                                            'name'=>'tipo_acao',
                                            'id'=>'tipo_acao'),
                                            $tipoAcao,
                                            set_value('tipo_acao'));
            ?> 
        </div> 
        <div class="form-group col-md-6">        
            <label for="cmbGrau">Grau do Peticionamento</label>
            <?php 
                echo form_dropdown(array(   'class'=>'form-control',
                                            'name'=>'grau_peticionamento',
                                            'id'  => 'cmbGrau'),
                                            $grauPeticionamento,
                                            set_value('grau_peticionamento'));
            ?> 
        </div>   
    </div>
    <div id="pet1Grau">        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="foro">Foro</label>
                <div class="input-group mb-3">                    
                <?php
                    echo form_input(array(  'id'    => 'foro',
                                            'name'  => 'foro',
                                            'maxlength' => 100,
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'readonly' => 'readOnly'), 
                                            set_value('foro'));
                ?>
                    <div class="input-group-append">
                        <button class="btn btn-outline-warning" id="btnLimparForo" type="button">Limpar</button>
                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#foroModal" id="btnBuscarForo" type="button">Buscar</button>
                    </div>
                </div>                    
            </div>

            <div class="form-group col-md-6">
            <label for="competencia">Competência</label>
                <div class="input-group mb-3">                    
                    <?php
                        echo form_input(array(  'id'  => 'competencia',
                                                'name'=>'competencia',
                                                'class'=>'form-control',
                                                'readonly'=>'readonly'),
                                                set_value('competencia'));
                    ?>   
                    <div class="input-group-append">
                        <button class="btn btn-outline-warning" id="btnLimparCompetencia" type="button">Limpar</button>
                        <button class="btn btn-outline-info" data-toggle="modal" data-target="#competenciaModal" id="btnBuscarCompetencia" type="button">Buscar</button>
                    </div>
                </div>                                
            </div>  

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nome_peticionante">Classe do processo</label>
                <?php
                    echo form_input(array(  'id'    => 'classe_processo',
                                            'name'  => 'classe_processo',
                                            'maxlength' => 100,
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control'), 
                                            set_value('classe_processo'));
                ?>
            </div>
            <div class="form-group col-md-6">
                <label for="nome_peticionante">Assunto principal</label>
                <?php
                    echo form_input(array(  'id'    => 'assunto_principal',
                                            'name'  => 'assunto_principal',
                                            'maxlength' => 100,
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control'), 
                                            set_value('assunto_principal'));
                ?>                             
            </div>  
        </div>
        <div class="form-row">  
            <div class="form-group col-md-2">
                <label for="nome_peticionante">Advogados do processo</label>
                <button type="button" data-toggle="modal" data-target="#advogadoModal" class="btn btn-primary">Abrir</button>               
            </div>           
            <div class="form-group col-md-2">
                <label for="nome_peticionante">Valor da ação</label>
                <?php
                    echo form_input(array(  'name'  => 'valor_acao',
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'onKeyUp' => 'formatarMoeda(this);'), 
                                            set_value('valor_acao'));
                ?>                             
            </div>  
            <div class="form-group col-md-2">
                <label>Data distribuição</label>
                <?php
                    echo form_input(array(  'name'  => 'data_distribuicao',
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'maxlength' => 10,
                                            'onKeyPress' => 'MascaraData(data_distribuicao)'), 
                                            set_value('data_distribuicao'));
                ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="pesquisar_token">pesquisar Token</label>
                <?php
                    echo form_textarea(array(  'id'    => 'pesquisar_token',
                                            'name'  => 'pesquisar_token',
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control'), 
                                            set_value('pesquisar_token'));
                ?>                             
            </div> 
        </div>
        <div class="form-row">
        <fieldset class="border p-2">
            <legend  class="w-auto">Outros</legend>
            <div class="form-check">
            <?php                
                echo form_checkbox('',true, set_checkbox('dependencia',true), 
                                                    array(  'name'=>'dependencia',
                                                            'class'=>'form-check-input'));
            ?>
                <label class="form-check-label">
                    Dependência
                </label>
            </div>
            <div class="form-check">
            <?php                
                echo form_checkbox('',true, set_checkbox('segredo_justica',true), 
                                                    array(  'name'=>'segredo_justica',
                                                            'class'=>'form-check-input'));
            ?>
                <label class="form-check-label">
                    Segredo de justiça
                </label>
            </div>
            <div class="form-check">
                <?php
                
                    echo form_checkbox('',true, set_checkbox('gratuidade_justica',true), 
                                                        array(  'name'=>'gratuidade_justica',
                                                                'class'=>'form-check-input'));
                ?>
                <label class="form-check-label" for="defaultCheck1">
                    Gratuidade de justiça
                </label>
            </div>
            <div class="form-check">
            <?php                
                echo form_checkbox('',true, set_checkbox('preso',true), 
                                                    array(  'name'=>'preso',
                                                            'class'=>'form-check-input'));
            ?>
                <label class="form-check-label" for="defaultCheck1">
                    Preso
                </label>
            </div>
            <div class="form-check">
            <?php                
                echo form_checkbox('',true, set_checkbox('liberdade_provisoria',true), 
                                                    array(  'name'=>'liberdade_provisoria',
                                                            'class'=>'form-check-input'));
            ?>
                <label class="form-check-label" for="defaultCheck1">
                    Liberdade provisória
                </label>
            </div>
        </fieldset>
            
        </div>
    </div> <!-- 1 grau -->
    <br>

    <div class="form-group">
        <?php echo form_submit('enviar','Confirmar',array( 'class' => 'btn btn-success form-control', 'id'=>'btnConfirmar')); ?>
    </div>
    
    <?php echo form_close(); ?>
</div>
<?php $this->load->view('rodape'); ?>
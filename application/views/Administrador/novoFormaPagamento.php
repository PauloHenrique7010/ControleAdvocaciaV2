<?php $this->load->view('Administrador/cabecalho'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<!-- jQuery -->
<script src="<?php echo base_url("assets/Administrador/plugins/jquery/jquery.min.js"); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url("assets/Administrador/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url("assets/Administrador/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url("assets/Administrador/dist/js/adminlte.min.js"); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url("assets/Administrador/dist/js/demo.js"); ?>"></script>
<!-- page script -->
<script type="text/javascript">
    $(document).ready(function() {
        let OPCadastro = "N";
        var codFormaPagamento= 0;
        var URLAtual = window.location.href;

        //se nao for um cadastro novo, preenche o campo
        if (URLAtual.indexOf("Novo") == -1) {
            OPCadastro = "A";
            codFormaPagamento = JSON.parse(sessionStorage.getItem('codFormaPagamento'));

            var json = new Object();
            json.codFormaPagamento = codFormaPagamento;
            $.ajax({
                url: pegarRotaBack('formaPagamento/'),
                type: 'GET',
                data: json
            }).done(function(resposta, status, response) {
                if (response.status == 200)
                    $("#edtNomeFormaPagamento").val(resposta.registros[0].nome_forma_pagamento)
                else {
                    let titulo = response.responseJSON.title;
                    let msg = response.responseJSON.message;
                    let tipo = response.responseJSON.tipo;

                    exibirMensagem(titulo, msg, tipo);
                }
            }).fail(function(jqXHR, status, err) {
                exibirMensagemErro(jqXHR.responseJSON.title, jqXHR.responseJSON.message);
            });
        }

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

        $('#btnConfirmar').on('click', function(e) {
            Confirmar(e);
        });

        function Confirmar(event) {
            //declara todas as variaveis 
            var nomeFormaPagamento = $("#edtNomeFormaPagamento").val();

            event.preventDefault();
            OPConfirmar = true;
            msgConfirmacao = "";

            if (nomeFormaPagamento == "") {
                msgConfirmacao += "Informe o nome da forma de pagamento<br>";
                OPConfirmar = false;
            }
            if (OPConfirmar == false) {
                exibirCamposObrigatorios(msgConfirmacao);
            } else {
                tipoRequisicao = "PUT";
                if (OPCadastro == "N")
                    tipoRequisicao = "POST";            

                //monto o json para mandaar pro back
                var json = new Object();
                json.codFormaPagamento = codFormaPagamento;
                json.nomeFormaPagamento = nomeFormaPagamento;

                $.ajax({
                    url: pegarRotaBack('formaPagamento/'),
                    type: tipoRequisicao,
                    contentType: 'application/json',
                    data: JSON.stringify(json)
                }).done(function(resposta, status, response) {
                    let titulo = response.responseJSON.title;
                    let msg = response.responseJSON.message;
                    let tipo = response.responseJSON.tipo;

                    //se nao foi sucesso, exibe msg..
                    if (response.status != 200)
                        exibirMensagem(titulo, msg, tipo)
                    else
                        window.location.href = "http://localhost/ControleAdvocaciaV2/Admin/FormaPagamento"; //voltar para a pagina inicial                  
                }).fail(function(jqXHR, status, err) {
                    exibirMensagemErro(jqXHR.responseJSON.title, jqXHR.responseJSON.message);
                });
            }
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
                    <h1 class="m-0 text-dark">Cadastrar forma de pagamento</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Configuracoes'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Profissões</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Prencha o campo</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nome forma de pagamento</label>
                                <input type="text" id="edtNomeFormaPagamento" class="form-control" placeholder="Exemplo: Dinheiro, Cartão" maxlength="30" autofocus="autofocus">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button class="btn btn-success form-control" id="btnConfirmar">Confirmar</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content -->


<?php $this->load->view('Administrador/rodape'); ?>
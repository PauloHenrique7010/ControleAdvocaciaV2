<?php $this->load->view('cabecalho'); ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js");?>"></script>
<!-- Editor html-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<!-- Editor html-->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#summernote').summernote({
        placeholder: 'Campo reservado para descrever o cliente, para quando no futuro ao abrir o cadastro, possa se lembrar quem é o cliente. <br> Ex: Filho da fulana dono de tal lugar',
        tabsize: 2,
        height: 200
      });

      $('#enviar').on('click', function(e){
          validar(e);
      });

      function validar(e){
        msgValidacao = "";
        

        $idInput = $("#corpoModal input").last().attr("id");
        if (typeof $idInput === "undefined"){
            numCel = 0;
        }
        else{
            numCel = parseInt($("#corpoModal input").last().attr("id"));
        }

        if (numCel == 0){
            msgValidacao += "Informe pelo meno um telefone para contato<br>";            
        }


        if (msgValidacao != ""){            
            exibirCamposObrigatorios(msgValidacao);
            e.preventDefault();
        }

      }

      //ao apertar enter pula para o proximo campo
      //----------------------------------------------------------------------------------------
      jQuery('body').on('keydown', 'input, select, textarea, button', function(e) {
            var self = $(this)
                    , form = self.parents('form:eq(0)')
                    , focusable
                    , next
                    ;
                    
            //se pressionar ctrl + enter, confirma o cadastro
            if (e.ctrlKey && e.keyCode == 13) {
                $("#enviar").trigger('click');
            }
            else if (e.keyCode == 13) {
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

        let numCel = 0;
        $('#addCel').click(function (e) {

            $idInput = $("#corpoModal input").last().attr("id");
            if (typeof $idInput === "undefined"){
                numCel = 0;
            }
            else{
                numCel = parseInt($("#corpoModal input").last().attr("id"));
            }
            numCel = numCel+1; 
                 
            texto = "<div class=\"row\" id=\"row_"+numCel+"\"> "+
                                        "<div class=\"col-md-4\"> "+
                                            "<label>Celular "+numCel+"</label> "+
                                        "</div> "+
                                        "<div class=\"col-md-6\"> "+
                                            "<input type=\"text\" id=\""+numCel+"\" name=\"m_celular_"+numCel+"\" <?php echo set_value('m_celular_'."numCel"); ?>value id=\"m_celular_"+numCel+"\" maxlength =\"15\" onKeyUp=\"mascara( this, mtel );\" class=\"form-control modalInput\"> "+
                                        "</div> "+
                                        "<div class=\"col-md-2\"> "+
                                            "<button type=\"button\" data-id='"+numCel+"' class=\"btn btn-danger removerCel\">X</button> "+
                                        "</div> "+
                                    "</div><br id=\"br_"+numCel+"\">";
            adicionarCelular(texto); 
            
        });

        function adicionarCelular(texto){
            $('#corpoModal').append(texto);            
        }


        $('#corpoModal').on('click', '.removerCel', function(e){
            var cod = $(this).data('id');            
            $('#row_'+cod).fadeOut("normal", function() {
                $(this).remove();
            });
            $('#br_'+cod).fadeOut("normal", function() {
                $(this).remove();
            });
        });

        
    });

    //funcao que verifica se o cep esta digitado e tem endereço encontrado
    //quando isso acontecer ja cai no nome do pai para nao ter que passar pelos campos de novo
    function cepPreenchido(){
        var cep = document.getElementById("cep").value;
        var endereco = document.getElementById("endereco").value;

        if ((cep != "") && (endereco != "")){
            document.getElementById("nome_pai").focus();
        }        
    }     
</script>





<div class="container">
    <?php            
        echo form_open('NovoCliente','',array('cod_cliente'=>'000')); 
        if (isset($validacaoForm)){
            if ($validacaoForm != ""){      
                $validacaoForm = str_replace("\n","<br>",$validacaoForm);           
            
                echo "<script>exibirCamposObrigatorios(\"".$validacaoForm."\");</script>";
            }
        }
    ?>

    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="modal-title btn btn-success" id="addCel">Adicionar</button>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container" id="corpoModal">
            <?php
                if (isset($celulares)){
                    if ($celulares){
                        foreach ($celulares as $campo => $valor){
                            $num = $campo;
                            
                            $html = "<div class=\"row\" id=\"row_$num\"> ".
                                        "<div class=\"col-md-4\"> ".
                                            "<label>Celular $num</label> ".
                                        "</div> ".
                                        "<div class=\"col-md-6\"> ".
                                            "<input type=\"text\" id=\"$num\" name=\"m_celular_$num\" value=\"$valor\"  maxlength =\"15\" onKeyUp=\"mascara( this, mtel );\" class=\"form-control\"> ".
                                        "</div> ".
                                        "<div class=\"col-md-2\"> ".
                                            "<button type=\"button\" data-id='$num' class=\"btn btn-danger removerCel\">X</button> ".
                                        "</div> ".
                                        "</div><br id=\"br_$num\">";
                            echo $html;
                        }
                    }
                }
            ?>
          </div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    
    <div class="container">
        <div class="row">
            <h1><?php echo $tituloGuia; ?> </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h4 class="text-left">Nome do cliente</h4>
                <?php                        
                
                        echo form_input(array(  'id'    => 'nome_cliente',
                                                'name'  => 'nome_cliente',
                                                'maxlength' => 100,
                                                'autofocus' => 'autofocus',
                                                'class' => 'form-control'), 
                                                set_value('nome_cliente'));                
                        //echo form_error('nome_cliente','<p class="field-error">','</p>');         
                ?>
            </div>
            <div class="col-md-2">
                <h4>Data Nasc.</h4>
                <?php
                    echo form_input(array(  'id'    => 'data_nascimento',
                                            'name'  => 'data_nascimento',
                                            'class' => 'form-control',
                                            'maxlength' => 10,
                                            'onKeyPress' => 'MascaraData(data_nascimento)'), 
                                            set_value('data_nascimento'));                          
                ?>
            </div>
            <div class="col-md-2">
                <h4>Celular/Telefone</h4>                
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                Novo/Editar
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">                    
                <h4>CPF</h4>
                <?php 
                    echo form_input(array(  'id'    => 'cpf',
                                            'name'  => 'cpf',
                                            'class' => 'form-control',
                                            'maxlength' => 14,
                                            'onKeyPress' => 'MascaraCPF(cpf)'), 
                                            set_value('cpf'));                        
                ?>
            </div>
            <div class="col-md-2">                    
                <h4>CNPJ</h4>
                <?php 
                    echo form_input(array(  'id'    => 'cnpj',
                                            'name'  => 'cnpj',
                                            'class' => 'form-control',
                                            'maxlength' => 18,
                                            'onKeyPress' => 'MascaraCNPJ(this)'), 
                                            set_value('cnpj'));                        
                ?>
            </div>
            <div class="col-md-2">                    
                <h4>RG</h4>
                <?php
                    echo form_input(array(  'id'    => 'rg',
                                            'name'  => 'rg',
                                            'class' => 'form-control',
                                            'maxlength' => 12,
                                            'onKeyPress' => 'MascaraRG(rg)'), 
                                            set_value('rg'));  
                ?>                  
            </div>
            <div class="col-md-2">                    
                <h4>Nascido</h4>
                <?php
                    //info do select,itens,selected value, resto
                    //form_dropdown(array(),$options,$codigo,set_value());
                    echo form_dropdown(array(   'class'=>'form-control',
                                                'name'=>'cod_nacionalidade'),
                                                $nacionalidade,
                                                set_value('cod_nacionalidade'));
                ?>
            </div>
            <div class="col-md-4">
                <h4>E-mail</h4>
                <?php
                    echo form_input(array(  'id'    => 'email_cliente',
                                            'name'  => 'email_cliente',
                                            'maxlength' => 100,
                                            'class' => 'form-control'), 
                                            set_value('email_cliente'));  
                    
                ?>  
            </div>            
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4>Estado Civil</h4>
                <?php
                    echo form_dropdown(array( 'class'=>'form-control',
                                                'name'=>'cod_estado_civil'),
                                                $estado_civil,
                                                set_value('cod_estado_civil'));
                ?>
            </div>
            <div class="col-md-4">
                <h4>Profissão</h4>
                <?php
                    echo form_dropdown(array( 'class'=>'form-control',
                                                'name'=>'cod_profissao'),
                                                $profissoes,
                                                set_value('cod_profissao'));
                ?>
            </div>
            <div class="col-md-4">
                <h4>Orgão de profissão</h4>
                <?php
                    echo form_dropdown(array(   'class'=>'form-control',
                                                'name'=>'cod_orgao_classe'),
                                                $orgao_classe,
                                                set_value('cod_orgao_classe'));
                ?>               
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <h4>CEP</h4>
                <?php
                    echo form_input(array(  'id'    => 'cep',
                                            'name'  => 'cep',
                                            'class' => 'form-control',
                                            'maxlength' => 10,
                                            'onKeyPress' => 'MascaraCep(cep)',
                                            'onBlur'=>'pesquisacep(this.value);'), 
                                            set_value('cep')); 
                ?>
            </div>
            <div class="col-md-4">
                <h4>Número</h4>
                <?php 
                    echo form_input(array(  'id'    => 'numero',
                                            'name'  => 'numero',
                                            'class' => 'form-control',
                                            'maxlength' => 20), 
                                            set_value('numero'));
                ?>
            </div>
            <div class="col-md-6">
                <h4>Complemento</h4>
                <?php 
                    echo form_input(array(  'id'    => 'complemento',
                                            'name'  => 'complemento',
                                            'class' => 'form-control',
                                            'maxlength' => 50,
                                            'onBlur'=>'cepPreenchido();'), 
                                            set_value('complemento'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Endereço</h4>
                <?php 
                    echo form_input(array(  'id'    => 'endereco',
                                            'name'  => 'endereco',
                                            'class' => 'form-control',
                                            'maxlength' => 100), 
                                            set_value('endereco'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Bairro</h4>
                <?php 
                    echo form_input(array(  'id'    => 'bairro',
                                            'name'  => 'bairro',
                                            'class' => 'form-control',
                                            'maxlength' => 100), 
                                            set_value('bairro'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <h4>Cidade</h4>
                <?php 
                    echo form_input(array(  'id'    => 'cidade',
                                            'name'  => 'cidade',
                                            'class' => 'form-control',
                                            'maxlength' => 100), 
                                            set_value('cidade'));
                ?>
            </div>
            <div class="col-md-2">
                <h4>Estado (UF)</h4>
                <?php
                    $opcoes = array(
                        ''   => '',
                        'AC' => 'Acre',
                        'AL' => 'Alagoas',
                        'AP' => 'Amapá',
                        'AM' => 'Amazonas',
                        'BA' => 'Bahia',
                        'CE' => 'Ceará',
                        'DF' => 'Distrito Federal',
                        'ES' => 'Espírito Santo',
                        'GO' => 'Goiás',
                        'MA' => 'Maranhão',
                        'MT' => 'Mato Grosso',
                        'MS' => 'Mato Grosso do Sul',
                        'MG' => 'Minas Gerais',
                        'PA' => 'Pará',
                        'PB' => 'Paraíba',
                        'PR' => 'Paraná',
                        'PE' => 'Pernambuco',
                        'PI' => 'Piauí',
                        'RJ' => 'Rio de Janeiro',
                        'RN' => 'Rio Grande do Norte',
                        'RS' => 'Rio Grande do Sul',
                        'RO' => 'Rondônia',
                        'RR' => 'Roraima',
                        'SC' => 'Santa Catarina',
                        'SP' => 'São Paulo',
                        'SE' => 'Sergipe',
                        'TO' => 'Tocantins',
                        'EX' => 'Estrangeiro'
                    );

                    echo form_dropdown(array(   'name'=>'uf',
                                                'id'  => 'uf',
                                                'class' => 'form-control'),
                                                $opcoes, 
                                                set_value('uf'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Nome do pai</h4>
                <?php 
                    echo form_input(array(  'id'    => 'nome_pai',
                                            'name'  => 'nome_pai',
                                            'class' => 'form-control',
                                            'maxlength' => 70), 
                                            set_value('nome_pai'));
                ?>
            </div>
            <div class="col-md-6">
                <h4>Nome da mãe</h4>
                <?php 
                    echo form_input(array(  'id'    => 'nome_mae',
                                            'name'  => 'nome_mae',
                                            'class' => 'form-control',
                                            'maxlength' => 70), 
                                            set_value('nome_mae'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Nome do banco</h4>
                <?php
                    echo form_dropdown(array( 'class'=>'form-control',
                                              'name'=>'cod_banco'),
                                              $banco,
                                              set_value('cod_banco'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Agência</h4>
                <?php
                    echo form_input(array(  'class' => 'form-control',
                                            'name'  => 'num_agencia',                                            
                                            'maxlength' => 20), 
                                            set_value('num_agencia'));
                ?>
            </div>
            <div class="col-md-6">
                <h4>Conta</h4>
                <?php
                    echo form_input(array(  'id'    => 'num_conta',
                                            'name'  => 'num_conta',
                                            'class' => 'form-control',
                                            'maxlength' => 20), 
                                            set_value('num_conta'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Tipo Conta (Poupança | Corrente)</h4>
                <?php
                    echo form_dropdown(array( 'class'=>'form-control',
                                              'name'=>'cod_tipo_conta'),
                                              $tipo_conta_banco,
                                              set_value('cod_tipo_conta'));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Descrição do cliente<h4>
                <?php
                    echo form_textarea(array(   'name'=>'descricao_cliente',
                                                'id' => 'summernote'),
                                                set_value('descricao_cliente','',false));
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php 
                echo form_submit('enviar','Cadastrar', array('class' => 'btn btn-success form-control',
                                                             'id'    => 'enviar'));
            ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            
        </div>
    </div>
    <?php echo form_close(); ?>
   
</div>
<?php $this->load->view('rodape'); ?>
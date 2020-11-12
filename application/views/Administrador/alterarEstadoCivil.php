<?php $this->load->view('Administrador/cabecalho'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
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

    });
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Alterar estado civil</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Estado civil</li>
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
                <?php            
                    echo form_open('Admin/AlterarEstadoCivil/'.$registros->cod_estado_civil,'',array('cod_estado_civil'=>$registros->cod_estado_civil)); 
                    if (isset($validacaoForm)){
                        if ($validacaoForm != ""){      
                            $validacaoForm = str_replace("\n","<br>",$validacaoForm);           
                        
                            echo "<script>exibirCamposObrigatorios(\"".$validacaoForm."\");</script>";
                        }
                    }
                ?>
                <div class="card-body">
                  <div class="form-group">
                    <label>Nome do estado civil</label>
                    <?php 
                        echo form_input(array(  'name'  => 'nome_estado_civil',
                                                'maxlength' => 50,
                                                'autofocus' => 'autofocus',
                                                'class' => 'form-control',
                                                'placeholder'=>'Exemplo: Solteiro(a), Casado(a)'), 
                                                set_value('nome_estado_civil',$registros->nome_estado_civil));
                    ?>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <?php 
                        echo form_submit('enviar','Confirmar', array('class' => 'btn btn-success form-control',
                                                                    'id'    => 'enviar'));
                    ?>
                </div>
              <?php echo form_close(); ?>
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

<?php $this->load->view('Administrador/rodape'); ?>
<?php $this->load->view('Administrador/cabecalho'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url("assets/Administrador/plugins/datatables-bs4/css/dataTables.bootstrap4.css"); ?>">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Cadastro de bancos</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Banco</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

      <!-- Novo Registro Modal -->
<div class="modal fade" id="createModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Fechar</span>
				</button>
				<h4 class="modal-title">
					Novo registro
				</h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<form role="form" id="cadastroForm">
					<div class="form-group">
						<label for="name">Código do banco</label>
						<input type="text" class="form-control" id="codigo_banco" name="codigo_banco" placeholder="Código do banco"/>
					</div>
					<div class="form-group">
						<label for="name">Nome do banco</label>
						<input type="text" class="form-control" id="nome_banco" name="nome_banco" placeholder="Nome do banco"/>
					</div>
				</form>
				<div id="message1">
				</div>
			</div>
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					Fechar
				</button>
				<button type="button" id="create_form" class="btn btn-success">
					Confirmar
				</button>
			</div>
		</div>
	</div>
</div>	


<!-- Edit Modal -->
<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">
					Alterar Banco
				</h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<form role="form" id="editForm">
					<div class="form-group">
						<label for="name">Código do banco</label>
						<input type="text" class="form-control" id="m_codigo_banco" name="codigo_banco" placeholder="Código do banco"/>
					</div>
					<div class="form-group">
						<label for="name">Nome do banco</label>
						<input type="text" class="form-control" id="m_nome_banco" name="nome_banco" placeholder="Nome do banco"/>
					</div>
					<input type="hidden" id="m_cod_banco" name="cod_banco">
				</form>
				<div id="message1">
				</div>
			</div>
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					Fechar
				</button>
				<button type="button" id="update_form" class="btn btn-success">
					Atualizar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Excluir
				</h4>
			</div>

			<!-- Modal Body -->
			<div class="modal-body">
				<p>Deseja realmente excluir o banco selecionado?</p>
			</div>
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Não
				</button>
				<button type="button" id="del_btn" class="btn btn-danger">
					Sim
				</button>
			</div>
		</div>
	</div>
</div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
            <button class="btn btn-success" data-toggle="modal" data-target="#createModel">
					    Cadastrar
            </button>
            
            </div>            
            <!-- /.card-header -->
            <div class="card-body">
            <div class="col-sm-12" id="message2"></div>
			      <div class="col-sm-12" style="padding-bottom: 5px;">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Código único</th>
                  <th>Código banco</th>
                  <th>Nome banco</th> 
                  <th>Ações</th>                
                </tr>
                </thead>
                <tbody id ="tableBody">
                  <?php 
                    foreach($registros as $linha){
                      echo "<tr id=\"banco_".$linha->cod_banco."\"> ";
                        echo "<td class=\"cod_banco\">".$linha->cod_banco."</td>";
                        echo "<td class=\"codigo_banco\">".$linha->codigo_banco."</td>";
                        echo "<td class=\"nome_banco\">".$linha->nome_banco."</td>";
                        echo "<td>";
                          echo "<button class=\"btn btn-primary edit_cadastro\" data-id=\"".$linha->cod_banco."\" data-toggle='modal' data-target='#editModel'>Editar</button>&nbsp;&nbsp;";
                          echo "<button class=\"btn btn-danger delete_cadastro\" data-id=\"".$linha->cod_banco."\" data-toggle=\"modal\" data-target=\"#deleteModel\">Excluir</button>";
                        echo "</td>";
                      echo "</tr>";
                    }
                  ?>                
                </tbody>
                <tfoot>
                <tr>
                  <th>Código único</th>
                  <th>Código banco</th>
                  <th>Nome banco</th> 
                  <th>Ações</th>    
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      
    </section>
    <!-- /.content -->

<!-- jQuery -->
<script src="<?php echo base_url("assets/Administrador/plugins/jquery/jquery.min.js"); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url("assets/Administrador/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url("assets/Administrador/plugins/datatables/jquery.dataTables.js"); ?>"></script>
<script src="<?php echo base_url("assets/Administrador/plugins/datatables-bs4/js/dataTables.bootstrap4.js"); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?php echo base_url("assets/Administrador/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url("assets/Administrador/dist/js/adminlte.min.js"); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url("assets/Administrador/dist/js/demo.js"); ?>"></script>
<!-- page script -->
<script>
  $(function () {
    //Capturar Dados Usando Método AJAX do jQuery
    var teste = [];
    $.ajax({
        type: "GET", 
        url:'CarregarBancos',
        timeout: 30000,
        datatype: 'JSON',
        contentType: "application/json; charset=utf-8",
        cache: false,
        async : false,
        beforeSend: function() {
            $("h2").html("Carregando..."); //Carregando
        },
        error: function() {
            $("h2").html("O servidor não conseguiu processar o pedido");
        },
        success: function(retorno) {
          // Interpretando retorno JSON...
          var item = retorno;
          teste = item;
          
        } 
    });  
 
    console.log(teste);
    
    
    
    $("#example1").DataTable();
    //$("#example2").DataTable();
    var tabela = $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      //ajax:"<?php echo base_url("assets/Administrador/ajax.txt")?>",
    });



  /*


    var a = $.ajax({
      type:"GET",
      dataType : "json",
      url : 'CarregarBancos'
    }).then(function(res){
				if(res.type == 'success'){
            var b = res.message;
				} else{
					$("#message1").html("<div class='alert alert-danger'>"+res.message+"</div>");
				}
			}, function(){
				alert('Desculpe! Aconteceu algum erro');
			})

    console.log(b.cod_banco);*/
  });
</script>


<script>
	$(function(){
    //novo
		$('#create_form').on('click', function(e){
			e.preventDefault();
			var formData = $("#cadastroForm").serialize();
			$.ajax({
				type: 'post',
				url: 'NovoBanco',
				data: formData
			}).then(function(res){
				if(res.type == 'success'){
					appendRow(res.message);
					$("#message2").html("<div class='alert alert-success' id='success-alert'>Banco "+res.message.nome_banco+" adicionado com sucesso!</div>");
					$("#cadastroForm").get(0).reset();
					$('#createModel').trigger('click');
					hideAlert("#success-alert");
				} else{
					$("#message1").html("<div class='alert alert-danger'>"+res.message+"</div>");
				}
			}, function(){
				alert('Desculpe! Aconteceu algum erro');
			})
		});

    //atualizar
		$('#tableBody').on('click', '.edit_cadastro', function(e){
			e.preventDefault();
			var cod_banco = $(this).data('id');
			var codigo_banco = $('#banco_'+cod_banco).find('.codigo_banco').text();
			var nome_banco = $('#banco_'+cod_banco).find('.nome_banco').text();
			$("#editForm").find('#m_cod_banco').val(cod_banco);
			$("#editForm").find('#m_codigo_banco').val(codigo_banco);
			$("#editForm").find('#m_nome_banco').val(nome_banco);
		});

		//confirma a alteracao
		$('#update_form').on('click', function(e){
			e.preventDefault();
			var formData = $("#editForm").serialize();
			$.ajax({
				type: 'post',
				url: 'AlterarBanco',
				data: formData
			}).then(function(res){
				if(res.type == 'success'){
					updateRow(res.message);
					$("#message2").html("<div class='alert alert-success' id='success-alert'>Registro atualizado com sucesso!</div>");
					$("#editForm").get(0).reset();
					$('#editModel').trigger('click');
					hideAlert("#success-alert");
				} else{
					$("#message1").html("<div class='alert alert-danger'>"+res.message+"</div>");
				}
			}, function(){
				alert('Desculpe! Aconteceu algum erro');
			})
		});

		$('#tableBody').on('click', '.delete_cadastro', function(e){
			e.preventDefault();
			var cod_banco = $(this).data('id');
			$('#deleteModel #del_btn').data('cod_banco', cod_banco);
		});

		$('#del_btn').click(function(e){
			e.preventDefault();
			var id = $(this).data('cod_banco');
			$('#deleteModel').trigger('click');
			$.ajax({
				type: 'post',
				url: 'ExcluirBanco',
				data: {'cod_banco': id}
			}).then(function(res){
				if(res.type == 'success'){
					$("#message2").html("<div class='alert alert-success' id='success-alert'>Registro excluído com sucesso!</div>");
						$('#banco_'+id).remove();
					hideAlert("#success-alert");
				} else{
					$("#message2").html("<div class='alert alert-danger' id='success-alert'>Não foi possível excluir!</div>");
					hideAlert("#success-alert");
				}
			}, function(){
				alert('Desclupe! Aconteceu algum erro');
			})
		});
		
		function appendRow(message){
			$('#tableBody').append([
				"<tr id='banco_"+message.cod_banco+"'>", 
          "<td class='cod_banco'>"+message.cod_banco+"</td>",
					"<td class='codigo_banco'>"+message.codigo_banco+"</td>",
					"<td class='nome_banco'>"+message.nome_banco+"</td>",
					"<td>",
					"<button class='btn btn-primary edit_cadastro' data-id='"+message.cod_banco+"' data-toggle='modal' data-target='#editModel'>Editar</button>&nbsp;",
					"<button class='btn btn-danger delete_cadastro' data-id='"+message.cod_banco+"' data-toggle='modal' data-target='#deleteModel'>Excluir</button>",
					"</td>",
				"</tr>"].join('')
			);
		}		

		function updateRow(message){
			var row = $('#tableBody').find('#banco_' + message.cod_banco);
			row.find('.codigo_banco').text(message.codigo_banco);
			row.find('.nome_banco').text(message.nome_banco);
		}

		function hideAlert(id){
				$(id).fadeTo(2000, 500).slideUp(500, function(){
					$(id).slideUp(500);
				});
		}

		$('#tableBody').bind('DOMSubtreeModified', function(e) {
		  if ($("#tableBody > tr").length > 0) {
		  	$("#table_status").text('');
		  } else{
		    $("#table_status").text('Sem registros');
		  }
		});


	});

</script>


<?php $this->load->view('Administrador/rodape'); ?>
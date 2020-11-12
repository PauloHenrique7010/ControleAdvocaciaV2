<?php $this->load->view('cabecalho'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script>
function msgDeletar(codigo, nome){
      Swal.fire({
        title: 'Excluir '+nome+'?',
        text: 'Não é possível desfazer o processo!',        
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim'
      }).then((result) => {
        if (result.value) {
            Swal.fire({
            title: 'Excluido!',
            text: 'Registro excluído com sucesso!',        
            icon: 'success',
          }).then((result) => {
            <?php echo "window.location.href = '".base_url("ExcluirProcesso/")."'+codigo; " ?>     
        })
        }
      })
    }
</script>   
  
  <div class="container">
    <br><br>
    <h2>Registro de processos</h2>    
    <a href="<?php echo base_url('NovoProcesso');?>"><button type="button" class="btn btn-success" >Cadastrar</button></a>
    <br><br>
    <?php
      if (!isset($registros) || sizeof($registros) == 0):
        echo "<h4>Nenhum registro encontrado</h4>";
      else: 
    ?>
        <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Num Processo</th>
            <th>Editar</th>
            <th>Excluir</th>
          </tr>
        </thead>
        <tbody>      
          <?php
            foreach($registros as $linha):
              echo "<tr>";
              echo "<td>".$linha->cod_processo."</td>";
              echo "<td>".$linha->assunto_principal."</td>";
              echo "<td><a href=\" ".base_url("AlterarProcesso/".$linha->cod_processo)." \"><button type=\"button\" class=\"btn btn-warning\">Editar</button></a></td>";
              echo "<td><a href=\"#\"><button type=\"button\" onClick=\"msgDeletar(".$linha->cod_processo.",'".$linha->assunto_principal."')\" class=\"btn btn-danger\">Excluir</button></a></td>";
              echo "</tr>";
            endforeach;
          ?>  
        </tbody>
      </table>

      <?php endif; ?>
  </div>
<?php $this->load->view('rodape'); ?>
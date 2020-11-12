<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $tituloGuia; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php 
            $pCodAdmin = array(
                'type' => 'password',
                'name'  => 'codAdmin',
                'id'    => 'codAdmin', //o id é usado pelo form validation
                'class' => 'form-control'
            );          
            if ($msg = get_msg()){
                echo $msg;
            }
            
            echo form_open('AdminCtr');

            echo "<div class=\"row\">";
                echo "<div class=\"col-12\">";
                    echo form_label('Insira o código do adminitrador', 'codAdmin');
                    echo form_input($pCodAdmin, set_value('codAdmin'));
                echo "</div>";
            echo "</div>";
            echo "<div class=\"row\">";
                echo "<div class=\"col\">";
                    echo form_submit('enviar','Cadastrar', array('class' => 'btn btn-success'));
                echo "</div>";
            echo "</div>";
            
            echo form_close();
            
        ?>
    </div>
</body>
</html>
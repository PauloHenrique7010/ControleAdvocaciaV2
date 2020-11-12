<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div class="container">
    <table class="table table-hover">
    <tbody>
        <?php 
            foreach($registros as $linha){
                $codigo = $linha->$nomeObj1;
                $nome   = $linha->$nomeObj2;
                echo "
                    <tr>
                    <td></td>
                        <td>
                            <input class=\"form-check-input\" type=\"radio\" name=\"rdbFrame\" id=\"$codigo\" value=\"$codigo\" >
                        </td>
                        <td>
                            <label class=\"form-check-label\" name=\"lbl\" for=\"$codigo\">
                                $nome
                            </label>
                        </td>
                    </tr>
                ";
            }
        ?>             
    </tbody>
    </table>
        
    
</div>
            
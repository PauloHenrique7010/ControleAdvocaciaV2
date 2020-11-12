<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    if (!function_exists('set_msg')){
        function set_msg($msg=NULL  ){
            $ci = & get_instance();
            $ci->session->set_userdata('aviso', $msg);
        }
    }

    if (!function_exists('get_msg')){
        function get_msg($destroy=TRUE){
            $ci = & get_instance();
            $retorno = $ci->session->userdata('aviso');
            if ($destroy){
                $ci->session->unset_userdata('aviso');
            }
            return $retorno;
        }
    }

    if (!function_exists('verifica_login_admin')){
        function verifica_login_admin($redirect='AdminCtr'){
            $ci = & get_instance();
            if ($ci->session->userdata('logado') != True){
                set_msg('Usuário não está logado');
            redirect($redirect,'refresh');
            }
        }
    }

    // Formata data aaaa-mm-dd para dd/mm/aaaa
    if (!function_exists('converter_data_para_brasil')){
        function converter_data_para_brasil($datasql="") {
            if (!empty($datasql)){
            $p_dt = explode('-',$datasql);
            $data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
            return print $data_br;
            }
        }
        
    }

    // Formata data dd/mm/aaaa para aaaa-mm-dd
    if (!function_exists('converter_data_para_internacional')){
        function converter_data_para_internacional($databr="") {
            if (!empty($databr)){
            $p_dt = explode('/',$databr);
            $data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
            return $data_sql;
            }
        }
    }


    if (!function_exists('selectGenerico')){
        function selectGenerico($sql){
            $ci=& get_instance();
            $ci->load->database(); 

            $sql = $sql; 
            $query = $ci->db->query($sql);
            return $query->result();
        }
    }

    if (!function_exists('buscarTodosRegistrosTabela')){
        function buscarTodosRegistrosTabela($nomeTabela){
            $ci=& get_instance();
            $ci->load->database(); 

            return $ci->db->get($nomeTabela)->result();           
        }
    }

    if (!function_exists('converterTagHTMLParaBanco')){
        function converterTagHTMLParaBanco($string=null){
            return htmlentities($string);
        }
    }

    if (!function_exists('converterBancoParaTagHTML')){
        function converterBancoParaTagHTML($string=null){
            return html_entity_decode($string);
        }
    }

    if (!function_exists('CPFValido')){
        function CPFValido($str=""){
            
            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $str );
            
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                return false;
            }

            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }

            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    if (!function_exists('msgSucesso')){
        function msgSucesso($titulo="",$corpo=""){
            echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@9\"></script>";
            echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>";           
            
            
            echo "
            <script>            
                $(document).ready(function() {
                    

                    msgSucesso('$titulo','$corpo');
                    
                    
                    function msgSucesso(titulo, corpo){
                        Swal.fire({
                            title: titulo,
                            text: corpo,        
                            icon: 'success',
                            }).then((result) => {
                                alert('');
                            
                        })
                    }
                });
            </script> 
            ";
            return true;
        }
    }

    if (!function_exists('exibirMsg')){
        function exibirMsg($string=""){
            echo "<script>alert(".$string.");</script>";
        }
    }
?>
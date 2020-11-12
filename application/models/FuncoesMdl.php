<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class FuncoesMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectGenerico($sql){
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1){
            return $query->row();
        }
        else{
            return null;
        }

    }

    public function buscarTodosRegistrosTabela($nomeTabela = ""){
        if ($nomeTabela != ""){
            return $this->db->get($nomeTabela)->result();
        }        
    }
}
?>

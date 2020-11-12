<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectCliente($nomeCliente){
        $this->db->where('nome_cliente',$nomeCliente);
        $query = $this->db->get('cliente',1);
        if ($query->num_rows() == 1){
            $row = $query->row();
            return $row->cod_cliente;
        }
        else{
            return null;
        }

    }
}
?>

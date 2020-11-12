<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoCivilMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectEstadoCivil($codEstadoCivil = 0){
        if ($codEstadoCivil > 0){
            $this->db->where('cod_estado_civil',$codEstadoCivil);
        }
        return $this->db->get('estado_civil')->result();
    }

    public function cadastrarEstadoCivil($array){
        $this->db->insert('estado_civil',$array);
        return $this->db->insert_id();
    }

    public function alterarEstadoCivil($dados){
        $this->db->set($dados);
        $this->db->where('cod_estado_civil',$dados['cod_estado_civil']);        
        if($this->db->update('estado_civil')){
            return true;
        }
        return false;
    }

    public function excluirEstadoCivil($codEstadoCivil){
        $this->db->where('cod_estado_civil', $codEstadoCivil);
        return $this->db->delete('estado_civil');
    }
}
?>

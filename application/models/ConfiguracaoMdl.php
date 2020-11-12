<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ConfiguracaoMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectConfiguracaoToken(){
        $query = $this->db->get('token_escavador');
        if ($query->num_rows() > 0){
            $row = $query->row();
            return $row;
        }
        else{
            return null;
        }
    }

    public function confirmarConfiguracaoTokenEscavadorAPI($array){
        $query = $this->db->get('token_escavador');
        if ($query->num_rows() > 0){
            $this->db->set($array);
            if ($this->db->update('token_escavador')){
                return true;
            }
        }   
        else{
            if ($this->db->insert('token_escavador',$array)){
                return true;
            }
        }   
        return false;
    }
}
?>

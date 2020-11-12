<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ClienteMdl extends CI_Model {
    
    function __construct(){
        parent ::__construct();
    }

    public function selectCliente($cod_cliente){
        $this->db->where('cod_cliente',$cod_cliente);
        return $this->db->get('cliente')->result();
    }

    public function excluirCliente($cod_cliente){
        $this->db->where('cod_cliente', $cod_cliente);
        return $this->db->delete('cliente');
    }

    public function excluirCelulares($codCliente){
        if ($this->db->query("delete from cliente_telefone where cod_cliente = ".$codCliente))
            return true;
        return false;       

    }

    public function cadastrarCliente($array){
        $this->db->insert('cliente',$array);
        return $this->db->insert_id();
    }

    public function editarCliente($cod_cliente, $dadosCliente){
        $this->db->set($dadosCliente);
        $this->db->where('cod_cliente',$cod_cliente);        
        if($this->db->update('cliente')){
            return true;
        }
        return false;
    }

    public function cadastrarCelularCliente($codCliente, $celulares){
        try{
            
            //verifico se tem algum telefone ja cadastrado para este cliente
            $existeRegistro =  selectGenerico("select count(cod_cliente_telefone) as qtde from cliente_telefone c where c.cod_cliente = ".$codCliente);
            $qtde = (int)$existeRegistro[0]->qtde;
        
            //se possuir, excluo todos os telefones com desse cliente
            //tabela relacao esta com ON CASCADE
            if ($qtde > 0){ //tem telefone cadastrado
               $this->excluirCelulares($codCliente);
            }
    
            
            if ($celulares){
                foreach ($celulares as $campo => $valor) {           
                    $this->db->query("INSERT INTO cliente_telefone (cod_cliente, telefone) values ($codCliente, \"".$valor."\")");                    
                }
            }
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }


/*
    public function updateCliente($codCliente, $nomeCliente){
        $this->db->where('cod_cliente',$codCliente);
        $query = $this->db->get('cliente');
        if ($query->num_rows() >= 1){
            $this->db->set('nome_cliente',$nomeCliente);
            $this->db->where('cod_cliente',$codCliente);
            $this->db->update('cliente');
            return $this->db->affected_rows(); 

            $row = $query->row();
            return $row->cod_cliente;
        }
        else{//se nao existir um cliente, cadastra um novo
            $dados = array(
                'nome_cliente' => $nomeCliente,
                'tel_cliente' => '(99) 99999-9999'
            );
            $this->db->insert('cliente',$dados);
            return $this->db->insert_id();


            return null;
        }  

    }*/
}
?>

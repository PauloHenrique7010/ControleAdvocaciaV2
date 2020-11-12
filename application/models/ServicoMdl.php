<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ServicoMdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function cadastrarServico($servico, $prestacoesCartao, $partesServico){        
        $this->db->trans_begin();
        $this->db->insert('servico', $servico);
        $codServico =  $this->db->insert_id();

        //salvar as prestacoes
        foreach ($prestacoesCartao as $linha) {
            $this->db->set('cod_servico', $codServico);
            $this->db->set('numero_parcela', $linha->numParcela);
            $this->db->set('data_vencimento', $linha->dataVencimento);
            $this->db->set('valor_parcela', $linha->valor);
            $this->db->set('cod_forma_pagamento', 1);

            $this->db->insert('servico_pagamento');
            //echo "codigo: ".$this->db->insert_id();
        }
        //salvar as prestacoes

        //salvar as partes
        foreach ($partesServico as $linha) {
            $this->db->set('cod_servico', $codServico);
            $this->db->set('cod_parte', $linha->codigo);
            $this->db->set('nome_parte', $linha->nome);
            $this->db->insert('servico_parte');

            //echo "codigo: ".$this->db->insert_id();
        }

        if ($this->db->trans_complete())
            return true;
        else
            $this->db->trans_rollback();        
    }

    public function pesquisarServico($sql)
    {
        $this->db->select('sc.cod_servico, sc.valor_parcela, s.valor_servico');
        $this->db->from('servico_pagamento sc');
        $this->db->join('servico s', 's.cod_servico = sc.cod_servico', 'LEFT');
        return $this->db->get()->result();
        //echo var_dump($teste->result());       
    }
}

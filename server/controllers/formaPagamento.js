const modelFormaPagamento = require('../models/formaPagamento');

async function index(req, res) {

    const { codFormaPagamento } = req.query;

    var filtro = new Object();
    filtro.codFormaPagamento = codFormaPagamento;    

    const registros = await modelFormaPagamento.pesquisarFormaPagamento(filtro);
    res.json({ registros });
}

async function excluirFormaPagamento(req, res) {
    try {
        const { codigo } = req.body;

        if (codigo > 0) {
            let resposta = await modelFormaPagamento.excluirFormaPagamento(codigo);
            if (resposta)
                res.status(200).json({
                    "title": "Sucesso!",
                    "message": "Excluido!",
                    "tipo":"success"
                });
            else
                res.status(202).json({
                    "title": "Aviso!",
                    "message": "Não foi possível excluir!",
                    "tipo":"warning"                    
                });
        }
        else
            res.status(202).json({
                "title": "Aviso!",
                "message": "Registro informado não foi encontrado no banco.",
                "tipo":"warning"
            });

    } catch (error) {
        res.status(209).json({
            "title": "Erro!",
            "message": "<span>Não foi possível concluir a operação devido ao seguinte erro:</span> <br><br>" + error,
            "tipo":"error"
        });
    }
}

async function cadastrarFormaPagamento(req, res){
    try {        
        const {            
            nomeFormaPagamento
        } = req.body;

        
        let resposta = await modelFormaPagamento.cadastrarFormaPagamento(nomeFormaPagamento);
        console.log('resposta');
        if (resposta){
            
            res.status(200).json({
                "title": "Sucesso!",
                "message": "Cadastrado!",
                "tipo":"success"
            });
        }
        else{
            res.status(202).json({
                "title": "Ops!",
                "message": "Ocorreu algum erro!",
                "tipo":"warning"
            });
        }       

    } catch (error) {
        res.status(209).json({
            "title": "Erro!",
            "message": "<span>Não foi possível concluir a operação devido ao seguinte erro:</span> <br><br>" + error,
            "tipo":"error"
        });
    }
}

async function alterarFormaPagamento(req, res){
    try {        
        const {
            codFormaPagamento,            
            nomeFormaPagamento
        } = req.body;

        
        let resposta = await modelFormaPagamento.alterarFormaPagamento(codFormaPagamento, nomeFormaPagamento);
        
        if (resposta){
            
            res.status(200).json({
                "title": "Sucesso!",
                "message": "Atualizado!",
                "tipo":"success"
            });
        }
        else{
            res.status(202).json({
                "title": "Ops!",
                "message": "Ocorreu algum erro!",
                "tipo":"warning"
            });
        }       

    } catch (error) {
        res.status(209).json({
            "title": "Erro!",
            "message": "<span>Não foi possível concluir a operação devido ao seguinte erro:</span> <br><br>" + error,
            "tipo":"error"
        });
    }
}

module.exports = {
    index,
    excluirFormaPagamento,
    cadastrarFormaPagamento,
    alterarFormaPagamento
}
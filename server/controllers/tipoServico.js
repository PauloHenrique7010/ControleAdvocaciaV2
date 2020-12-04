const modelTipoServico = require('../models/tipoServico');

async function pesquisarTipoServico(req, res) {

    const { codTipoServico } = req.query;

    var filtro = new Object();
    filtro.codTipoServico = codTipoServico;    

    const registros = await modelTipoServico.pesquisarTipoServico(filtro);
    res.json({ registros });
}

async function excluirTipoServico(req, res) {
    try {
        const { codigo } = req.body;

        if (codigo > 0) {
            let resposta = await modelTipoServico.excluirTipoServico(codigo);
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

async function cadastrarTipoServico(req, res){
    try {        
        const {            
            nomeTipoServico
        } = req.body;

        
        let resposta = await modelTipoServico.cadastrarTipoServico(nomeTipoServico);
        console.log('resposta');
        if (resposta > 0){
            
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

async function alterarTipoServico(req, res){
    try {        
        const {
            codTipoServico,            
            nomeTipoServico
        } = req.body;

        
        let resposta = await modelTipoServico.alterarTipoServico(codTipoServico, nomeTipoServico);
        
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
    pesquisarTipoServico,
    excluirTipoServico,
    cadastrarTipoServico,
    alterarTipoServico
}
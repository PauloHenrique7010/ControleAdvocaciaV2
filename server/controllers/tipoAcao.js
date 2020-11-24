const modelTipoAcao = require('../models/tipoAcao');

async function index(req, res) {

    const { codTipoAcao } = req.query;

    var filtro = new Object();
    filtro.codTipoAcao = codTipoAcao;    

    const registros = await modelTipoAcao.pesquisarTipoAcao(filtro);
    res.json({ registros });
}

async function excluirTipoAcao(req, res) {
    try {
        const { codigo } = req.body;

        if (codigo > 0) {
            let resposta = await modelTipoAcao.excluirTipoAcao(codigo);
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

async function cadastrarTipoAcao(req, res){
    try {        
        const {            
            nomeTipoAcao
        } = req.body;

        
        let resposta = await modelTipoAcao.cadastrarTipoAcao(nomeTipoAcao);
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

async function alterarTipoAcao(req, res){
    try {        
        const {
            codTipoAcao,            
            nomeTipoAcao
        } = req.body;

        
        let resposta = await modelTipoAcao.alterarTipoAcao(codTipoAcao, nomeTipoAcao);
        
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
    excluirTipoAcao,
    cadastrarTipoAcao,
    alterarTipoAcao
}
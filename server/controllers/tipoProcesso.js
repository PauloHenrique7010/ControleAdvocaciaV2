const modelTipoProcesso = require('../models/tipoProcesso');

async function index(req, res) {

    const { codTipoProcesso } = req.query;

    var filtro = new Object();
    filtro.codTipoProcesso = codTipoProcesso;    

    const registros = await modelTipoProcesso.pesquisarTipoProcesso(filtro);
    res.json({ registros });
}

async function excluirTipoProcesso(req, res) {
    try {
        const { codigo } = req.body;

        if (codigo > 0) {
            let resposta = await modelTipoProcesso.excluirTipoProcesso(codigo);
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

async function cadastrarTipoProcesso(req, res){
    try {        
        const {            
            nomeTipoProcesso
        } = req.body;

        
        let resposta = await modelTipoProcesso.cadastrarTipoProcesso(nomeTipoProcesso);
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

async function alterarTipoProcesso(req, res){
    try {        
        const {
            codTipoProcesso,            
            nomeTipoProcesso
        } = req.body;

        
        let resposta = await modelTipoProcesso.alterarTipoProcesso(codTipoProcesso, nomeTipoProcesso);
        
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
    excluirTipoProcesso,
    cadastrarTipoProcesso,
    alterarTipoProcesso
}
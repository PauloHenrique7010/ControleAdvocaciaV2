const funcoes = require('../servicos/funcoes');
//const moment = require('moment'); // require

async function strToDate(req, res) {

    const {
        data,
        formato
    } = req.query;

    try {

        let novaData = funcoes.strToDate(data, formato); 
        if (novaData.isValid())        
            res.status(200).json({
                "title":"Sucesso!",
                "message":"Conversão efetuada!",
                "retorno":novaData
            });
        else 
            res.status(202).json({
                "title":"Aviso!",
                "message":"A data ("+data+") não é válida para o padrão informado! ("+formato+"), contate o admin."
            });        

    } catch (error) {
        res.status(500).json({
            "title": "Erro!",
            "message": "<span>Ocorreu o seguinte erro: </span> <br><br>" + error
        });
    }
}

function formatDateTime(req, res){
    const {
        data,
        formato
    } = req.body;

    try {        
        let dataFormatada = funcoes.formatDateTime(data, formato);
        
        if (dataFormatada != "Invalid date"){
            res.status(200).json({
                "title":"Sucesso!",
                "message":"Conversão efetuada!",
                "retorno":dataFormatada
            });
            
        }
        else 
            res.status(202).json({
                "title":"Aviso!",
                "message":"A data ("+data+") não é válida para a formatação informada! ("+formato+"), contate o admin."
            });        

    } catch (error) {
        res.status(500).json({
            "title": "Erro!",
            "message": "<span>Ocorreu o seguinte erro: </span> <br><br>" + error
        });
    }
}


module.exports = {
    strToDate,
    formatDateTime
}
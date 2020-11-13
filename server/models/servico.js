const selectPromise = require('../servicos/select');
/*const insertPromise = require('../servicos/insert');
const servicoComunicado = require('../servicos/comunicado');
const dataService = require('../servicos/data');

async function criar(responsavel_comunicado, email_comunicado, hash_comunicado, cod_dpo) {
    const data_atual = dataService()

    await insertPromise('INSERT INTO comunicado (data_comunicado, responsavel_comunicado, email_comunicado, data_comunicado_criado, data_comunicado_atualizado, hash_comunicado, cod_dpo) VALUES ("'+data_atual+'","'+responsavel_comunicado+'","'+email_comunicado+'","'+data_atual+'","'+data_atual+'","'+hash_comunicado+'", "'+ cod_dpo +'")');
    
    const [result] = await selectPromise('SELECT cod_comunicado from comunicado order by 1 desc limit 1');

    const comunicado = {
        cod_comunicado: result.cod_comunicado,
        data_comunicado: data_atual,
        responsavel_comunicado: responsavel_comunicado,
        email_comunicado: email_comunicado,
        data_comunicado_criado: data_atual,
        data_comunicado_atualizado: data_atual,
        hash_comunicado: hash_comunicado,
        cod_dpo: cod_dpo
    };

    return comunicado;
}*/
function formatarData(dataInput){
    var data = new Date(dataInput),
        dia  = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
    if (isNaN(diaF))
      return "";
    return diaF+"/"+mesF+"/"+anoF;
}

async function listar(filtros) {
    let dtInicial   = formatarData(filtros.dtInicial);
    let dtFinal     = formatarData(filtros.dtFinal);
       
    
    pesquisa = "";
    
    if (dtInicial != ""){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento >= "+dtInicial;
    }
    if (dtFinal != ""){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento <= "+dtFinal;
    }

    if (pesquisa != ""){
        pesquisa = "WHERE "+pesquisa;
    }

    return await selectPromise('select s.cod_servico, '+
                                      's.valor_servico, '+
                                      'sc.valor_parcela, '+
                                      'sc.numero_parcela, '+
                                      'sc.data_vencimento '+
                               'from servico_pagamento sc '+
                               'left join servico s on s.cod_servico = sc.cod_servico '+pesquisa);
    

    const comunicado = {
        cod_comunicado: result.cod_comunicado,
        data_comunicado: data_atual,
        responsavel_comunicado: responsavel_comunicado,
        email_comunicado: email_comunicado,
        data_comunicado_criado: data_atual,
        data_comunicado_atualizado: data_atual,
        hash_comunicado: hash_comunicado,
        cod_dpo: cod_dpo
    };

    return comunicado;    
}
/*
async function listarTodosComunicado(){
    return (await servicoComunicado.selectTodosComunicado());
}

async function validarComunicado(token, id_comunicado){
    tableHash = await selectPromise('select hash_comunicado from comunicado where cod_comunicado = '+id_comunicado);
    hash = tableHash[0].hash_comunicado;
    if (token == hash)
        return true;
        
    return false;
}
*/
module.exports = {
    listar
};
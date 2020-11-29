const selectPromise = require('../servicos/select');

async function pesquisarServico(filtros) {
    
    let dtInicial = filtros.dtInicial;
    let dtFinal = filtros.dtFinal;
    let OPApenasEmAberto = filtros.OPApenasEmAberto;
    if (OPApenasEmAberto == 'true')
      OPApenasEmAberto = true
    else
      OPApenasEmAberto = false;

    
    if (dtInicial != undefined){
        dtInicial = formatarData(dtInicial);
        dtFinal = formatarData(dtFinal);
    }
    
    pesquisa = "";
    
    if (dtInicial != undefined){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento >= '"+dtInicial+"'";
    }
    if (dtFinal != undefined){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento <= '"+dtFinal+"'";
    }
    
    if (OPApenasEmAberto == true){
        if (pesquisa != "")
            pesquisa += " and ";        
        pesquisa += "sc.data_pago is null";
    }

    if (pesquisa != ""){
        pesquisa = "WHERE "+pesquisa;
    }   


    return await selectPromise('select * from servico '+pesquisa);
}

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
    return anoF+"-"+mesF+"-"+diaF;
}

async function pesquisarPagamento(filtros) {
    
    let dtInicial = filtros.dtInicial;
    let dtFinal = filtros.dtFinal;
    let OPApenasEmAberto = filtros.OPApenasEmAberto;
    if (OPApenasEmAberto == 'true')
      OPApenasEmAberto = true
    else
      OPApenasEmAberto = false;

    
    if (dtInicial != undefined){
        dtInicial = formatarData(dtInicial);
        dtFinal = formatarData(dtFinal);
    }
    
    pesquisa = "";
    
    if (dtInicial != undefined){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento >= '"+dtInicial+"'";
    }
    if (dtFinal != undefined){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento <= '"+dtFinal+"'";
    }
    
    if (OPApenasEmAberto == true){
        if (pesquisa != "")
            pesquisa += " and ";        
        pesquisa += "sc.data_pago is null";
    }

    if (pesquisa != ""){
        pesquisa = "WHERE "+pesquisa;
    }   


    return await selectPromise('select s.cod_servico, '+
                                      's.valor_servico, '+
                                      'sc.valor_parcela, '+
                                      'sc.numero_parcela, '+
                                      'sc.data_vencimento, '+
                                      'sc.cod_servico_pagamento, '+
                                      'sc.data_pago '+
                               'from servico_pagamento sc '+
                               'left join servico s on s.cod_servico = sc.cod_servico '+pesquisa+' '+
                               'order by sc.data_vencimento ');   
}

async function pegarPartesServico(codServico){

    return await selectPromise('SELECT s.cod_servico_parte, '+
                                      's.cod_parte, '+
                                      's.nome_parte, '+
                                      's.cod_servico '+
                               'FROM servico_parte s '+
                               'WHERE cod_servico = '+codServico);     
}


async function darBaixaPagamento(codigo){
    return await selectPromise('update servico_pagamento set data_pago = Date(Now()) where cod_servico_pagamento='+codigo);
    
}

module.exports = {
    pesquisarServico,
    pesquisarPagamento,
    pegarPartesServico,
    darBaixaPagamento
};

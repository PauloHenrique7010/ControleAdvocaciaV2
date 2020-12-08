const selectPromise = require('../servicos/select');
const deletePromisse = require('../servicos/delete');
const insertPromise = require('../servicos/insert');
const updatePromise = require('../servicos/update');

async function pesquisarFormaPagamento(filtro){
    pesquisa = "";
    if (filtro.codFormaPagamento > 0){
        if (pesquisa != "")
          pesquisa += pesquisa + " and ";
        pesquisa += pesquisa + "cod_forma_pagamento = "+filtro.codFormaPagamento;
    }
        
    if (pesquisa != "")
      pesquisa = 'WHERE '+pesquisa;


    return await selectPromise('SELECT t.cod_forma_pagamento, t.nome_forma_pagamento '+
                               'FROM forma_pagamento t '+pesquisa);
}

async function excluirFormaPagamento(codigo){
    return await deletePromisse('DELETE from forma_pagamento where cod_forma_pagamento ='+codigo);
}

async function cadastrarFormaPagamento(nome){
    return await insertPromise("INSERT INTO forma_pagamento (nome_forma_pagamento) values ('"+nome+"')");    
}

async function alterarFormaPagamento(codigo, nome){
    return await updatePromise("UPDATE forma_pagamento set nome_forma_pagamento ='"+nome+"' where cod_forma_pagamento="+codigo);
}

module.exports = {
    pesquisarFormaPagamento,
    excluirFormaPagamento,
    cadastrarFormaPagamento,
    alterarFormaPagamento    
};                            
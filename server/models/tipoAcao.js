const selectPromise = require('../servicos/select');
const deletePromisse = require('../servicos/delete');
const insertPromise = require('../servicos/insert');

async function pesquisarTipoAcao(filtro){
    pesquisa = "";
    if (filtro.codTipoAcao > 0){
        if (pesquisa != "")
          pesquisa += pesquisa + " and ";
        pesquisa += pesquisa + "cod_tipo_acao = "+filtro.codTipoAcao;
    }
        
    if (pesquisa != "")
      pesquisa = 'WHERE '+pesquisa;


    return await selectPromise('SELECT t.cod_tipo_acao, t.nome_tipo_acao '+
                               'FROM tipo_acao t '+pesquisa);
}

async function excluirTipoAcao(codigo){
    return await deletePromisse('DELETE from tipo_acao where cod_tipo_acao ='+codigo);
}

async function cadastrarTipoAcao(nome){
    return await insertPromise("INSERT INTO tipo_acao (nome_tipo_acao) values ('"+nome+"')");    
}

async function alterarTipoAcao(codigo, nome){
    return await insertPromise("UPDATE tipo_acao set nome_tipo_acao ='"+nome+"' where cod_tipo_acao="+codigo);
}

module.exports = {
    pesquisarTipoAcao,
    excluirTipoAcao,
    cadastrarTipoAcao,
    alterarTipoAcao    
};                            
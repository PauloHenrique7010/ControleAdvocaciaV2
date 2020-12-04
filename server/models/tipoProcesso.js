const selectPromise = require('../servicos/select');
const deletePromisse = require('../servicos/delete');
const insertPromise = require('../servicos/insert');
const updatePromise = require('../servicos/update');

async function pesquisarTipoProcesso(filtro){
    pesquisa = "";
    if (filtro.codTipoProcesso > 0){
        if (pesquisa != "")
          pesquisa += pesquisa + " and ";
        pesquisa += pesquisa + "cod_tipo_processo = "+filtro.codTipoProcesso;
    }
        
    if (pesquisa != "")
      pesquisa = 'WHERE '+pesquisa;


    return await selectPromise('SELECT t.cod_tipo_processo, t.nome_tipo_processo '+
                               'FROM tipo_processo t '+pesquisa);
}

async function excluirTipoProcesso(codigo){
    return await deletePromisse('DELETE from tipo_processo where cod_tipo_processo ='+codigo);
}

async function cadastrarTipoProcesso(nome){
    return await insertPromise("INSERT INTO tipo_processo (nome_tipo_processo) values ('"+nome+"')");    
}

async function alterarTipoProcesso(codigo, nome){
    return await updatePromise("UPDATE tipo_processo set nome_tipo_processo ='"+nome+"' where cod_tipo_processo="+codigo);    
}

module.exports = {
    pesquisarTipoProcesso,
    excluirTipoProcesso,
    cadastrarTipoProcesso,
    alterarTipoProcesso    
};                            
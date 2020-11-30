const selectPromise = require('../servicos/select');
const deletePromisse = require('../servicos/delete');
const insertPromise = require('../servicos/insert');

async function pesquisarTipoServico(filtro){
    pesquisa = "";
    if (filtro.codTipoServico > 0){
        if (pesquisa != "")
          pesquisa += pesquisa + " and ";
        pesquisa += pesquisa + "cod_tipo_servico = "+filtro.codTipoServico;
    }
        
    if (pesquisa != "")
      pesquisa = 'WHERE '+pesquisa;


    return await selectPromise('SELECT t.cod_tipo_servico, t.nome_tipo_servico '+
                               'FROM tipo_servico t '+pesquisa);
}

async function excluirTipoServico(codigo){
    return await deletePromisse('DELETE from tipo_servico where cod_tipo_servico ='+codigo);
}

async function cadastrarTipoServico(nome){
    return await insertPromise("INSERT INTO tipo_servico (nome_tipo_servico) values ('"+nome+"')");    
}

async function alterarTipoServico(codigo, nome){
    return await insertPromise("UPDATE tipo_servico set nome_tipo_servico ='"+nome+"' where cod_tipo_servico="+codigo);
}

module.exports = {
    pesquisarTipoServico,
    excluirTipoServico,
    cadastrarTipoServico,
    alterarTipoServico    
};                            
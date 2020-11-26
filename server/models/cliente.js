const selectPromise = require('../servicos/select');

async function pesquisarCliente(filtros) {
    //DECLARAÇÃO VARIAVEL
    let SQL = "";
    let pesquisa = "";
    
    //verifica qual tipo se sql vai ser feito (normal, ou reduzido(menos colunas)
    if (filtros.OPReduzido == 'true'){
        SQL = "SELECT c.cod_cliente, c.nome_cliente, c.cnpj, c.cpf, c.rg from cliente c ";
    }
    else{
        SQL = "SELECT * FROM cliente c ";
    }
    
    let codCliente = filtros.codCliente;   
    
    pesquisa = "";
    
    if (codCliente > 0){
        if (pesquisa != ""){
            pesquisa += " and ";
        }
        pesquisa += "c.cod_cliente = "+codCliente;
    }    

    if (pesquisa != ""){
        pesquisa = "WHERE "+pesquisa;
    }   


    return await selectPromise(SQL+pesquisa);
}


module.exports = {
    pesquisarCliente
};
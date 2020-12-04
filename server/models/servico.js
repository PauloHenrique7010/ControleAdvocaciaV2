const selectPromise = require('../servicos/select');
const funcoes = require('../servicos/funcoes');

async function pesquisarServico(filtros) {

    let dtInicial = filtros.dtInicial;
    let dtFinal = filtros.dtFinal;
    let OPApenasEmAberto = filtros.OPApenasEmAberto;
    if (OPApenasEmAberto == 'true')
        OPApenasEmAberto = true
    else
        OPApenasEmAberto = false;


    if (dtInicial != undefined) {
        dtInicial = formatarData(dtInicial);
        dtFinal = formatarData(dtFinal);
    }

    pesquisa = "";

    if (dtInicial != undefined) {
        if (pesquisa != "") {
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento >= '" + dtInicial + "'";
    }
    if (dtFinal != undefined) {
        if (pesquisa != "") {
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento <= '" + dtFinal + "'";
    }

    if (OPApenasEmAberto == true) {
        if (pesquisa != "")
            pesquisa += " and ";
        pesquisa += "sc.data_pago is null";
    }

    if (pesquisa != "") {
        pesquisa = "WHERE " + pesquisa;
    }


    return await selectPromise('select * from servico ' + pesquisa);
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
function formatarData(dataInput) {
    var data = new Date(dataInput),
        dia = data.getDate().toString(),
        diaF = (dia.length == 1) ? '0' + dia : dia,
        mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0' + mes : mes,
        anoF = data.getFullYear();
    if (isNaN(diaF))
        return "";
    return anoF + "-" + mesF + "-" + diaF;
}

async function pesquisarPagamento(filtros) {

    let dtInicial = filtros.dtInicial;
    let dtFinal = filtros.dtFinal;
    let OPApenasEmAberto = filtros.OPApenasEmAberto;
    if (OPApenasEmAberto == 'true')
        OPApenasEmAberto = true
    else
        OPApenasEmAberto = false;


    if (dtInicial != undefined) {
        dtInicial = formatarData(dtInicial);
        dtFinal = formatarData(dtFinal);
    }

    pesquisa = "";

    if (dtInicial != undefined) {
        if (pesquisa != "") {
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento >= '" + dtInicial + "'";
    }
    if (dtFinal != undefined) {
        if (pesquisa != "") {
            pesquisa += " and ";
        }
        pesquisa += "sc.data_vencimento <= '" + dtFinal + "'";
    }

    if (OPApenasEmAberto == true) {
        if (pesquisa != "")
            pesquisa += " and ";
        pesquisa += "sc.data_pago is null";
    }

    if (pesquisa != "") {
        pesquisa = "WHERE " + pesquisa;
    }


    return await selectPromise('select s.cod_servico, ' +
        's.valor_servico, ' +
        'sc.valor_entrada, ' +
        'sc.valor_parcela, ' +
        'sc.numero_parcela, ' +
        'sc.data_vencimento, ' +
        'sc.cod_servico_pagamento, ' +
        'sc.data_pago ' +
        'from servico s ' +
        'left join servico_pagamento sc on s.cod_servico = sc.cod_servico ' + pesquisa + ' ' +
        'order by sc.data_vencimento ');
}

async function pegarPartesServico(codServico) {

    return await selectPromise('SELECT s.cod_servico_parte, ' +
        's.cod_parte, ' +
        's.nome_parte, ' +
        's.cod_servico ' +
        'FROM servico_parte s ' +
        'WHERE cod_servico = ' + codServico);
}


async function darBaixaPagamento(codigo) {
    return await selectPromise('update servico_pagamento set data_pago = Date(Now()) where cod_servico_pagamento=' + codigo);

}

async function cadastrarServico(json) {
    var mysql = require('mysql');
    var confConexao = require('../servicos/conexao');

    var connection = mysql.createConnection(confConexao.conexao);

    const {
        valorServico,
        valorEntrada,
        tipoServico,
        tipoAcao,
        tipoProcesso,
        partesServico,
        prestacoesCartao
    } = json;


    return new Promise((resolve, reject) => {
        let resposta = new Object();
        try {

            connection.connect(function (err) {
                if (err) {
                    resposta.OPSucesso = false;
                    resposta.message = err.stack;

                    resolve(resposta);                    
                    return;
                }
                console.log('connected as id ' + connection.threadId);

                let SQL = "";
                //  Begin transaction 
                connection.beginTransaction(function (err) {
                    if (err) { return (err); }

                    SQL = "INSERT INTO servico (data_criado, cod_tipo_servico, cod_tipo_processo, cod_tipo_acao, valor_servico) " +
                        "values (date(now())," + tipoServico + ", " + tipoProcesso + ", " + tipoAcao + ", " + valorServico + ");";
                    connection.query(SQL, function (err, result) {
                        if (err) {
                            connection.rollback(function () {
                                resposta.OPSucesso = false;
                                resposta.message = err;

                                resolve(resposta);
                            });
                        }
                        let log = result.insertId;




                        if (prestacoesCartao.length == 0){
                            objPagoAVista = new Object();
                            objPagoAVista.numParcela = 1;
                            objPagoAVista.dataVencimento = new Date();
                            objPagoAVista.valor = valorServico;
                            objPagoAVista.formaPagamento = 1;
                            objPagoAVista.OPPago = true;
                            objPagoAVista.valorEntrada = valorServico;



                            prestacoesCartao.push(objPagoAVista);                             
                            
                        }



                        SQL = "";
                        let pago = "";
                        for (let i = 0; i < prestacoesCartao.length; i++) {
                            dataVencimento = funcoes.formatDateTime(prestacoesCartao[i].dataVencimento, 'YYYY-MM-DD');
                            pago = "''";
                            if (prestacoesCartao[i].OPPago) {
                                pago = "date(now())";
                            }

                            if (i == 0)
                                SQL = "INSERT INTO servico_pagamento (cod_servico, numero_parcela, data_vencimento, valor_parcela, cod_forma_pagamento, data_pago, valor_entrada) VALUES ";
                            SQL += "(" + log + "," + prestacoesCartao[i].numParcela + ", '" + dataVencimento + "', " + prestacoesCartao[i].valor + ", " + prestacoesCartao[i].formaPagamento +
                                ", " + pago + ", " + valorEntrada + ")";
                            if (i < prestacoesCartao.length - 1) {
                                SQL += ", ";
                            }
                        }

                        if (SQL != "") {
                            connection.query(SQL, function (err, result) {
                                if (err) {
                                    connection.rollback(function () {
                                        resposta.OPSucesso = false;
                                        resposta.message = err;

                                        resolve(resposta);
                                    });
                                }
                            });

                        }

                        SQL = "";
                        let codParte = "";
                        for (let i = 0; i < partesServico.length; i++) {
                            codParte = "''";
                            if (partesServico[i].codigo > 0) {
                                codParte = partesServico[i].codigo;
                            }
                            if (i == 0)
                                SQL = "INSERT INTO servico_parte (cod_parte, nome_parte, cod_servico) VALUES ";
                            SQL += "(" + codParte + ",'" + partesServico[i].nome + "', " + log + ")";
                            if (i < partesServico.length - 1) {
                                SQL += ", ";
                            }
                        }


                        connection.query(SQL, function (err, result) {
                            if (err) {
                                connection.rollback(function () {
                                    resposta.OPSucesso = false;
                                    resposta.message = err;

                                    resolve(resposta);
                                });
                            }
                            connection.commit(function (err) {
                                if (err) {
                                    connection.rollback(function () {
                                        resposta.OPSucesso = false;
                                        resposta.message = err;

                                        resolve(resposta);
                                    });
                                }
                                resposta.OPSucesso = true;
                                resposta.message = log;

                                console.log('Transaction Complete.');
                                connection.end();
                                resolve(resposta);
                            });
                        });

                    });
                });
            });
        } catch (e) {
            resposta.OPSucesso = false;
            resposta.message = e;

            resolve(resposta);

        }
    });
    //  End transaction 
}

module.exports = {
    cadastrarServico,
    pesquisarServico,
    pesquisarPagamento,
    pegarPartesServico,
    darBaixaPagamento
};

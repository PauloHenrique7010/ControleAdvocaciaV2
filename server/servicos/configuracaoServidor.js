const select = require('./select');
const queryPromisse = require('./query');

async function atualizarTabela() {
    let existeTabelaVersao = await select('SHOW TABLES LIKE "versao"');
    existeTabelaVersao = JSON.stringify(existeTabelaVersao[0]);
    if (existeTabelaVersao == undefined) { //nao existe a tabela, necessario criar
        await criarTabelaConfiguracoes();
    }

    let versaoPrograma = await select("select versao_programa from versao;");
    if (Object.keys(versaoPrograma).length === 0)  //Se nao possuir nenhum registro, coloca como zero para o programa atualizar e atulizar as tabelas
        await queryPromisse('INSERT INTO versao (versao_programa) values (0)');

    //refaz a consulta        
    versaoPrograma = await select("select versao_programa from versao;");
    let versaoBD = versaoPrograma[0].versao_programa;
    if (process.env.versaoServidor > versaoBD) {
        await atualizarTabelas();

        await queryPromisse('update versao set versao_programa = ' + process.env.versaoServidor);
    }   

}

async function criarTabelaConfiguracoes() {
    await queryPromisse("CREATE TABLE if not exists VERSAO (" +
        "cod_versao int primary key auto_increment," +
        "versao_programa decimal(3,1));");
}

async function atualizarTabelas() {
    console.log('Atualizando as tabelas.')
    //PODE COLOCAR OS COMANDOS SQL, ALTER TABLE, CREATE TABLE E TUDO QUE QUISER
    await queryPromisse("ALTER TABLE CLIENTE ADD COLUMN IF NOT EXISTS cnpj varchar(30)");
    //await queryPromisse("CREATE TABLE teste(cod_teste int primary key)");

    await queryPromisse("ALTER TABLE servico_pagamento add column if not exists valor_entrada Decimal(12,2)");
    

    return true;
}


async function pegarIPServidor(){
    var fs = require('fs');
    var ip = require("ip");


    console.log("IP Servidor: "+ip.address());


    fs.writeFile("./tmp/IP.txt", ip.address(), function (erro) {

        if (erro) {
            throw erro;
        }

        console.log("Arquivo salvo");
    });

    return ip.address();    
}


module.exports = { 
    atualizarTabela, 
    atualizarTabelas,
    pegarIPServidor
 };
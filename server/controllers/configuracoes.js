const servico = require('../servicos/configuracaoServidor');

async function atualizarTabela(req, res) {

    await servico.atualizarTabelas();
    res.send('foi');
}

async function pegarIPServidor(req, res) {

    var fs = require('fs');
    var ip = require("ip");


    console.log(ip.address());


    fs.writeFile("./tmp/IP.txt", ip.address(), function (erro) {

        if (erro) {
            throw erro;
        }

        console.log("Arquivo salvo");
    });


    res.json({ 'IP': ip.address() });
}


module.exports = {
    atualizarTabela,
    pegarIPServidor
}
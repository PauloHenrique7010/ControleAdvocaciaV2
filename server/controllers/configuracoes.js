const servico = require('../servicos/configuracaoServidor');

async function atualizarTabela(req, res) {

    await servico.atualizarTabelas();
    res.send('foi');
}

async function pegarIPServidor(req, res) {

    let ip = await servico.pegarIPServidor();
    res.json({ 'IP': ip });
}


module.exports = {
    atualizarTabela,
    pegarIPServidor
}
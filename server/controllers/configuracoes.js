const servico = require('../servicos/configuracaoServidor');

async function atualizarTabela(req, res) {

    await servico.atualizarTabelas();


    res.send('foi');
}


module.exports = {
    atualizarTabela
}
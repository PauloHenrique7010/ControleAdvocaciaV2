const modelServico = require('../models/servico');

async function pesquisarServico(req, res) {

    const {
        dtInicial,
        dtFinal,
        OPApenasEmAberto
    } = req.query;

    var filtro = new Object();
    filtro.dtInicial = dtInicial;
    filtro.dtFinal = dtFinal;
    filtro.OPApenasEmAberto = OPApenasEmAberto;

    const registros = await modelServico.pesquisarServico(filtro);



    /*let nomeParte = "";
    const servicos = await modelServico.listar(filtro);
    for (const linha of servicos) {
        const partes = await modelServicoPagamento.pegarPartesServico(linha.cod_servico);

        nomeParte = "";
        for (const linha1 of partes) {
            if (nomeParte !== "") {
                nomeParte += ", ";
            }
            nomeParte += linha1.nome_parte;
        }
        linha.nomeParte = nomeParte;
    }*/


    res.json({ registros });
}

async function pesquisarPagamento(req, res) {

    const {
        dtInicial,
        dtFinal,
        OPApenasEmAberto
    } = req.query;

    var filtro = new Object();
    filtro.dtInicial = dtInicial;
    filtro.dtFinal = dtFinal;
    filtro.OPApenasEmAberto = OPApenasEmAberto;

    let nomeParte = "";
    const servicos = await modelServico.pesquisarPagamento(filtro);
    for (const linha of servicos) {
        const partes = await modelServico.pegarPartesServico(linha.cod_servico);

        nomeParte = "";
        for (const linha1 of partes) {
            if (nomeParte !== "") {
                nomeParte += ", ";
            }
            nomeParte += linha1.nome_parte;
        }
        linha.nomeParte = nomeParte;
    }


    res.json({ servicos });
}

async function pegarPartesServico(req, res) {
    const {
        codigo
    } = req.query;


    const partes = await modelServico.pegarPartesServico(codigo);
    res.json({ partes });
}


async function darBaixaPagamento(req, res) {
    const {
        codigo
    } = req.body;

    try {
        let sucesso = await modelServicoPagamento.darBaixaPagamento(codigo);
        if (sucesso.affectedRows > 0) 
            res.status(200).json({
                "title":"Sucesso!",
                "message":"Baixa efetuada!"
            });
        else 
            res.status(202).json({
                "title":"Aviso!",
                "message":"Registro informado não foi encontrado no banco."
            });        

    } catch (error) {
        res.status(500).json({
            "title": "Erro!",
            "message": "<span>Não foi possível dar baixa no pagamento devido ao seguinte erro:</span> <br><br>" + error
        });
    }

}

module.exports = {
    pesquisarServico,    
    pesquisarPagamento,
    darBaixaPagamento,
    pegarPartesServico

}
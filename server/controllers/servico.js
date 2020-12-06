const modelServico = require('../models/servico');

async function pesquisarServico(req, res) {
    const registros = await modelServico.pesquisarServico(req.query);

    //partes do servico
    for (const linha of registros) {
        const partes = await modelServico.pegarPartesServico(linha.cod_servico);
        //linha.partesServico = partes; //coloca tudo que vier no partesserivoc
       

        array = [];
        for (const linha1 of partes) {
            parte = new Object();
            parte.cod_servico = linha1.cod_servico;
            parte.cod_parte = linha1.cod_parte;
            parte.nome_parte = linha1.nome_parte;           

            array.push(parte);
        }
        linha.partesServico = array;
    }  
    
    //prestacoes cartao
    for (const linha of registros) {
        const prestacoes = await modelServico.pesquisarPagamento({codServico: linha.cod_servico});
        linha.prestacoesCartao = prestacoes; //coloca tudo que vier no prestacoes

        /*array = [];
        for (const linha1 of prestacoes) {
            prestacao = new Object();
            prestacao.cod_servico = linha1.cod_servico;
            prestacao.valor_parcela = linha1.valor_parcela;

            //prestacao.cod_prestacao = linha1.cod_prestacao;
            //prestacao.nome_prestacao = linha1.nome_prestacao;           

            array.push(prestacao);
        }
        linha.prestacoesCartao = array;*/
    } 


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
        let sucesso = await modelServico.darBaixaPagamento(codigo);
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

async function cadastrarServico(req, res){
    try {
        let resposta = await modelServico.cadastrarServico(req.body);
        if (resposta.OPSucesso) 
            res.status(200).json({
                "title":"Sucesso!",
                "message":"Cadastrado!",
                "tipo":"success"
            });
        else 
            res.status(202).json({
                "title":"Erro!",
                "message":"<h4>Não foi possível concluir a operação devido ao seguinte erro:</h4> <br><br>"+resposta.message,
                "tipo":'error'
            });        

    } catch (error) {
        res.status(202).json({
            "title": "Erro!",
            "message": "<h4>Não foi possível concluir a operação devido ao seguinte erro:</h4> <br><br>" + error,
            "tipo":"error"
        });
    }

}

module.exports = {
    cadastrarServico,
    pesquisarServico,    
    pesquisarPagamento,
    darBaixaPagamento,
    pegarPartesServico
}
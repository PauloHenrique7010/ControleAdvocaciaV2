/*const cripto = require('../servicos/criptografia');
const modelComunicado = require('../models/comunicado');
const modelResposta = require('../models/resposta');
const crypto = require('crypto');
const email = require('../servicos/email');
const servCrypto = require('../servicos/criptografia');
const logService = require('../servicos/logger');*/

const servico = require('../models/servico');
const modelServico = require('../models/servico');

async function index(req, res) {

    const {
        dtInicial,
        dtFinal
    } = req.query;

    var filtro = new Object();
    filtro.dtInicial = dtInicial;
    filtro.dtFinal = dtFinal;

    let nomeParte = "";
    const servicos = await modelServico.listar(filtro);
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

/*
    const cod_comunicado = req.params.cod_comunicado;
    const comunicados = await modelComunicado.listar(cod_comunicado);
    
    var lista_comunicados = {};

    if (comunicados) {
        lista_comunicados.responsavel_comunicado = comunicados[0].responsavel_comunicado
        lista_comunicados.nome_dpo = comunicados[0].nome_dpo
        lista_comunicados.email_comunicado = comunicados[0].email_comunicado
        lista_comunicados.hash_comunicado = comunicados[0].hash_comunicado
        lista_comunicados.respostas = []

        comunicados.forEach(resposta => {
            lista_comunicados.respostas.push({
                author: resposta.autor_resposta,
                conteudo: servCrypto.descriptografar(resposta.conteudo_resposta, lista_comunicados.hash_comunicado),
                data: resposta.data_resposta
            })
        });
    }

    res.json({lista_comunicados: lista_comunicados});
}

async function retornarTodosComunicados(req, res){
    const retorno = await modelComunicado.listarTodosComunicado();
    res.json({retorno:retorno});
}

/*
async function criarComunicado(req, res) {
    const {
        responsavel_comunicado,
        email_comunicado,
        cod_dpo,
        desc,
    } = req.body;

    var hash_comunicado = crypto.randomBytes(6).toString('HEX');

    const comunicado = await modelComunicado.criar(responsavel_comunicado, email_comunicado, hash_comunicado, cod_dpo)
    
    const conteudo = cripto.criptografar(desc, hash_comunicado);

    const resposta = modelResposta.criar(conteudo, responsavel_comunicado, comunicado.cod_comunicado);

    logService.sendLog('info', `Comunicado "${comunicado.cod_comunicado}" criado por ${responsavel_comunicado}!`, hash_comunicado, comunicado.cod_comunicado);
    
    email.enviarEmail('Recebemos sua mensagem.', 'Recebemos sua mensagem! Em breve o DPO entrará em contato com você.', email_comunicado, responsavel_comunicado, hash_comunicado);
    res.json({comunicado: comunicado, resposta: resposta});
}*/

module.exports = {
    index,
    pegarPartesServico,
    darBaixaPagamento
}
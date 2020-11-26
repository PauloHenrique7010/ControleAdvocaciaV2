const modelCliente = require('../models/cliente');

async function index(req, res) {

    const {
        OPReduzido, //tipo de sql(colunas a menos)
        codCliente
    } = req.query;

    var filtro = new Object();
    filtro.codCliente = codCliente;        
    filtro.OPReduzido = OPReduzido;

    
    const registros = await modelCliente.pesquisarCliente(filtro);

    res.json({ registros });
}

async function pegarPartesServico(req, res) {
    const {
        codigo
    } = req.query;


    const partes = await modelServicoPagamento.pegarPartesServico(codigo);
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
    index,
    pegarPartesServico,
    darBaixaPagamento
}
const express = require('express');
const cors = require('cors');

const app = express();

const boleto = require("./routes/boleto");
const funcoes = require("./routes/funcoes");
const tipoProcesso = require("./routes/tipoProcesso");
const tipoServico = require("./routes/tipoServico");
const tipoAcao = require("./routes/tipoAcao");
const formaPagamento = require("./routes/formaPagamento");
const contrato = require('./routes/contrato');
const cliente = require('./routes/cliente');
const servico = require('./routes/servico');

app.use(cors());

app.use(express.json());


//Rotas
app.use('/boleto', boleto);
app.use('/cliente',cliente);
app.use('/contrato', contrato);
app.use('/formaPagamento', formaPagamento);
app.use('/funcoes', funcoes);
app.use('/servico',servico);
app.use('/tipoAcao', tipoAcao);
app.use('/tipoProcesso', tipoProcesso);
app.use('/tipoServico', tipoServico);


app.get('/', (req, res) => {
  res.send('Rota principal');
});

app.listen(8020, () =>{
  console.log("Servidor rodando na porta 8020!")
});

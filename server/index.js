const express = require('express');
const cors = require('cors');
const app = express();
const servico = require("./routes/servico");
const boleto = require("./routes/boleto");
const funcoes = require("./routes/funcoes");
const tipoProcesso = require("./routes/tipoProcesso");
const tipoAcao = require("./routes/tipoAcao");
const formaPagamento = require("./routes/formaPagamento");

app.use(cors());

app.use(express.json());


//Rotas
app.use('/tipoProcesso', tipoProcesso);
app.use('/tipoAcao', tipoAcao);
app.use('/formaPagamento', formaPagamento);
app.use('/servico', servico);
app.use('/boleto', boleto);
app.use('/funcoes', funcoes);

app.get('/', (req, res) => {
  res.send('Rota principal');
});

app.listen(8020, () =>{
  console.log("Servidor rodando na porta 8020!")
});

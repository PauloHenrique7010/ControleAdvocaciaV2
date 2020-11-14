const express = require('express');
const cors = require('cors');
const app = express();

/*const comunicado = require("./routes/comunicado");
const validacao = require("./routes/validacao");
const resposta = require("./routes/resposta");
const login = require("./routes/login");
const dpo = require("./routes/dpo");
const log = require("./routes/log");*/

const servico = require("./routes/servico");
const boleto = require("./routes/boleto");

app.use(cors());

app.use(express.json());


//Rotas
app.use('/servico', servico);
app.use('/boleto', boleto)

app.get('/', (req, res) => {
  res.send('Rota principal');
});

app.listen(8020, () =>{
  console.log("Servidor rodando na porta 8020!")
});

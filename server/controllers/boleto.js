const { Bancos, Boletos, streamToPromise } = require('gerar-boletos');
const fs = require('fs');
const funcoes = require('../servicos/funcoes');
const moment = require('moment'); // require

async function index(req, res) {
  const {
    valor,
    dataVencimento
  } = req.query;

  dataNova = moment(dataVencimento, "DD/MM/YYYY");
  dataNova = moment(dataNova).format("MM/DD/YYYY");

  
  const boleto = {
        banco: new Bancos.BancoBrasil(),
        pagador: {
          nome: 'José Bonifácio de Andrada',
          registroNacional: '12345678',
          endereco: {
            logradouro: 'Rua Pedro Lessa, 15',
            bairro: 'Centro',
            cidade: 'Rio de Janeiro',
            estadoUF: 'RJ',
            cep: '20030-030'
          }
        },
        instrucoes: ['Após o vencimento Mora dia R$ 1,59', 'Após o vencimento, multa de 2%'],
        beneficiario: {
          nome: 'Empresa Fictícia LTDA',
          cnpj:'43576788000191',
          dadosBancarios: {
            carteira: '09',
            agencia: '18455',
            agenciaDigito: '4',
            conta: '1277165',
            contaDigito: '1',
            nossoNumero: '00000000061',
            nossoNumeroDigito: '8'
          },
          endereco: {
            logradouro: 'Rua Pedro Lessa, 15',
            bairro: 'Centro',
            cidade: 'Rio de Janeiro',
            estadoUF: 'RJ',
            cep: '20030-030'
          }
        },
        boleto: {
          numeroDocumento: '1001',
          especieDocumento: 'DM',
          valor: valor,
          datas: {
            vencimento: dataNova,
            processamento: '02-04-2019',
            documentos: '02-04-2019'
          }
        }
      };
      
      const novoBoleto = new Boletos(boleto);
      novoBoleto.gerarBoleto();
      
      
      novoBoleto.pdfFile().then(async ({ stream }) => {
        //ctx.res.set('Content-type', 'application/pdf');	
        await streamToPromise(stream).then(function(){
          
        });   
        
        
      }).catch((error) => {
        return error;
      });
      let diretorio = "server/tmp/boletos/boleto.pdf";
      res.json({diretorio:diretorio});
       
}

module.exports = {
    index
}
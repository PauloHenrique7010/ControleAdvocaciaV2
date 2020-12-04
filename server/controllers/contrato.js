const { jsPDF } = require("jspdf"); // will automatically load the node version
const extenso = require('numero-por-extenso');
const funcoes = require('../servicos/funcoes');
const fs = require('fs');


async function criarContrato(req, res) {
    const pdf = new jsPDF();
    //exclui o antigo
    let caminho = "./tmp/a4.pdf";
    //se o arquivo existir, apaga
    /*if (fs.existsSync(caminho)){
        await fs.unlink(caminho,function(err){
            if(err) return console.log(err);
            //console.log('file deleted successfully');
       }); 
    }*/
    
    let dataAtual = new Date();
    
    pdf.text(funcoes.formatDateTime(dataAtual, 'DD/MM/YYYY HH:MM:SS'),4,4);
    pdf.text('kk',3,3);


    await pdf.save(caminho); // will save the file in the current working directory    

    res.send('kk');
}


async function calcularNewLine(texto) {
    var qtdeLinha = pdf.splitTextToSize(texto, 169);
    qtdeLinha = qtdeLinha.length;
    return (qtdeLinha * pdf.getLineHeight() / 2.3);
}

module.exports = {
    criarContrato
}
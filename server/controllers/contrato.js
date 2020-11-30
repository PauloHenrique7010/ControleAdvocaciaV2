const { jsPDF } = require("jspdf"); // will automatically load the node version

    const pdf = new jsPDF();   
async function criarContrato(req, res) {
 

    

    let margemEsquerda = 20;
    let YPos = 29;
    let texto = "";

    pdf.setFontSize(12);
    pdf.setFont('helvetica'); //sinonimo para Arial
    pdf.text("São José dos Campos, 24 de outubro de 2020.", margemEsquerda, YPos);
    YPos = 48.5;
    texto = "       Prezados Srs. Raiane Lima Cavalcante, Paulo Oliveira Cavalcante, Maria Odete Lima Santos ";
    pdf.text(texto, margemEsquerda, YPos, { maxWidth: 169, align: 'justify' });
    YPos += await calcularNewLine(texto);
    
    
    texto = "       Cordiais saudações:";
    pdf.text(texto, margemEsquerda, YPos, { maxWidth: 169, align: 'justify' });    
    YPos += await calcularNewLine(texto)+5;

        
    texto = "    Venho por meio desta, confirmar nossos atendimentos, segundo os quais estou disposta a " +
        "prestar-lhe os meus serviços profissionais, consistentes nas ações: Embargos de Terceiro " +
        "contra ação de Imissão de posse do imóvel sito Rua Benedito Henrique, 20, Campo dos Alemães. ";
    pdf.text(texto, margemEsquerda, YPos, { maxWidth: 169, align: 'justify' });
    YPos += await calcularNewLine(texto);

    texto = "    Por tais serviços, V. S.a me pagará os honorários, certos e ajustados por esta carta com " +
        "força de contrato, no valor de R$ 7000,00 (sete mil reais), pagos R$ 500,00 iniciais e demais " +
        "parcelas mensais e consecutivas a partir de 24/11, sendo que os honorários de sucumbência também " +
        "serão como definidos em lei, exclusivos do advogado.";
    pdf.text(texto, margemEsquerda, YPos, { maxWidth: 169, align: 'justify' });
    YPos += await calcularNewLine(texto)-17;

    texto = "   Caso haja desistência por parte do cliente, ou qualquer outro ato que venha perder o objeto "+
            "da ação, ficará obrigado ao pagamento de honorários, à época do ato, no valor mínimo tabelado na "+
            "OAB, independente do estado em que se encontrar a ação, ainda, importa destacar, que os honorários "+
            "pactuados serão devidos, na ocorrência de outro advogado assumir as ações, seja por renúncia ou por rescisão.";
    texto += "Fica pactuado que os herdeiros e sucessores se obrigarão a cumprir os termos desta minuta de contrato. ";
    pdf.text(texto, margemEsquerda, YPos, { maxWidth: 169, align: 'justify' });
    YPos += await calcularNewLine(texto)-17;


    pdf.save("./tmp/a4.pdf"); // will save the file in the current working directory

    res.send('kk');
}

async function calcularNewLine(texto){
    return (texto.length / 100) * pdf.getLineHeight();
}

module.exports = {
    criarContrato
}
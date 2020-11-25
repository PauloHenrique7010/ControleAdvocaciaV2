
async function criarContrato(req, res) {
    const { jsPDF } = require("jspdf"); // will automatically load the node version

    const pdf = new jsPDF();

    let margemEsquerda = 30;


    pdf.setFontSize(13);
    pdf.setFont('helvetica'); //sinonimo para Arial
    pdf.text("São José dos Campos, 24 de abril de 2020.", margemEsquerda, 17);
    pdf.text("Prezadas Sr.", margemEsquerda, 38);
    pdf.setFont('helvetica', 'bold');
    pdf.text("< NOME DA PRINCESA >", margemEsquerda + 27.5, 38);
    pdf.setFont('helvetica', 'normal'); //sinonimo para Arial
    pdf.text("Cordiais saudações:", margemEsquerda, 43.5)

    let texto = "Venho por meio desta, confirmar nossos atendimentos, segundo os quais estou disposta a "+
                "prestar-lhe os meus serviços profissionais, consistentes em Ação Ordinária contra a "+
                "Fazenda Pública do Estado de São Paulo, relativo a cobrança de quinquênios. ";
    pdf.text(texto, margemEsquerda, 53.5, { maxWidth: 159, align: 'justify' });
    
    texto = "    Por tais serviços, V. S.a me pagará os honorários, certos e ajustados por esta carta com "+
            "força de contrato, o valor relativo a 25% (vinte e cinco por cento) de todo o "+
            "valor recebido ao final do processo, independentemente de título. Pactuam que os "+
            "honorários sucumbenciais serão do advogado conforme legislação vigente."

    pdf.text(texto, margemEsquerda, 80, { maxWidth: 159, align: 'justify' });


    texto = "    Ainda, importa destacar, que os honorários pactuados serão devidos, na ocorrência de outro "+
            "advogado assumir as ações, seja por renúncia ou por rescisão, destacando que o presente contrato "+
            "é de meio, e de risco, onde somente os honorários finais estão atrelados a procedência da ação. "
    pdf.text(texto, margemEsquerda, 112, { maxWidth: 159, align: 'justify' });


    pdf.save("./tmp/a4.pdf"); // will save the file in the current working directory

    res.send('kk');
}

module.exports = {
    criarContrato
}
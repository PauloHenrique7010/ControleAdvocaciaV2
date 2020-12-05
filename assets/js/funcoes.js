/* Máscaras ER */
function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
}
function execmascara() {
        v_obj.value = v_fun(v_obj.value)
}
function mtel(v) {
        v = v.replace(/\D/g, "");             //Remove tudo o que não é dígito
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
        return v;
}
function id(el) {
        return document.getElementById(el);
}
// JavaScript Document
//adiciona mascara de cnpj
function MascaraCNPJ(cnpj) {
        if (mascaraInteiro(cnpj) == false) {
                event.returnValue = false;
        }
        return formataCampo(cnpj, '00.000.000/0000-00', event);
}

//adiciona mascara de cep
function MascaraCep(cep) {
        if (mascaraInteiro(cep) == false) {
                event.returnValue = false;
        }
        return formataCampo(cep, '00000-000', event);
}

//adiciona mascara de data
function MascaraData(data) {
        if (mascaraInteiro(data) == false) {
                event.returnValue = false;
        }
        return formataCampo(data, '00/00/0000', event);
}

//adiciona mascara ao telefone
function MascaraTelefone(tel) {
        if (mascaraInteiro(tel) == false) {
                event.returnValue = false;
        }
        return formataCampo(tel, '(00) 0000-0000', event);
}

//adiciona mascara ao CPF
function MascaraCPF(cpf) {
        if (mascaraInteiro(cpf) == false) {
                event.returnValue = false;
        }
        return formataCampo(cpf, '000.000.000-00', event);
}

//valida telefone
function ValidaTelefone(tel) {
        exp = /\(\d{2}\)\ \d{4}\-\d{4}/
        if (!exp.test(tel.value))
                alert('Numero de Telefone Invalido!');
}

//valida CEP
function ValidaCep(cep) {
        exp = /\d{2}\.\d{3}\-\d{3}/
        if (!exp.test(cep.value))
                alert('Numero de Cep Invalido!');
}

//valida data
function validaData(data) {
        var RegExPattern = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;
        if (!((data.match(RegExPattern)) && (data != ''))) {
                return false;
        }
        else
                return true;

}

//valida o CPF digitado
function ValidarCPF(cpf) {
        //var cpf = Objcpf.value;
        exp = /\.|\-/g
        cpf = cpf.toString().replace(exp, "");
        var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
        var soma1 = 0, soma2 = 0;
        var vlr = 11;

        for (i = 0; i < 9; i++) {
                soma1 += eval(cpf.charAt(i) * (vlr - 1));
                soma2 += eval(cpf.charAt(i) * vlr);
                vlr--;
        }
        soma1 = (((soma1 * 10) % 11) == 10 ? 0 : ((soma1 * 10) % 11));
        soma2 = (((soma2 + (2 * soma1)) * 10) % 11);

        var digitoGerado = (soma1 * 10) + soma2;
        if (digitoGerado != digitoDigitado)
                return false
        else
                return true
}

//valida numero inteiro com mascara
function mascaraInteiro() {
        if (event.keyCode < 48 || event.keyCode > 57) {

                event.returnValue = false;
                return false;
        }
        return true;
}

//valida o CNPJ digitado
function ValidarCNPJ(ObjCnpj) {
        var cnpj = ObjCnpj.value;
        var valida = new Array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
        var dig1 = new Number;
        var dig2 = new Number;

        exp = /\.|\-|\//g
        cnpj = cnpj.toString().replace(exp, "");
        var digito = new Number(eval(cnpj.charAt(12) + cnpj.charAt(13)));

        for (i = 0; i < valida.length; i++) {
                dig1 += (i > 0 ? (cnpj.charAt(i - 1) * valida[i]) : 0);
                dig2 += cnpj.charAt(i) * valida[i];
        }
        dig1 = (((dig1 % 11) < 2) ? 0 : (11 - (dig1 % 11)));
        dig2 = (((dig2 % 11) < 2) ? 0 : (11 - (dig2 % 11)));

        if (((dig1 * 10) + dig2) != digito)
                alert('CNPJ Invalido!');

}

//formata de forma generica os campos
function formataCampo(campo, Mascara, evento) {
        var boleanoMascara;

        var Digitato = evento.keyCode;
        exp = /\-|\.|\/|\(|\)| /g
        campoSoNumeros = campo.value.toString().replace(exp, "");

        var posicaoCampo = 0;
        var NovoValorCampo = "";
        var TamanhoMascara = campoSoNumeros.length;;

        if (Digitato != 8) { // backspace 
                for (i = 0; i <= TamanhoMascara; i++) {
                        boleanoMascara = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                                || (Mascara.charAt(i) == "/"))
                        boleanoMascara = boleanoMascara || ((Mascara.charAt(i) == "(")
                                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                        if (boleanoMascara) {
                                NovoValorCampo += Mascara.charAt(i);
                                TamanhoMascara++;
                        } else {
                                NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                                posicaoCampo++;
                        }
                }
                campo.value = NovoValorCampo;
                return true;
        } else {
                return true;
        }
}


//adiciona mascara ao RG
function MascaraRG(rg) {
        /*if(mascaraInteiro(rg)==false){
                event.returnValue = false;
        }       
        return formataCampo(rg, '00.000.000-0', event);*/

        if ((rg) == false) {
                event.returnValue = false;
        }
        return formataCampo(rg, '00.000.000-0', event);
}

window.onload = function () {
        //chamando atraves do proprio campo a função
        /*id('telefone_cliente').onkeyup = function(){
                mascara( this, mtel );
        }*/


}

function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('cep').value = ("");
        document.getElementById('endereco').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('uf').value = ("");
        //document.getElementById('ibge').value=("");
}

function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('cep').value = (conteudo.cep);
                document.getElementById('endereco').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
                //document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
                document.getElementById('cep').focus();
        }
}
function pesquisacep(valor) {


        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('endereco').value = "...";
                        document.getElementById('bairro').value = "...";
                        document.getElementById('cidade').value = "...";
                        document.getElementById('uf').value = "...";
                        //document.getElementById('ibge').value="...";

                        //Cria um elemento javascript.
                        var script = document.createElement('script');

                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);

                } //end if.
                else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                        document.getElementById('cep').focus();
                }
        } //end if.
        else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
        }


};
function exibirCamposObrigatorios(texto) {
        var texto = texto.replace(/<p>/g, " ");
        var texto = texto.replace(/<\/p>/g, " ");
        Swal.fire({
                title: 'Verifique os campos abaixo!',
                html: texto,
                icon: 'warning',
                confirmButtonText: 'OK'
        })
};

function exibirMensagemSucesso(titulo, texto) {
        var texto = texto.replace(/<p>/g, " ");
        var texto = texto.replace(/<\/p>/g, " ");
        Swal.fire({
                title: titulo,
                html: texto,
                icon: 'success',
                confirmButtonText: 'OK'
        })
};

function exibirMensagem(titulo, texto, tipo) {
        var texto = texto.replace(/<p>/g, " ");
        var texto = texto.replace(/<\/p>/g, " ");
        Swal.fire({
                title: titulo,
                html: texto,
                icon: tipo,
                confirmButtonText: 'OK'
        });
};

async function exibirPergunta(titulo, texto, tipo) {
       const p = await Swal.fire({
                title: titulo,
                text: texto,
                icon: tipo,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Não',
                confirmButtonText: 'Sim'
        });
        return p.isConfirmed;
}

async function exibirInput(titulo, texto, tipo){
        const p = await Swal.fire({
                input: 'text',
                inputAttributes: {
                        autocapitalize: 'off'
                      },
                title: titulo,
                text: texto,
                icon: tipo,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'OK'
        });
        return p.value;
        
}

function StrToInt(string) {
        string = parseInt(string);
        if (isNaN(string))
                string = 0;
        return string;
}

function StrToFloat(string) {
        string = string.replaceAll(".", "");
        string = string.replaceAll(",", ".");
        string = parseFloat(string).toFixed(2) * 1;

        if (isNaN(string))
                string = 0;
        return string;
}

function FloatToStr(float) {
        return float.toString();
}

function valorMonetarioPorExtenso(float) {
        //+ Carlos R. L. Rodrigues
        //@ http://jsfromhell.com/string/extenso [rev. #3]
        String.prototype.extenso = function (c) {
                var ex = [
                        ["zero", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
                        ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
                        ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
                        ["mil", "milhão", "bilhão", "trilhão", "quadrilhão", "quintilhão", "sextilhão", "setilhão", "octilhão", "nonilhão", "decilhão", "undecilhão", "dodecilhão", "tredecilhão", "quatrodecilhão", "quindecilhão", "sedecilhão", "septendecilhão", "octencilhão", "nonencilhão"]
                ];
                var a, n, v, i, n = this.replace(c ? /[^.\d]/g : /\D/g, "").split("."), e = " e ", $ = "real", d = "centavo", sl;
                for (var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []) {
                        j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
                        if (!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length) continue;
                        for (a = -1, l = v.length; ++a < l; t = "") {
                                if (!(i = v[a] * 1)) continue;
                                i % 100 < 20 && (t += ex[0][i % 100]) ||
                                        i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
                                s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
                                        ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ão", "ões") : ex[3][t]) : ""));
                        }
                        a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
                        a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
                }
                return r.join(e);
        }

        return FloatToStr(float).extenso(true);
}

function formatFloat(float){
        return float.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
              });
}

function formatDateTime(dataInput) {
        if (dataInput == null)
                return "";

        var data = new Date(dataInput),
                dia = data.getDate().toString(),
                diaF = (dia.length == 1) ? '0' + dia : dia,
                mes = (data.getMonth() + 1).toString(), //+1 pois no getMonth Janeiro começa com zero.
                mesF = (mes.length == 1) ? '0' + mes : mes,
                anoF = data.getFullYear();
        if (isNaN(diaF))
                return "";
        return diaF + "/" + mesF + "/" + anoF;
}

function StrToDate(string) {        
        if (validaData(string)) {
                let novaData = string.split('/');
                novaData = new Date(novaData[2], novaData[1] - 1, novaData[0]);                
                return novaData;
        }
        else {
                return null;
        }
}

function exibirMensagemErro(titulo, texto) {
        var texto = texto.replace(/<p>/g, " ");
        var texto = texto.replace(/<\/p>/g, " ");
        Swal.fire({
                title: titulo,
                html: texto,
                icon: 'error',
                confirmButtonText: 'OK'
        })
};


function exibirMensagemAviso(titulo, texto) {
        var texto = texto.replace(/<p>/g, " ");
        var texto = texto.replace(/<\/p>/g, " ");
        Swal.fire({
                title: titulo,
                html: texto,
                icon: 'warning',
                confirmButtonText: 'OK'
        })
};

function formatarMoeda(i) {
        var v = i.value.replace(/\D/g, '');
        v = (v / 100).toFixed(2) + '';
        v = v.replace(".", ",");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
        i.value = v;
}

function pegarRotaBack(rota) {
        return "http://localhost:8020/" + rota;
}

function pularCampos() {
        jQuery('body').on('keydown', 'input, select, textarea', function (e) {
                var self = $(this),
                        form = self.parents('form:eq(0)'),
                        focusable, next;

                //se pressionar ctrl + enter, confirma o cadastro                
                if (e.ctrlKey && e.keyCode == 13) {
                        $("#enviar").trigger('click');
                } else if (e.keyCode == 13) {
                        focusable = form.find('input,a,select,button,textarea').filter(':visible');
                        next = focusable.eq(focusable.index(this) + 1);
                        if (next.length) {
                                next.focus();
                        } else {
                                Confirmar();
                        }
                        return false;
                }

        });
}
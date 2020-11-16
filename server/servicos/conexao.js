desenvolvimento = ({
    host : 'localhost',
    user: 'root',
    password: '',
    database: 'controle_advocacia'
});

producao = ({
    host : 'localhost',
    user: 'root',
    password: '',
    database: 'advocacia'
});

let conexao = producao;

function pegarConexao(){
    return conexao;
}


module.exports = { conexao };
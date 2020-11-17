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

let conexao = desenvolvimento;


module.exports = { conexao };
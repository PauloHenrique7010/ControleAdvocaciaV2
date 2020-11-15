var mysql = require('mysql');
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

var connection = mysql.createConnection(producao);
//var connection = mysql.createConnection(desenvolvimento);


const selectPromise = (select) => {

    return new Promise((resolve, reject) => {
        //se nao possuir conexao, conecta
        if (!connection._connectCalled) {
            connection.connect();
        }

        connection.query(select, function (err, rows, fields) {
            if (err) {
                return reject(err);
            }
            resolve(rows);
        });
    })
}

module.exports = selectPromise;
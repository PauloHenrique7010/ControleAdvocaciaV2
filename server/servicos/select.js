var mysql = require('mysql');
var confConexao = require('./conexao');

var connection = mysql.createConnection(confConexao.conexao);

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
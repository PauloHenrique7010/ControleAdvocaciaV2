var mysql = require('mysql');
var confConexao = require('./conexao');

var connection = mysql.createConnection(confConexao.conexao);

const deletePromisse = (sql) => {

    return new Promise((resolve, reject) => {
        //se nao possuir conexao, conecta
        if (!connection._connectCalled) {
            connection.connect();
        }

        connection.query(sql, function (err, rows, fields) {
            if (err) {
                return reject(err);
            }
            resolve(rows);
        });
    })
}

module.exports = deletePromisse;
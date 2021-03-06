var mysql = require('mysql');
var confConexao = require('./conexao');

var connection = mysql.createConnection(confConexao.conexao);

const insertPromise = (insert) => {

    return new Promise((resolve, reject) => {
        //se nao possuir conexao, conecta
        if (!connection._connectCalled) {
            connection.connect();
        }

        connection.query(insert, function (err, result) {
            if (err) return reject(err);
            resolve(result.insertId);            
          });
    })
}

module.exports = insertPromise;
var mysql = require('mysql');
var confConexao = require('./conexao');

var connection = mysql.createConnection(confConexao.conexao);

const updatePromise = (update) => {

    return new Promise((resolve, reject) => {
        //se nao possuir conexao, conecta
        if (!connection._connectCalled) {
            connection.connect();
        }

        connection.query(update, function (err, result) {
            if (err) return reject(err);            
            resolve(result.affectedRows);            
          });
    })
}

module.exports = updatePromise;
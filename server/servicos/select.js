var mysql = require('mysql');
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'Jane2134@@',
    database: 'controle_advocacia'
});


const selectPromise = (select) => {

    return new Promise((resolve, reject) => {
        connection.connect();
        connection.query(select, function (err, rows, fields) {
            if (err) {
                return reject(err);
            }
            resolve(rows);
        });
        connection.end();
    })
}

module.exports = selectPromise;
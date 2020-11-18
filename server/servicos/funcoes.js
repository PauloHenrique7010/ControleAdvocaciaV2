const moment = require('moment'); // require

//AVISO -> FORMATO EM CAPS LOCK -> DD/MM/YYYY
function strToDate(dataString, formatoString){
    return moment(dataString, formatoString);
}

//AVISO -> FORMATO EM CAPS LOCK -> DD/MM/YYYY
function formatDateTime(dataDate, formatoEmString){
    /*exemplo 
        dataDate -> Date do js
        formatoEmString -> DD/MM/YYYY
    */
   return moment(dataDate).format(formatoEmString);
}

module.exports = {strToDate, formatDateTime};
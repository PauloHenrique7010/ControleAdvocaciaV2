const express = require("express");
const router = express.Router();
const controller = require('../controllers/servicoPagamento')

router.get('/', controller.index);
router.get('/partes', controller.pegarPartesServico);
router.post('/darBaixaPagamento', controller.darBaixaPagamento);

/*router.get('/', controller.comunicado.retornarTodosComunicados);
router.post('/', controller.comunicado.criarComunicado);*/

module.exports = router;
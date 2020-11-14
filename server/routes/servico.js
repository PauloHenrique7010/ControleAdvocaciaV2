const express = require("express");
const router = express.Router();
const controller = require('../controllers/servico')

router.get('/', controller.index);
router.get('/partes', controller.pegarPartesServico);

/*router.get('/', controller.comunicado.retornarTodosComunicados);
router.post('/', controller.comunicado.criarComunicado);*/

module.exports = router;
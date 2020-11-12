const express = require("express");
const router = express.Router();
const controller = require('../controllers/servico')

router.get('/:cod_comunicado', controller.index);
/*router.get('/', controller.comunicado.retornarTodosComunicados);
router.post('/', controller.comunicado.criarComunicado);*/

module.exports = router;
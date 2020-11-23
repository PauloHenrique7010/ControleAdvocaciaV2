const express = require("express");
const router = express.Router();
const controller = require('../controllers/tipoProcesso')

router.get('/', controller.index);
router.delete('/',controller.excluirTipoProcesso);
router.post('/', controller.cadastrarTipoProcesso);
router.put('/', controller.alterarTipoProcesso);


module.exports = router;
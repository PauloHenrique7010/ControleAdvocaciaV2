const express = require("express");
const router = express.Router();
const controller = require('../controllers/tipoAcao')

router.get('/', controller.index);
router.delete('/',controller.excluirTipoAcao);
router.post('/', controller.cadastrarTipoAcao);
router.put('/', controller.alterarTipoAcao);


module.exports = router;
const express = require("express");
const router = express.Router();
const controller = require('../controllers/tipoServico')

router.get('/', controller.pesquisarTipoServico);
router.delete('/',controller.excluirTipoServico);
router.post('/', controller.cadastrarTipoServico);
router.put('/', controller.alterarTipoServico);


module.exports = router;
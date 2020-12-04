const express = require("express");
const router = express.Router();
const controller = require('../controllers/servico')

router.get('/', controller.pesquisarServico);
router.get('/pagamento/', controller.pesquisarPagamento);
router.get('/partes', controller.pegarPartesServico);
router.post('/darBaixaPagamento', controller.darBaixaPagamento);
router.post('/cadastrar', controller.cadastrarServico);

module.exports = router;
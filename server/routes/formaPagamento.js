const express = require("express");
const router = express.Router();
const controller = require('../controllers/formaPagamento')

router.get('/', controller.index);
router.delete('/',controller.excluirFormaPagamento);
router.post('/', controller.cadastrarFormaPagamento);
router.put('/', controller.alterarFormaPagamento);


module.exports = router;
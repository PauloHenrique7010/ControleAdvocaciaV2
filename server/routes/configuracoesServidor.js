const express = require("express");
const router = express.Router();
const controller = require('../controllers/configuracoes');

router.get('/atualizarTabela', controller.atualizarTabela);
router.get('/pegarIPServidor', controller.pegarIPServidor);

module.exports = router;
const express = require("express");
const router = express.Router();
const controller = require('../controllers/configuracoes');

router.get('/atualizarTabela', controller.atualizarTabela);

module.exports = router;
const express = require("express");
const router = express.Router();
const controller = require('../controllers/contrato')

router.post('/criar', controller.criarContrato);


module.exports = router;
const express = require("express");
const router = express.Router();
const controller = require('../controllers/boleto')

router.get('/', controller.index);


module.exports = router;
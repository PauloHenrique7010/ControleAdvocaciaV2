const express = require("express");
const router = express.Router();
const controller = require('../controllers/funcoes')

router.get('/strToDate', controller.strToDate);
router.get('/formatDateTime', controller.formatDateTime);

module.exports = router;
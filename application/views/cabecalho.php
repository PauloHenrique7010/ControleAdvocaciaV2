<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $tituloGuia; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url("assets/js/funcoes.js");?>"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="<?php echo base_url(); ?>">Home</a>
  <!-- Links -->
  <ul class="navbar-nav">
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Registros
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo base_url('Cliente');?>">Cliente</a>
        <a class="dropdown-item" href="<?php echo base_url('Servicos');?>">Serviços</a>
        <a class="dropdown-item" href="<?php echo base_url('Caixa');?>">Caixa</a>        
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Novo
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="<?php echo base_url('NovoCliente');?>">Cliente</a>
        <a class="dropdown-item" href="<?php echo base_url('NovoServico');?>">Serviço</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li>



    <li class="nav-item">
      <a class="nav-link" href="#">Sobre</a>
    </li>
  </ul>
</nav>
<br>
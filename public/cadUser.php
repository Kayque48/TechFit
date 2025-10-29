<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Estilos customizados -->
  <link rel="stylesheet" href="css/CadUser.css">
  
  <title>Cadastro de Clientes - TechFit</title>
</head>
<body>

<?php
  require_once('../src/views/header.php');
?>

  <main class="container mt-4">
    <div class="row g-3">

      <!-- Nome -->
      <div class="col-sm-6">
        <label for="firstName" class="form-label">Primeiro nome</label>
        <input type="text" class="form-control" id="firstName" required>
        <div class="invalid-feedback">Valid first name is required.</div>
      </div>

      <!-- Sobrenome -->
      <div class="col-sm-6">
        <label for="lastName" class="form-label">Sobrenome</label>
        <input type="text" class="form-control" id="lastName" required>
        <div class="invalid-feedback">Sobrenome</div>
      </div>

      <!-- Usuário -->
      <div class="col-12">
        <label for="username" class="form-label">Nome de usuário</label>
        <div class="input-group has-validation">
          <!-- <span class="input-group-text">@</span> -->
          <input type="text" class="form-control" id="username" placeholder="" required>
          <div class="invalid-feedback">Your username is required.</div>
        </div>
      </div>

      <!-- Email -->
      <div class="col-12">
        <label for="email" class="form-label">
          Email <span class="text-body-secondary"></span>
        </label>
        <input type="email" class="form-control" id="email" placeholder="">
        <div class="invalid-feedback">Please enter a valid email address for shipping updates.</div>
      </div>

      <!-- Endereço -->
      <div class="col-12">
        <label for="address" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="address" placeholder="" required>
        <div class="invalid-feedback">Please enter your shipping address.</div>
      </div>

      <!-- Endereço 2 -->
      <div class="col-12">
        <label for="address2" class="form-label">
          Telefone <span class="text-body-secondary"></span>
        </label>
        <input type="text" class="form-control" id="address2" placeholder="">
      </div>

      <!-- Plano -->
    <div class="col-md-4">
    <label for="state" class="form-label">Assinatura</label>
    <select class="form-select" id="state" required>
        <option value="">Selecione seu plano</option>
        <option value="mensal">Plano Mensal - R$ 99,90</option>
        <option value="trimestral">Plano Trimestral - R$ 269,90 (economia de 10%)</option>
        <option value="semestral">Plano Semestral - R$ 499,90 (economia de 15%)</option>
        <option value="anual">Plano Anual - R$ 899,90 (economia de 25%)</option>
        <option value="vip">Plano VIP - R$ 1.299,90 (acesso ilimitado + personal trainer)</option>
    </select>
    <div class="invalid-feedback">Por favor, selecione um plano válido.</div>
    </div>


      <!-- CEP -->
      <div class="col-md-3">
        <label for="zip" class="form-label">CEP</label>
        <input type="text" class="form-control" id="zip" required>
        <div class="invalid-feedback">Zip code required.</div>
      </div>

      <div>
        <ul>
        <li>já tem uma conta? <a href="loginUser.html">Cadastro</a></li>
      </ul>
      </div>

    </div>
  </main>

</body>
</html>
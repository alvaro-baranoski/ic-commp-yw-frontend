<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Yule-Walker</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/scrolling-nav.css" rel="stylesheet">

  <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

</head>

<body id="page-top">

  <!-- Navigation -->
  <?php include('menu.php'); ?>

  <section class="pb-0" id="about">
    <div class="container">
      <h2>Choose a PMU</h2>
      <select class="custom-select" id="select-pmu" onchange="location = this.value;">
        <option value="index.php" selected>Choose...</option>
        <option value="pmu_cabine.php">Elétrica</option>
        <option value="pmu_eficiencia.php">Microgrid</option>
        <option value="pmu_palotina.php">Palotina</option>
        <option value="pmu_agrarias.php">Agrárias</option>
        <option value="about.php" disabled>UsinaFV</option>
        <option value="about.php" disabled>Copel</option>
      </select>
      
      <h5 class="mt-2">Other methods available: </h5>
      <a class="btn btn-secondary" href="https://sirius.eletrica.ufpr.br/welch/index.php" target="_blank" role="button">Welch</a>
      
      <div id="number-access-div" class="d-none mt-2">
        <p>This website has received <span id="number-access"></span> visitors so far!</p>
      </div>

      <div class="container d-none pt-3 p-0 mt-3" id="main_modes_div">
        <h3> Interconnected grid's electromechanical modes of Curitiba city </h3>
        
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Frequency range [Hz]</th>
              <th scope="col">Damping ratio range [%]</th>
              <th scope="col">Mode incidence</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <!-- Tempo de atualização -->
      <div class="p-5 row justify-content-center d-none" id="last-update">
        <h5>Last update at <span id="last-update-time"></span></h5>
      </div>

      <!-- Logo de loading -->
      <div id="loading" style="text-align: center;">
        <img src="svg/loading-big.gif" width="400px">
        <p align="center">
          <h1>
            <b>LOADING...</b>
          </h1>
        </p>
      </div>

      <!-- Mensagem de erro -->
      <div id="pmu-error" class="container pb-5 pt-5 w-75 d-none">
        <div class="row d-flex">
            <div class="col">
              <img src="svg/switch-off.svg" width="400px">
            </div>
            <div class="col" style="margin: auto">
              <p>
              <h3><b>We're very sorry, but not all PMUs are currently available.</b></h3>
              </p>
            </div>
        </div>
      </div>
  </section>

  <?php include('footer.php'); ?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="js/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="js/scrolling-nav.js"></script>

  <script async src="https://api.countapi.xyz/hit/sirius.eletrica.ufpr.br/yulewalker?callback=cb"></script>

  <!-- Main code for this page -->
  <script type="text/javascript" src="js/index.js"></script>

</body>

</html>
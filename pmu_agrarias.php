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

</head>

<body id="page-top">

  <!-- Navigation -->
  <?php include('menu.php'); ?>

  <!-- Gets PMU value for page -->
  <p id="select-pmu" hidden>agrarias</p>

  <!-- Page header and form -->
  <section id="about">
    <div class="container">
      <h4> Unidade de medição: Agrárias </h4>

      <form>
        <div class="form-row">
          <div class="col">
            <label for="time_window_select">Informe o tempo desejada em minutos</label>
            <input type="number" class="form-control" id="time_window_select" aria-describedby="time_window" placeholder="60" min="1" max="60" step="1">
            <small id="time_window" class="form-text text-muted">
              Janela de tempo máxima de 60 minutos.
            </small>
          </div>

          <div class="col">
            <label for="sample_frequency_select">
              Informe a frequência desejada em hertz
            </label>
            <input type="number" class="form-control" id="sample_frequency_select" aria-describedby="time_window" placeholder="5" min="1" max="20" step="1">
            <small id="freq_select" class="form-text text-muted">
              Frequência de amostragem máxima de 20 Hz.
            </small>
          </div>

          <div class="col">
            <label for="order_select">
              Informe a ordem do modelo desejada
            </label>
            <input type="number" class="form-control" id="order_select" aria-describedby="time_window" placeholder="10" min="2" max="30" step="1">
            <small id="ord_select" class="form-text text-muted">
              Ordem do modelo máxima de 30.
            </small>
          </div>

        </div>

        <button type="button" id="button_id" class="btn btn-secondary" style="margin-top: 10px">
          Atualizar
        </button>
      </form>

      <!-- Gráficos -->
      <div class="row" id="graph1" style="width: 1140px;"></div>
      <div class="row" id="graph2" style="width: 1140px;"></div>

      <!-- Tempo de atualização -->
      <div class="row justify-content-center" id="last-update" style="display:none">
        <h3>Última atualização em <span id="last-update-time"></span></h3>
      </div>
    </div>

    <!-- Logo de loading -->
    <div id="loading" style="text-align: center; display: none">
      <img src="svg/loading-big.gif" width="400px">
      <p align="center">
      <h1><b>LOADING...</b></h1>
      </p>
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

  <!-- Data processing algorithms -->
  <script type="text/javascript" src="js/plotly-latest.min.js"></script>
  <script type="text/javascript" src="js/generate-graphs.js"></script>

</body>

</html>
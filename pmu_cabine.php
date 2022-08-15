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

  <!-- Bootstrap icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body id="page-top">

  <!-- Navigation -->
  <?php include('menu.php'); ?>

  <!-- Gets PMU value for page -->
  <p id="select-pmu" hidden>cabine</p>

  <!-- Page header and form -->
  <section class="pb-0" id="about">
    <div class="container">
      <h4> Measurement Unit: Elétrica </h4>

      <!-- Dashboard view selection button -->
      <button 
        id="toggle-btn"
        type="button" 
        class="btn btn-primary btn-lg btn-block" 
        data-toggle="button" 
        aria-pressed="false" 
        autocomplete="off">
        Simplified dashboard
      </button>

      <form
        id="page-form" 
        class="d-none">

        <div class="form-row mt-3">

          <!-- Time window -->
          <div class="col">
            <label for="time_window_select">Time window in minutes</label>
            <input 
              type="number" 
              class="form-control" 
              id="time_window_select" 
              aria-describedby="time_window" 
              placeholder="20" 
              min="1" 
              max="60" 
              step="1">
            <small id="time_window" class="form-text text-muted">
              Size of time window to be processed.
            </small>
          </div>

          <!-- Sample frequency -->
          <div class="col">
            <label for="sample_frequency_select">
              Sample frequency in hertz
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="sample_frequency_select" 
              aria-describedby="time_window" 
              placeholder="100" 
              min="60" 
              max="120" 
              step="10">
            <small id="freq_select" class="form-text text-muted">
              Sample frequency that data will be acquired.
            </small>
          </div>

          <!-- Model order -->
          <div class="col">
            <label for="order_select">
              Model order
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="order_select" 
              aria-describedby="time_window" 
              placeholder="20" 
              min="10" 
              max="30" 
              step="1">
            <small id="ord_select" class="form-text text-muted">
              ARMA model initial order.
            </small>
          </div>
        </div>

        <div class="form-row mt-3">

          <!-- Filter lower bandwith -->
          <div class="col">
            <label for="filter_lower_select">
              Filter lower bandwidth in hertz
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="filter_lower_select" 
              placeholder="0.04" 
              min="0.01"  
              step="0.3">
            <small class="form-text text-muted">
              FIR highpass filter frequency cutoff.
            </small>
          </div>

          <!-- Filter higher bandwidth -->
          <div class="col">
            <label for="filter_higher_select">
              Filter higher bandwidth in hertz
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="filter_higher_select" 
              aria-describedby="time_window" 
              placeholder="4.0">
            <small class="form-text text-muted">
              FIR lowpass filter frequency cutoff.
            </small>
          </div>

          <!-- Outliner sensibility -->
          <div class="col">
            <label for="order_select">
              Outliner detection constant
            </label>
            <input 
              type="number" 
              class="form-control" 
              id="outliner_select"  
              placeholder="5" 
              min="1"  
              step="1">
            <small class="form-text text-muted">
              Value multiplied by standard deviation to find outliers.
            </small>
          </div>
        </div>

      </form>
      <button type="button" id="button_id" class="btn btn-secondary" style="margin-top: 10px">
        Update
      </button>

      <div class="container d-none p-0 mt-3" id="main_modes_div">
        <h5> Main electromechanical modes calculated </h5>
        
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Frequency range [Hz]</th>
              <th scope="col">Damping ratio range [%]</th>
              <th scope="col">Mode incidence</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td id="freq_range"></td>
              <td id="damp_range"></td>
              <td id="mode_presence"></td>
              <td id="crossvalidation_check"></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td id="freq_range_2"></td>
              <td id="damp_range_2"></td>
              <td id="mode_presence_2"></td>
              <td id="crossvalidation_check_2"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Gráficos -->
      <div class="row d-none" id="graph1" style="width: 1140px;"></div>
      <div class="row d-none" id="graph_processed" style="width: 1140px;"></div>
      <div class="row d-none" id="graph2" style="width: 1140px;"></div>
      <div class="row d-none" id="graph_conv_stab" style="width: 1140px;"></div>
      <div class="row d-none" id="graph_3d_stab" style="width: 1140px;"></div>

      <!-- Tempo de atualização -->
      <div class="row justify-content-center" id="last-update" style="display:none">
        <h3>Last update at <span id="last-update-time"></span></h3>
      </div>
    </div>

    <!-- Logo de loading -->
    <div id="loading" style="text-align: center;">
      <img src="svg/loading-big.gif" width="400px">
      <p align="center">
      <h1><b>LOADING...</b></h1>
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
            <h3><b>We're very sorry, but the requested PMU is currently offline.</b></h3>
            </p>
          </div>
      </div>
    </div>
  </section>

  <!-- PMU location -->
  <div class="text-center pb-5 d-none" id="pmu-location">
    <h5 class="pt-4">PMU geographical location</h5>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d900.6527585227743!2d-49.23439171191856!3d-25.45126449898119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjXCsDI3JzA0LjYiUyA0OcKwMTQnMDEuOCJX!5e0!3m2!1spt-BR!2sbr!4v1623191654981!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>

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
  <script type="text/javascript" src="js/graphs.js"></script>

</body>

</html>
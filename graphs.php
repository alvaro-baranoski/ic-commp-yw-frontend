<?php
// Add these lines in case of error 500 problems
ini_set('max_execution_time', '256'); //max_execution_time','0' <- unlimited time
ini_set('memory_limit', '512M');

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = $_GET['action'];
	$pmu = (isset($_GET['pmu']) && !empty($_GET['pmu']) ? $_GET['pmu'] : "");
	$time_window = (isset($_GET['time_w']) && !empty($_GET['time_w']) ? $_GET['time_w'] : "");
	$sample_frequency = (isset($_GET['sample_freq']) && !empty($_GET['sample_freq']) ? $_GET['sample_freq'] : "");
	$order = (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : "");
	$filter_lower = $_GET['filter_lower'];
	$filter_higher = $_GET['filter_higher'];
	$outlier_constant = $_GET['outlier_constant'];
	$view = $_GET['view'];
	switch ($action) {
		case 'startup':
			startup(
				$pmu, 
				$time_window, 
				$sample_frequency, 
				$order,
				$filter_lower,
				$filter_higher,
				$outlier_constant,
				$view
			);
			break;
	}
}

// Main function, gets data from startup.py
// TODO: Mudar o path e o interpreter do programa em python
function startup($pmu, $time_w, $sample_freq, $order, $filter_lower, $filter_higher, $outlier_constant, $view)
{

	print_r("executando função de startup \n");
	print_r($pmu + "\n");
	print_r($time_w + "\n");
	print_r($sample_freq + "\n");
	print_r($order + "\n");
	print_r($filter_lower + "\n");
	print_r($filter_higher + "\n");
	print_r($outlier_constant + "\n");
	print_r($view + "\n");

	// Execute the python script with the JSON data
	$results = shell_exec("/opt/ic-commp/bin/python3 /opt/yulewalker/main/startup.py $pmu $time_w $sample_freq $order $filter_lower $filter_higher $outlier_constant $view");

	print_r("imprimindo resultado do comando: ");

	print_r($results);
	print_r("\n");

	// $results = shell_exec("D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\\venv\Scripts\python.exe D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\main\startup.py $pmu $time_w $sample_freq $order $filter_lower $filter_higher $outlier_constant $view");

	// echo json_encode($results);

	print_r("finished");
}

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
	$view = $_GET['view'];
	switch ($action) {
		case 'startup':
			startup($pmu, $time_window, $sample_frequency, $order, $view);
			break;
	}
}

// Main function, gets data from startup.py
// TODO: Mudar o path e o interpreter do programa em python
function startup($pmu, $time_w, $sample_freq, $order, $view)
{

	// Execute the python script with the JSON data
	$results = shell_exec("/opt/ic-commp/bin/python3 /opt/yulewalker/startup.py $pmu $time_w $sample_freq $order $view");

	// $results = shell_exec("D:/Alvaro/Faculdade/2021-2/TCC/Source/ic-commp-yw-backend/venv/Scripts/python.exe D:/Alvaro/Faculdade/2021-2/TCC/Source/ic-commp-yw-backend//startup.py $pmu $time_w $sample_freq $order $view");

	echo json_encode($results);
}

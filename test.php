<?php

$res = file_get_contents("https://sirius.eletrica.ufpr.br/yulewalker/graphs.php?action=startup&pmu=cabine&time_w=60&sample_freq=15&order=20&filter_lower=0.3&filter_higher=7&outlier_constant=3.5&view=simplificada");

print_r($res);

// $pmu = "palotina";
// $time_w = 20;
// $sample_freq = 100;
// $order = 20;
// $filter_lower = 0.07;
// $filter_higher = 4;
// $outlier_constant = 5;
// $view = "complete";

// print_r("hello");

// // Execute the python script with the JSON data
// $results = shell_exec("/opt/ic-commp/bin/python3 /opt/yulewalker/main/startup.py $pmu $time_w $sample_freq $order $filter_lower $filter_higher $outlier_constant $view");

// // $results = shell_exec("D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\\venv\Scripts\python.exe D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\main\startup.py $pmu $time_w $sample_freq $order $filter_lower $filter_higher $outlier_constant $view");

// print_r($results);

// $data_results = json_decode($results, true);

// print_r(json_decode($results, true));

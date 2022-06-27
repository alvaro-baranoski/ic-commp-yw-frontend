<?php

$pmu = "palotina";
$time_w = 20;
$sample_freq = 100;
$order = 20;
$filter_lower = 0.07;
$filter_higher = 4;
$outlier_constant = 5;
$view = "simplificada";

print_r("hello");

// Execute the python script with the JSON data
$results = shell_exec("D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\\venv\Scripts\python.exe D:\Alvaro\Faculdade\TCC\Source\ic-commp-yw-backend\startup.py $pmu $time_w $sample_freq $order $filter_lower $filter_higher $outlier_constant $view");

print_r($results);

$data_results = json_decode($results, true);

print_r(json_decode($results, true));

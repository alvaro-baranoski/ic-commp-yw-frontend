<?php

$pmu = "palotina";
$time_w = 60;
$sample_freq = 15;
$order = 20;

print_r("hello");

// Execute the python script with the JSON data
$results = shell_exec("python C:\Users\alvar\Desktop\IC-COMMP\Yule-Walker\YW-backend\\startup.py $pmu $time_w $sample_freq $order");

print_r($results);

$data_results = json_decode($results, true);

print_r(json_decode($results, true));

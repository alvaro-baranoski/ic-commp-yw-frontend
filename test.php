<?php

$pmu = "cabine";
$time_w = 60;
$sample_freq = 5;
$order = 10;

// Execute the python script with the JSON data
$results = shell_exec("python C:\Users\alvar\Desktop\IC-COMMP\Yule-Walker\YW-backend\\startup.py $pmu $time_w $sample_freq $order");

$data_results = json_decode($results, true);

print_r($data_results);

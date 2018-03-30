<?php
$data = ['description' => 'Идем-ка мы в театр'];
$string = http_build_query($data);

$ch = curl_init('http://localhost/netology_home/hw_4.2/api/create.php');//дескриптор сессии
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
echo $output;
curl_close($ch); 

?>
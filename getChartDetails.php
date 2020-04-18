<?php
$curl = curl_init();
$continents = ['All', 'Europe', 'North-america', 'Asia', 'Africa', 'North-america', 'South-america'];
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://covid-193.p.rapidapi.com/statistics?",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"x-rapidapi-host: covid-193.p.rapidapi.com",
		"x-rapidapi-key: 0983bcff25msh9df47a985b40bb5p12da9ejsn71aa761e7f77"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$result = false;
header('Content-Type: application/json');
if ($err) {
	echo "cURL Error #:" . $err;
} else {
    echo $response;
}


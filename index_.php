<?php

//The resource that we want to download.
$fileUrl = 'https://s0.blogspotting.art/web-sources/475DC76CEA238433/56000/filme';
$fileUrl = 'https://s1.movies.futbol/web-sources/475DC76CEA238433/56000/filme';
$fileUrl = 'http://cdn.netcine.biz/html/content/conteudolb4/supergirl/05leg/001-ALTO.mp4?token=loFn63IgUs4fTOBR_qgQ3w&expires=1620686500&ip=177.91.60.252';

//The path & filename to save to.
$saveTo = 'logo.mp4';

//Open file handler.
$fp = fopen($saveTo, 'w+');

//If $fp is FALSE, something went wrong.
if($fp === false){
    throw new Exception('Could not open: ' . $saveTo);
}

//Create a cURL handle.
$ch = curl_init($fileUrl);

//Pass our file handle to cURL.
curl_setopt($ch, CURLOPT_FILE, $fp);

//curl_setopt($ch, CURLOPT_RANGE, '0-13500');
curl_setopt($ch, CURLOPT_REFERER, "http://cdn.netcine.info");

//Timeout if the file doesn't download after 20 seconds.
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

//Execute the request.
curl_exec($ch);

//If there was an error, throw an Exception
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

//Get the HTTP status code.
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

//Close the cURL handler.
curl_close($ch);

//Close the file handler.
fclose($fp);

if($statusCode == 200){
    echo 'Downloaded!';
} else{
    echo "Status Code: " . $statusCode;
}
<?php
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="vid.mp4"');
function mp4()
{
$ch = curl_init();
	$headers = array(
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0',
    'Referer: http://cdn.netcine.info',
    'Accept-Encoding: gzip'
);
$headers = array();
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch, CURLOPT_URL,"http://cdn.netcine.biz/html/content/conteudolb4/supergirl/05leg/001-ALTO.mp4?token=loFn63IgUs4fTOBR_qgQ3w&expires=1620686500&ip=177.91.60.252");
curl_setopt($ch, CURLOPT_POST, False);
curl_setopt($ch, CURLOPT_REFERER, "http://cdn.netcine.info");
curl_setopt($ch, CURLOPT_RANGE, '0-13500');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
return $server_output;
}
print_r(mp4());
?>
<pre>
<form>Url da série: <input type=text name=serie><input type=submit></form>
<form action="copy.php" target="_Blank">Url filme/episódio: <input type=text name=u ><input type=submit></form>
<?php

include_once("curl.php");

print_r( "Colocar no addon: <b>http://".$_SERVER["HTTP_HOST"]."/".explode ("/",$_SERVER["PHP_SELF"])[1]."</b>" );
print_r( "\n\n" );

$series='https://trailers.to/en/tvshow/705/modern-family-2009
https://trailers.to/en/tvshow/8174/the-walking-dead-2010
https://trailers.to/en/tvshow/19165/new-amsterdam-2018
https://trailers.to/en/tvshow/2086852/the-flash-2014
https://trailers.to/en/tvshow/1641/the-handmaid-s-tale-2017
https://trailers.to/en/tvshow/19159/the-good-doctor-2017';
$series = explode("\r\n", $series);

foreach ($series as $entry){
echo "<a href=\"?serie=".$entry."\">".$entry."</a>";
print_r( "\r\n");
print_r( "\r\n");
	}
 
$season=isset($_GET['season']) ? $_GET['season'] : "";
$serie=isset($_GET['serie']) ? $_GET['serie'] : "";
$epi=isset($_GET['epi']) ? $_GET['epi'] : "";
if ($serie)
{
$abre=abre($serie);
$abre = preg_replace('/\s+/i', ' ', trim($abre));
preg_match_all("/href=\"([^\"]+)\".{1,10}?(Season.\d+[^\<]+)/i", $abre, $out, PREG_PATTERN_ORDER);

for($l=0;$l<count($out[1]);$l++)
{
	//print_r( );
	echo "<a href=\"copy.php?u=https://trailers.to".$out[1][$l]."\">".$out[2][$l]."</a>";
	print_r( "\r\n");
}

//print_r($out);
}

//echo "<>";

//preg_match_all("/\<title\>(Watch )?([^\<]+)/i", $abre, $out, PREG_PATTERN_ORDER);
//$title = $out[2][0];

?>
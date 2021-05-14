<form><input type=text name=u><input type=submit></form>

<?php
set_time_limit(0);
if (ob_get_level() == 0) ob_start();
include_once("curl.php");
/**
 * Copy remote file over HTTP one small chunk at a time.
 *
 * @param $infile The full URL to the remote file
 * @param $outfile The path where to save the file
 */
 
$u=isset($_GET['u']) ? $_GET['u'] : "";
if (!$u)
	exit();
$abre=abre($u);

//echo "<>";

preg_match_all("/\<title\>(Watch )?([^\<]+)/i", $abre, $out, PREG_PATTERN_ORDER);
$title = $out[2][0];
preg_match_all("/lazy..id\=.([^\"]+)/i", $abre, $out2, PREG_PATTERN_ORDER);
$idmaster = $out2[1][0];
preg_match_all("/title\/(tt\d+)/i", $abre, $out3, PREG_PATTERN_ORDER);
//print_r($out3);
$imdb=$out3[1][0];
$title = preg_replace("/Season ?(\d+).*?Episode ?(\d+)/", "S$1E$2", $title );
print_r($title);
$external = abre("https://api.themoviedb.org/3/find/".$imdb."?api_key=bd6af17904b638d482df1a924f1eabb4&language=en-US&external_source=imdb_id");
$externalj = json_decode($external);
//print_r($externalj);
if( $externalj->tv_results )
{
	//$tmdb= abre("http://api.themoviedb.org/3/tv/".$externalj->tv_results[0]->id."?api_key=bd6af17904b638d482df1a924f1eabb4&language=pt-br");
	$tmdb = $externalj->tv_results[0]->id;
	//$tmdbj = json_decode($tmdb);
	//print_r($externalj->tv_results[0]);
	$file = "Shows/".$tmdb." ".windows($title);
	//echo $file;
}
elseif ($externalj->movie_results)
{
	$tmdb = $externalj->movie_results[0]->id;
	$file = "Movies/".$tmdb." ".windows($title);
	//echo $file;
}
//exit();

if (!$file)
	exit();

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

 
function copyfile($infile, $outfile) {
    $chunksize = 10 * (1024 * 1024); // 10 Megs

    /**
     * parse_url breaks a part a URL into it's parts, i.e. host, path,
     * query string, etc.
     */
    $parts = parse_url($infile);
    $i_handle = fsockopen($parts['host'], 80, $errstr, $errcode, 5);
    $o_handle = fopen($outfile, 'wb');

    if ($i_handle == false || $o_handle == false) {
        return false;
    }

    if (!empty($parts['query'])) {
        $parts['path'] .= '?' . $parts['query'];
    }

    /**
     * Send the request to the server for the file
     */
	 #echo "Host: {$parts['host']}\r\n";
	 #exit();
    $request = "GET {$parts['path']} HTTP/1.1\r\n";
    $request .= "Host: {$parts['host']}\r\n";
    $request .= "User-Agent: Mozilla/5.0\r\n";
    $request .= "Keep-Alive: 115\r\n";
    $request .= "Referer: http://trailers.to\r\n";
    $request .= "Connection: keep-alive\r\n\r\n";
	
    fwrite($i_handle, $request);

    /**
     * Now read the headers from the remote server. We'll need
     * to get the content length.
     */
    $headers = array();
    while(!feof($i_handle)) {
        $line = fgets($i_handle);
        if ($line == "\r\n") break;
        $headers[] = $line;
    }

    /**
     * Look for the Content-Length header, and get the size
     * of the remote file.
     */
    $length = 0;
    foreach($headers as $header) {
        if (stripos($header, 'Content-Length:') === 0) {
            //print_r($header);
            #$length = (int)str_replace('Content-Length: ', '', $header);
            $length = str_replace('Content-Length: ', '', $header);
            $length = (int)mb_substr($length, 0, -3);
            break;
        }
    }
	
//print_r("\n");
//print_r($length);
print_r("<br>");
print_r("Tamanho do arquivo: ". formatBytes(  ($length*10)) );
print_r(" - ". (  ($length*10)) );
print_r("<br>");
print_r($headers);
//exit();

    /**
     * Start reading in the remote file, and writing it to the
     * local file one chunk at a time.
     */
    $cnt = 0;
	$perf = 0;
    while(!feof($i_handle)) {
        $buf = '';
        $buf = fread($i_handle, $chunksize);
        $bytes = fwrite($o_handle, $buf);
        if ($bytes == false) {
            return false;
        }
        $cnt += $bytes/10;
		$per = round($cnt*100/($length));
		//echo $per." ".$perf;
		echo ".";
		if ($perf == $per)
		{
			echo " ".$per."% ".formatBytes(round($cnt*10))." ";
			//echo " ".$per."% ".(round($cnt*10))." ";
			$perf=$perf+1;
			//ob_get_clean();
		}
        #echo " ";
		#ob_end_clean();
        #ob_flush();

        /**
         * We're done reading when we've reached the conent length
         */
        if ($cnt >= $length) break;
    }

    fclose($i_handle);
    fclose($o_handle);
    return $cnt;
}

function windows($filename)
	{
	$bad = array_merge(
        array_map('chr', range(0,31)),
        array("<", ">", ":", '"', "/", "\\", "|", "?", "*"));
	return preg_replace("/ ?\(\d{2,4}\)/", "", str_replace($bad, "", $filename) );
	}

//echo 

//$url = "https://s1.movies.futbol/web-sources/8F684EEDC44D9328/56000/mortal-kombat-2021";
preg_match_all("/[0-9a-fA-F]{15,16}/i", $abre, $key, PREG_PATTERN_ORDER);

//print_r($key);
$key = $key[0][0];

	
//copyfile('https://s0.blogspotting.art/web-sources/475DC76CEA238433/'.($idmaster).'/file', $file.'.mp4');
//copyfile('https://s1.movies.futbol/web-sources/475DC76CEA238433/'.($idmaster).'/file', $file.'.mp4');
copyfile('https://s0.blogspotting.art/web-sources/'.$key.'/'.($idmaster).'/file', $file.'.mp4');
print_r(['https://s0.blogspotting.art/web-sources/'.$key.'/'.($idmaster).'/file'])
?>
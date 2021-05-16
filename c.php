<?php 
//ignore_user_abort(1);
set_time_limit(0);
ini_set('memory_limit', '20000M');
if (ob_get_level() == 0) ob_start();
date_default_timezone_set('America/Sao_Paulo');
/**
   * Download a large distant file to a local destination.
   *
   * This method is very memory efficient :-)
   * The file can be huge, PHP doesn't load it in memory.
   *
   * /!\ Warning, the return value is always true, you must use === to test the response type too.
   *
   * @author dalexandre
   * @param string $url
   *    The file to download
   * @param ressource $dest
   *    The local file path or ressource (file handler)
   * @return boolean true or the error message
   */
  function downloadDistantFile($url, $dest)
  {
    $options = array(
      CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_URL => $url,
	  CURLOPT_REFERER => "http://trailers.to",
      CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);

    if ($return === false)
    {
		echo "1";
      return curl_error($ch);
    }
    else
    {
      return true;
    }
  }
  
echo downloadDistantFile("https://s0.blogspotting.art/web-sources/9227067C5EC2513E/3100059/file","Shows/60735 S7E1.mp4");
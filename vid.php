<?php
header('Content-Type: application/octet-stream');
//header('Content-Disposition: attachment; filename="vid.mp4"');

  /**
     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
     * array containing the HTTP server response header fields and content.
     */
$u=isset($_GET['u']) ? $_GET['u'] : "https://s0.blogspotting.art/web-sources/475DC76CEA238433/56000/filme";
//$u=preg_replace("/a/i", "", $_SERVER['REQUEST_URI']);
//echo $u;
    function abre( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            //CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
           // CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => 0,    // don't return headers
            CURLOPT_FOLLOWLOCATION => false,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            //CURLOPT_AUTOREFERER    => false,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLOPT_HTTPHEADER     => array("Referer: https://trailers.to"),
			CURLOPT_RANGE          => '11133500-22267000',
			CURLOPT_REFERER        => ""
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
		//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: __cfduid=d9f8f3cd2d8709ad9386b1ed4311c0e551535378602; PHPSESSID=ljdth0mja5r3mgkgrotps57kf2"));
		
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
		//file_put_contents("test.mp4", "a".$header['content']);
        return $header['content'];
    }
	$f = abre ($u);
print_r( $f);
?>
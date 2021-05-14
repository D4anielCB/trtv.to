<?php

  /**
     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
     * array containing the HTTP server response header fields and content.
     */
    function abre( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/'.rand(1, 999).'.'.rand(1, 99);

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            //CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
           // CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => 1,     // return web page
            CURLOPT_HEADER         => 0,    // don't return headers
            CURLOPT_FOLLOWLOCATION => false,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            //CURLOPT_AUTOREFERER    => false,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLOPT_HTTPHEADER     => array("Cookie: PHPSESSID=ljdth0mja5r3mgkgrotps57kf2"),
			CURLOPT_REFERER        => "https://www.ultratfm.com/instagram/campanha.php?data=player3/serverf4player.php?vid=JRSCWRLDRNOAMCDO"
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
        return $header['content'];
    }
//echo get_web_page ('http://www.redecanais.net/o-poderoso-chefinho-legendado-2017-1080p_5f433647a.html');
?>
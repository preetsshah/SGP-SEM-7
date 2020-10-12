<?php

    $url = "https://api.foursquare.com/v2/venues/explore?client_id=TWA5HU3UNSLLTKEGJBAISOCFKV0FMYMUGHYWFLXJN1RWRKES&client_secret=QLXVXVCEYLBMEGVMHOF3F2JVGBYHPHFC5YMPEVIN03OYLCEQ&v=20180323&limit=1&ll=40.7243,-74.0018&query=coffee";
    $json = file_get_contents($url);
    $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);
    echo $json_pretty;
    //$elements = json_decode($json);
    //echo var_dump($elements);

?>
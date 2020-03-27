<?php
    if (substr_count($_SERVER['QUERY_STRING'], 'control')>0)
    {
        $QUERY_STRING = $_SERVER['QUERY_STRING'];
        $querys = explode('&',$QUERY_STRING);
        preg_match("/(?<=\=).*/", $querys[0],$controller_name_for_URI);
        $REDIRECT_URL = $_SERVER['REDIRECT_URL'];
        $new_URL = $REDIRECT_URL.$controller_name_for_URI[0];
        $new_URL = urldecode($new_URL);
        header("Location: $new_URL");
    }

    require_once 'bootstrap.php';

?>
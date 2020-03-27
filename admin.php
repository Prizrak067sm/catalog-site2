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


/*
foreach ($_SERVER as $key=>$value)
{
    echo $key.' => '.$value;
    echo '<br>';

}
*/
//echo $querys[0];



/*

echo 'REQUEST_URI     -   '.$_SERVER['REQUEST_URI'];
echo "<br>";
echo 'SCRIPT_NAME     -   '.$_SERVER['SCRIPT_NAME'];
echo "<br>";
echo 'SCRIPT_FILENAME     -   '.$_SERVER['SCRIPT_FILENAME'];

echo "<br>";

echo "admin.php";
echo '........myVar: '.$_SERVER['myVar'];
echo '........myVar2: '.$_SERVER['myVar2'].'--------';
echo $_SERVER['HTTP_REFERER'];


*/
?>
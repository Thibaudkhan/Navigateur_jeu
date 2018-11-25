<?php

// DEC to Hex (1 byte)
function decHex1Byte($d)
{
    $h = dechex($d);
    if($d < 16)
    {
        $h = "0".$h;
    }
    return $h;
}

// Get #rrggbb colors from percent value (color from Red to yellow to green)
function getRGBFromPercent($p) 
{
    $r = intval(255*min(1,(100-$p)/50));
    $g = intval(255*min($p/50,1));
    return "#" . decHex1Byte($r) . decHex1Byte($g) ."00";
}

// Init session variables
session_start();
if(!isset($_SESSION['r']))
{
    $_SESSION['r'] = 0;
}
if(!isset($_SESSION['g']))
{
    $_SESSION['g'] = 0;
}
if(!isset($_SESSION['b']))
{
    $_SESSION['b'] = 0;
}

// update session variables to remember the color of the text between two calls
$_SESSION['r'] = ($_SESSION['r']+3)%256;
$_SESSION['g'] = ($_SESSION['g']+5)%256;
$_SESSION['b'] = ($_SESSION['b']+7)%256;

// create array with parameters inside
$out = array();
$out["date"]      = date( "Y-m-d H:i:s", time() );
$out["color"]     = "#" . decHex1Byte($_SESSION['r']) . decHex1Byte($_SESSION['g']) . decHex1Byte($_SESSION['b']);
$perc = (100*(time()%21))/20;
$out["percent"]   = $perc; 
$out["percColor"] = getRGBFromPercent($perc);

// convert array to JSON format
$json = json_encode($out, JSON_FORCE_OBJECT);

// display JSON structure
echo $json;

?>
<?php
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: index.php');
    exit();
}

if (!empty($_GET['id']) && !empty($_GET['type']))
{   
    $id = $_GET['id'];
    if ($_GET['type'] == "avatar")
        echo getImageUser($id);
    else if($_GET['type'] == "coverimage")
        echo getCoverImage($id);
    else 
        echo getImagePost($id);
        
    $types = array('jpeg' => "\xFF\xD8\xFF", 'gif' => 'GIF', 'png' => "\x89\x50\x4e\x47\x0d\x0a", 'bmp' => 'BM', 'psd' => '8BPS', 'swf' => 'FWS');
    
    foreach ($types as $type => $header) {
        if (strpos($data, $header) === 0) {
            $found = $type;
            break;
        }
    }
    
    switch( $found ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        case "svg": $ctype="image/svg+xml"; break;
        default:
    }
    header('Cache-Control: max-age=86400');
    header('Content-type: ' . $ctype);
    echo $data;
}

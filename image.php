<?php
ini_set("display_errors", "Off");
function html2rgb($color) {
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }
    if (strlen($color) == 6) {
        list($r, $g, $b) = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array($r, $g, $b);
}

$width = 75;
$height = 70;

$image = imagecreate($width, $height);

$backgroundColor = html2rgb($_REQUEST["color1"]);

$color = imagecolorallocate($image, $backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
imagefill($image, 0, 0, $color);

if ($_REQUEST["color2"] <> '') {
    $backgroundColor = html2rgb($_REQUEST["color2"]);
    $color = imagecolorallocate($image, $backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
    imagefilledpolygon($image, array($width , $width, 0, $height, $width, 0), 3, $color);
   // imagefilledrectangle($image, $width / 2, 0, $width, $height, $color);
}

header("Content-Type: image/jpeg");
imagejpeg($image);
imagedestroy($image);
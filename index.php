<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

$query = $_GET['query'];
if( ! empty($_GET['base64']))
  $query = base64_decode($_GET['base64']);

$query = explode('/', $query);
$query = array_filter($query);

$keys = $values = array();
foreach($query as $key => $value)
{
  if($key & 1)
    $values[] = $value;
  else
    $keys[] = $value;   
}

$query = array_combine($keys, $values);

$fontPath = 'static/fonts/%s.ttf';

$fontFile = $query['family'];
if(empty($fontFile) OR ! file_exists(sprintf($fontPath, $fontFile)))
  $fontFile = 'Lobster';
$fontFile = sprintf($fontPath, $fontFile);

$text = $query['text'];
if(empty($text))
  $text = 'Dejan <3 Raska';

$text = stripslashes($text);

$color = $query['color'];
if (preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $matches))
{
  $rgb = array(
    hexdec($matches[1]),
    hexdec($matches[2]),
    hexdec($matches[3])
  );
}
else
{
  $rgb = array(
    0xCC,
    0xFF,
    0x33
  );
}

$fontSize = $query['size'];
if ( ! filter_var($fontSize, FILTER_VALIDATE_INT))
  $fontSize = 24;

$im = imagecreatetruecolor(1000, 100);
$white = imagecolorallocatealpha($im, 255, 255, 255, 127);
$color = imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
imagesavealpha($im, true);
imagealphablending($im, false);
imagefill($im, 0, 0, $white);

$dimensions = imagefttext($im, $fontSize, 0, 0, $fontSize, $color, $fontFile, $text);

$crop = imagecreatetruecolor($dimensions[2], $dimensions[1]);
imagesavealpha($crop, true);
imagealphablending($crop, false);
imagefill($crop, 0, 0, $white);

imagecopyresampled($crop, $im, 0, 0, 0, 0, $dimensions[2], $dimensions[1], $dimensions[2], $dimensions[1]);

header('Content-Type: image/png');

imagepng($crop);
imagedestroy($im);
imagedestroy($crop);

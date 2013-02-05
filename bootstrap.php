<?php

ini_set('display_errors', 1);
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_DEPRECATED & ~ E_WARNING);

setlocale(LC_ALL, "en_US.UTF-8");

require 'fonterator.php';

$query = $_GET['query'];
if (! empty($_GET['base64']))
  $query = base64_decode($_GET['base64']);

$query = trim($query, '/');
$queryString = $query;
$query = explode('/', $query);
$query = array_filter($query);

$keys = $values = array();
foreach ($query as $key => $value)
{
  if ($key & 1)
    $values[] = $value;
  else
    $keys[] = $value;
}
$query = array_combine($keys, $values);

$cache = (bool) $query['cache'];
unset($query['cache']);

$cachePath = 'static/cache/%s';
$cacheTag = sha1($queryString);
$cacheFile = sprintf($cachePath, $cacheTag) . '.png';

if (file_exists($cacheFile) and ! $query['cache'] and 1 == 0)
{
  header('Content-Type: image/png');
  readfile($cacheFile);
  exit(1);
}

$fontPath = 'static/fonts/%s.ttf';

$fontFile = $query['family'];
if (empty($fontFile) or ! file_exists(sprintf($fontPath, $fontFile)))
  $fontFile = 'Lobster';
$fontFile = sprintf($fontPath, $fontFile);

$text = $query['text'];
if (empty($text))
  $text = 'Raska';

$text = stripslashes($text);

$color = $query['color'];
if (preg_match('/^#?([0-9a-f]{6})$/i', $color, $matches))
  $rgb = $matches[1];
else
  $color = 'CC0000';

$fontSize = $query['size'];
if (! filter_var($fontSize, FILTER_VALIDATE_INT))
  $fontSize = 36;


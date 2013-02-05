<?php

require 'bootstrap.php';

$options = array
(
  'family' => $fontFile,
  'font' => $fontFile,
  'text' => $text,
  'color' => $color,
  'size' => $fontSize,
  'file' => $cacheFile,
);

if($query !== NULL)
  $options = array_merge($query, $options);

$fonterator = new Fonterator($options);
$fonterator->output();
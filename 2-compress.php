<?php

require_once 'libs/pngquant.php';

global $output_dir;
$input_dir = __DIR__ . '/INPUT';
$output_dir = __DIR__ . '/OUTPUT';


$files = glob($output_dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
foreach($files as $file) {
  file_put_contents($file, compress_png($file));
  echo "Compress: $file\n";
}

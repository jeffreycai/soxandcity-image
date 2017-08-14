<?php

require_once 'libs/wideimage/lib/WideImage.php';

global $input_dir;
global $output_dir;
$input_dir = __DIR__ . '/INPUT';
$output_dir = __DIR__ . '/OUTPUT';


$files = glob($input_dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
foreach($files as $file) {
  soxify($file); echo "\n";
}

function soxify($file) {
  try{
    $image = WideImage::load($file);
    // resize
    $image = $image->resize('1280', '1280', 'inside');
    // resize canvas
    $white = $image->allocateColor(255, 255, 255);
    $image = $image->resizeCanvas('1280', '1280', 'center', 'center');
    // water mark
    $watermark = WideImage::load(__DIR__ . '/logo.png');
    $image = $image->merge($watermark, "right - 80", "bottom - 80");
    // save file
    global $input_dir;
    global $output_dir;
    $save_path = str_replace($input_dir, $output_dir, $file);
    $tokens = explode('.', $save_path);
    $tokens[sizeof($tokens) - 1] = "png";
    $save_path = implode('.', $tokens);

    $image->saveToFile($save_path, 8, PNG_NO_FILTER);
    
    echo "Saved: $save_path\n";
  } catch (Exception $e) {
    echo "Error: $e->getMessage()";
    exit;
  }
}



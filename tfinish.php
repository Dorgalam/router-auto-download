<?php

parse_str($_SERVER['QUERY_STRING'], $query);

$folderName = $query['name'].'/';
$path = $query['dir'].'/';
$nonVideo = 0;
foreach(scandir($path.$folderName) as $file) {
  $extension = pathinfo($file)['extension'];
  if($extension != 'mp4' && $extension != 'mkv') {
    $nonVideo++;
  }
  echo $extension;
  if(($extension == 'mp4' || $extension == 'mkv') && filesize($path.$folderName.$file)/(10**6) > 100) {
    rename($path.$folderName.$file, $path.$file);
  }
}

if($nonVideo < 6) {
  delTree($path.$folderName);
}

function delTree($dir) {
   $files = array_diff(scandir($dir), array('.', '..'));
   foreach ($files as $file) {
       (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
   }
   return rmdir($dir);
}

?>

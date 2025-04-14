<?php

$targetFolder = '/home/ewowpvgx/app/storage/app/public';
$linkFolder = '/home/ewowpvgx/public_html/app.saiseyeclinics.com/storage';

if(symlink($targetFolder, $linkFolder)){
    echo 'Symlink process successfully completed';
}else{
    echo 'No link';
}

//symlink.php



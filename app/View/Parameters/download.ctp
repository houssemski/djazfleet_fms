<?php
if(file_exists($fullName))
{
   
   header('Content-Type: application/octet-stream');
  
    header('Content-disposition: attachment; filename='. $fileName);
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($fullName);
    exit();
    
}



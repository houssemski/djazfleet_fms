<?php 
      $urlf = './document_transport/'.$name;
if(file_exists($urlf))
{
   
   header('Content-Type: application/octet-stream');
  
    header('Content-disposition: attachment; filename='. $name);
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($urlf);
    exit();
    
}
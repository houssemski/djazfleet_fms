<?php
$urlf = $my_pdf;
if(file_exists($urlf))
{

   /* header('Content-Type: application/octet-stream');

    header('Content-disposition: attachment; filename= exp');
    header('Pragma: no-cache');
    header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    readfile($urlf);
    exit();*/
    header('Content-type: application/pdf');
    /*header('Content-Length: $len');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: pre-check=0, post-check=0, max-age=0');
    header('Pragma: anytextexeptno-cache', true);
    header('Cache-control: private');*/
    header('Expires: 0');
    header('Content-Disposition: inline; filename= exp');
    readfile($urlf);
    exit();
}

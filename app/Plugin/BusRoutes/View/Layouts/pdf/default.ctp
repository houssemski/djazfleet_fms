<?php require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'autoload.inc.php');
require_once(APP . 'Vendor' . DS . 'ar-php-master' . DS . 'src' . DS . 'Arabic.php');
//spl_autoload_register('DOMPDF_autoload');
use Dompdf\Dompdf;
use ArPHP\I18N\Arabic;

$dompdf = new Dompdf(array('chroot' => WWW_ROOT));
$dompdf->set_paper = 'A4';
$dompdf->set_base_path(WWW_ROOT);
$Arabic = new Arabic();

$p = $Arabic->arIdentify($content_for_layout);

for ($i = count($p)-1; $i >= 0; $i-=2) {
    $utf8ar = $Arabic->utf8Glyphs(substr($content_for_layout, $p[$i-1], $p[$i] - $p[$i-1]));
    $content_for_layout   = substr_replace($content_for_layout, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
}
$dompdf->load_html($content_for_layout, 'UTF-8');
$dompdf->render();
echo $dompdf->output();





















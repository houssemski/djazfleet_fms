<?php
class PdfsController extends AppController {
    var  $uses = null;
    var  $helpers = array('Pdf');

    function index() {
        $this->layout='pdf';
    }
}
?>
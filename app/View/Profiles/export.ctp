<?php
/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */
//declare the xls helper
$xls= new XlsHelper($this);

//input the export file name
$xls->setHeader('Profils_'.date('Y_m_d'));

$xls->addXmlHeader();
$xls->setWorkSheetName('Profils');

//1st row for columns name
$xls->openRow();
$xls->writeString('Nom');
$xls->closeRow();

//rows for data
foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['Profile']['name']);
    $xls->closeRow();
endforeach;

$xls->addXmlFooter();
exit();
<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
 $xls= new XlsHelper($this);
 
  //input the export file name
  $xls->setHeader('Catégories_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Catégories');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Code');
  $xls->writeString('Nom');
  $xls->closeRow();
   
  //rows for data
  foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['CarCategory']['code']);
    $xls->writeString($model['CarCategory']['name']);
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
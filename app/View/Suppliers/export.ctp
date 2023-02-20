<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
 $xls= new XlsHelper($this);
 
  //input the export file name
  $xls->setHeader('Suppliers_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Suppliers');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Code');
  $xls->writeString('Nom');
  $xls->writeString('Adresse');
  $xls->writeString('Téléphone');
  $xls->closeRow();
   
  //rows for data
  foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['Supplier']['code']);
    $xls->writeString($model['Supplier']['name']);
    $xls->writeString($model['Supplier']['adress']);
    $xls->writeString($model['Supplier']['tel']);
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
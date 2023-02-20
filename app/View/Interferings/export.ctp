<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
 $xls= new XlsHelper($this);
 
  //input the export file name
  $xls->setHeader('Intervenants_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Intervenants');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Code');
  $xls->writeString('Nom');
  $xls->writeString('Adresse');
  $xls->writeString('Téléphone');
  $xls->writeString('Type');
  $xls->closeRow();
   
  //rows for data
  foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['Interfering']['code']);
    $xls->writeString($model['Interfering']['name']);
    $xls->writeString($model['Interfering']['adress']);
    $xls->writeString($model['Interfering']['tel']);
    $xls->writeString($model['InterferingType']['name']);
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
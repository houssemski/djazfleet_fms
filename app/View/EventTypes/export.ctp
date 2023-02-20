<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
 $xls= new XlsHelper($this);
 
  //input the export file name
  $xls->setHeader('Types_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Types');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Code');
  $xls->writeString('Nom');
  $xls->writeString('Transaction');
  $xls->writeString('Avec km');
  $xls->writeString('Avec date');
  $xls->closeRow();
   
  //rows for data
  foreach ($models as $model):
    $xls->openRow();
    $xls->writeString($model['EventType']['code']);
    $xls->writeString($model['EventType']['name']);
    if($model['EventType']['transact_type_id'] == 1){
        $xls->writeString("Encaissement");
    }else{
        $xls->writeString("Décaissement");
    }
    
    if($model['EventType']['with_km']){
        $xls->writeString("Oui");
    }else{
        $xls->writeString("Non");
    }
    if($model['EventType']['with_date']){
        $xls->writeString("Oui");
    }else{
        $xls->writeString("Non");
    }
    $xls->closeRow();
  endforeach;
  
  $xls->addXmlFooter();
  exit();
<?php
$query = $this->Session->read('query');
extract($query);
$tableId = strtolower($tableName) . '-grid';
/** @var array $columns */
/** @var string $tableName */
?>
<!--    Content section    -->
<?= $this->element('index-body-content', array(
    "tableId" => $tableId,
    "tableName" => $tableName,
    "columns" => $columns,
));
?>
<!--    End content section    -->
<!--    DataTables Script    -->
<?= $this->element('data-tables-script', array(
    "tableId" => $tableId,
    "tableName" => $tableName,
    "columns" => $columns,
    "defaultLimit" => $defaultLimit,
));
?>
<!--    End dataTables Script    -->
	
	
<ul class="list-group m-b-15 user-list">
    <?php echo "<div class='total'><span class='col-lg-3 col-xs-6'><b>" . __('Total customer price :  ') . '</b><span class="badge bg-red">' .
        number_format($sumCostClient, 2, ",", ".") . " " . $this->Session->read('currency') . "</span> </span>";
    echo "<span class='col-lg-3 col-xs-6'><b>" . __('Total subcontractor price :  ') . '</b><span class="badge bg-red">' .
        number_format($sumCostSupplier, 2, ",", ".") . " " . $this->Session->read('currency') . "</span> </span>";
    $profit = $sumCostClient - $sumCostSupplier;
    echo "<span class='col-lg-3 col-xs-6'><b>" . __('Profit :  ') . '</b><span class="badge bg-red">' .
        number_format($profit, 2, ",", ".") . " " . $this->Session->read('currency') . "</span> </span></div>"; ?>
</ul>
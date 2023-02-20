<?php

echo "<div    class='select-inline'>" . $this->Form->input('SheetRides.customer_id', array(
                                    'label' => __("Customer"),
                                    'class' => 'form-filter select-search-customer',
                                    'empty' => '',
									'options'=>$customers,
									'value'=>$selectedid,
                                    'id' => 'customers',
                                    'onchange' => 'javascript : verifyDriverLicenseExpirationDate(), verifyMissionCustomer();'
                                )) . "</div>";
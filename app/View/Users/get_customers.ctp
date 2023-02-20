
<?php

if($profileId == ProfilesEnum::client){ ?>

        <div class="form-group">
            <div class="input select required">
                <label for="suppliers"><?= __("Client") ?></label>
                <select name="data[User][supplier_id]" class="form-control select-search-client-initial" id="suppliers" required="required" >
                    <option value=""><?= __('Select ') . " " . __("Client") ?></option>

                </select>
            </div>
        </div>



<?php

    echo "<div class='form-group'>" . $this->Form->input('User.service_id', array(
            'label' => __('Service'),
            'class' => 'form-control select3',
            'options'=>$services,
            'empty' => '',
        )) . "</div>";

}else {

    echo "<div class='form-group'>" . $this->Form->input('User.service_id', array(
            'label' => __('Service'),
            'class' => 'form-control select3',
            'options'=>$services,
            'empty' => '',
        )) . "</div>";
}

 echo "<div class='form-group chk'>" . $this->Form->input('User.receive_notification', array(
            'label' => __('Receive notification'),
            'class' => 'form-control',
        )) . "</div>";



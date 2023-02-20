<?php if($typeAdd=='addEvent')  { ?>
    <div class="input select required">
        <label for="type"><?= __('Event type') ?></label>
        <select name="data[Event][event_type_id]" class="form-control select2" id="type" required="required">
            <option value=""></option>

            <?php
            foreach ($selectbox as $type) {
                if($selectedid == $type['EventType']['id']){
                    echo '<option value="'.$type['EventType']['id'].'" selected>'.$type['EventType']['name'].'</option>'."\n";
                }else{
                    echo '<option value="'.$type['EventType']['id'].'">'.$type['EventType']['name'].'</option>'."\n";
                }
            }
            ?>
        </select>
    </div>


<?php } else { ?>
    <div class="input select required">
        <label for="type"><?= __('Event type') ?></label>
        <select name="data[Event][event_type_id]" class="form-control select2" id="type" required="required" multiple="multiple">
            <option value=""></option>

            <?php
            foreach ($selectbox as $type) {
                if($selectedid == $type['EventType']['id']){
                    echo '<option value="'.$type['EventType']['id'].'" selected>'.$type['EventType']['name'].'</option>'."\n";
                }else{
                    echo '<option value="'.$type['EventType']['id'].'">'.$type['EventType']['name'].'</option>'."\n";
                }
            }
            ?>
        </select>
    </div>


<?php } ?>



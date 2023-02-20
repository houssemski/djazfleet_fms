<?php
if ($sheetRideDetailRideId != null) {
    $j = 0;

    foreach ($attachmentTypes as $attachmentType) {


        if (isset($attachments[$j]) &&
            ($attachments[$j]['Attachment']['attachment_type_id'] == $attachmentType['AttachmentType']['id'])
        ) {
            ?>
            <div id=<?php echo $attachmentType['AttachmentType']['id'] ?>-file class="col-md-12">

                <?php
                echo "<div class='form-group input-button2 input-file'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'] . '.attachment_number', array(
                        'label' => __('Number') . ' ' . $attachmentType['AttachmentType']['name'],
                        'class' => 'form-control ',
                        'value' => $attachments[$j]['Attachment']['attachment_number'],
                        'empty' => ''
                    )) . "</div>";
                echo "<div  style='Display:none;'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'], array(

                        'class' => 'form-cont',
                        'id' => 'attachment' . $attachmentType['AttachmentType']['id'],
                        'type' => 'file',
                        'empty' => ''
                    )) . "</div>";
                $input = $attachmentType['AttachmentType']['id'];
                echo "<div class='input-button4 m-t-5 input-file' >" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.file' . $attachmentType['AttachmentType']['id'], array(
                        'label' => $attachmentType['AttachmentType']['name'],
                        'readonly' => true,
                        'id' => 'file' . $attachmentType['AttachmentType']['id'],
                        'value' => $attachments[$j]['Attachment']['name'],
                        'class' => 'form-control',


                    )) . '</div>';
                echo "<div class='button-file'>" . $this->Html->link('<i class="fa fa-folder-open m-r-5"></i>' . __('Browse', true),

                        'javascript:chooseFile(' . $attachmentType["AttachmentType"]["id"] . ');',
                        array('escape' => false, 'class' => 'btn btn-default btn-trans waves-effect waves-default w-md m-b-5 ', 'id' => 'upfile' . $attachmentType['AttachmentType']['id'],
                        )) . '</div>';
                ?>
                <span class="popupactions">
                 <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                         id=<?php echo $attachmentType['AttachmentType']['id'] ?>-btn
                         type="button" onclick="delete_file('<?php echo $input ?>');"><i
                         class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
            </span>

                <div class="clear:both"></div>
            </div>
            <?php
            $j++;
        } else {

            ?>


            <div id=<?php echo $attachmentType['AttachmentType']['id'] ?>-file class="col-md-12">


                <?php
                echo "<div class='form-group input-button2 input-file'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'] . '.attachment_number', array(
                        'label' => __('Number') . ' ' . $attachmentType['AttachmentType']['name'],
                        'class' => 'form-control ',

                        'empty' => ''
                    )) . "</div>";

                echo "<div class='form-group input-button2 input-file'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'], array(
                        'label' => $attachmentType['AttachmentType']['name'],
                        'class' => 'form-control filestyle',
                        'type' => 'file',
                        'empty' => ''
                    )) . "</div>";
                $input = $attachmentType['AttachmentType']['id'];
                ?>
                <span class="popupactions">
                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                                        id=id=<?php echo $attachmentType['AttachmentType']['id'] ?>-btn type="button"
                                        onclick="delete_file('<?php echo $input ?>');"><i
                                        class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
            </div>
        <?php
        }

    }
} else {
    if (!empty($attachmentTypes)) {

        foreach ($attachmentTypes as $attachmentType) {
            ?>
            <div id=<?php echo $attachmentType['AttachmentType']['id'] ?>-file class="col-md-12">
                <?php

                echo "<div class='form-group input-button2 input-file'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'] . '.attachment_number', array(
                        'label' => __('Number') . ' ' . $attachmentType['AttachmentType']['name'],
                        'class' => 'form-control ',

                        'empty' => ''
                    )) . "</div>";

                echo "<div class='form-group input-button2 input-file'>" . $this->Form->input('SheetRideDetailRides.' . $i . '.Attachment.' . $attachmentType['AttachmentType']['id'], array(
                        'label' => $attachmentType['AttachmentType']['name'],
                        'class' => 'form-control filestyle',
                        'type' => 'file',
                        'empty' => ''
                    )) . "</div>";
                $input = $attachmentType['AttachmentType']['id'];
                ?>
                <span class="popupactions">
                                <button class="btn btn-danger btn-trans waves-effect w-md waves-danger m-b-5 btn-marg "
                                        id=<?php echo $attachmentType['AttachmentType']['id'] ?>-btn type="button"
                                        onclick="delete_file('<?php echo $input ?>');"><i
                                        class="fa fa-repeat m-r-5"></i><?= __('Empty') ?></button>
                                </span>
            </div>
        <?php

        }
    }
}


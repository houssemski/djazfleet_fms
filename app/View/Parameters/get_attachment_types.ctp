<?php
$i = 0;
foreach ($attachmentTypes as $attachmentType) {
    if (isset($parameterAttachmentTypes[$i]) && ($parameterAttachmentTypes[$i]['ParameterAttachmentType']['attachment_type_id'] == $attachmentType['AttachmentType']['id'])) {
        echo "<div class='form-group'>" . $this->Form->input('ParameterAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                'label' => $attachmentType['AttachmentType']['name'],
                'class' => 'form-control ',
                'checked' => true,
                'type' => 'checkbox',
                'empty' => ''
            )) . "</div>";
        $i++;
    } else {
        echo "<div class='form-group'>" . $this->Form->input('ParameterAttachmentType.' . $attachmentType['AttachmentType']['id'], array(
                'label' => $attachmentType['AttachmentType']['name'],
                'class' => 'form-control ',
                'type' => 'checkbox',
                'empty' => ''
            )) . "</div>";
    }
}

?>
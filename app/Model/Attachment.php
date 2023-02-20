<?php

App::uses('AppModel', 'Model');

/**
 * Affiliate Model
 *
 *
 */
class Attachment extends AppModel
{

    /**
     * Display field
     *
     * @var string
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array();

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */


    public function getAttachmentsBySheetRideDetailRideId($sheetRideDetailRideId = null)
    {
        $attachments = $this->find('all',
            array(
                'conditions' => array('Attachment.article_id' => $sheetRideDetailRideId),
                'order' => 'Attachment.attachment_type_id',
                'fields' => array('Attachment.name', 'Attachment.attachment_type_id', 'Attachment.attachment_number','Attachment.article_id'),
               'recursive'=>-1
            ));
        return $attachments;
    }

    public function getAttachmentsBySheetRideId($sheetRideId = null)
    {
        $attachments = $this->find('all',
            array(
                'conditions' => array('SheetRideDetailRide.sheet_ride_id' => $sheetRideId),
                'order' => 'SheetRideDetailRide.id ASC',
                'fields' => array('Attachment.name','Attachment.validation',
                    'SheetRideDetailRide.reference','Attachment.id',
                    'Attachment.attachment_type_id', 'AttachmentType.name',
                    'Attachment.attachment_number','Attachment.article_id'),
                'joins' => array(
                    array(
                        'table' => 'attachment_types',
                        'type' => 'left',
                        'alias' => 'AttachmentType',
                        'conditions' => array('Attachment.attachment_type_id = AttachmentType.id')
                    ),

                    array(
                        'table' => 'sheet_ride_detail_rides',
                        'type' => 'left',
                        'alias' => 'SheetRideDetailRide',
                        'conditions' => array('Attachment.article_id = SheetRideDetailRide.id')
                    ),
                )
            ));
        return $attachments;
    }

    public function deleteAttachmentByType($path, $id = null)
    {

        $path = dirname(__DIR__) . DS . "webroot" . DS . $path;
        $attachment = $this->find('first', array('conditions' => array('Attachment.id' => $id)));
        $attachmentName = $attachment['Attachment']['name'];
        if (!empty($attachmentName)) {
            if ($dossier = opendir($path)) {
                while (false !== ($fichier = readdir($dossier))) {
                    if ($fichier == $attachmentName) {
                        unlink('' . $path . $attachmentName . '');
                    } // On ferme le if (qui permet de ne pas afficher index.php, etc.)
                }
                closedir($dossier);
            } else {
                echo 'Le dossier n\' a pas pu être ouvert';
            }


        }

    }

}

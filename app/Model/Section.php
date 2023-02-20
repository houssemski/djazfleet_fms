<?php
App::uses('AppModel', 'Model');
/**
 * Mark Model
 *
 * @property Action $Action
 */
class Section extends AppModel {


    public $displayField = 'name';

    public $hasMany = array(
        'InterfaceAction' => array(
            'className' => 'SectionAction',
            'foreignKey' => 'section_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Get Sections
     *
     * @param array|null $fields
     * @param string|null $typeSelect
     * @param int|null $recursive
     *
     * @return array $sections
     */
    public function getSections($fields = null, $typeSelect = null, $recursive = null)
    {
        if (empty($typeSelect)) {
            $typeSelect = "list";
        }
        if (empty($fields)) {
            $fields = array('Section.id', 'Section.name');
        }
        if (empty($recursive)) {
            $recursive = -1;
        }
        $sections = $this->find(
            $typeSelect,
            array(
                'fields' => $fields,
                'conditions' => array('Section.has_attachments = 1'),
                'order' => 'Section.sub_module_id ASC, Section.id ASC',
                'recursive' => $recursive
            )
        );
        return $sections;
    }

    /**
     * Get Section by id
     *
     * @param int $sectionId
     *
     * @return array $section
     */
    public function getSectionById($sectionId)
    {
        $section = $this->find(
            "first",
            array(
                'conditions' => array('Section.id' => $sectionId),
                'recursive' => -1
            )
        );
        return $section;
    }

    public function getSectionsBySubModule($subModuleId)
    {
        $sections = $this->find(
            "all",
            array(
                'conditions' => array('Section.sub_module_id' => $subModuleId),
                'recursive' => -1
            )
        );
       /*

        if(!empty($sections)){
            $sectionIds ='(';
            $countSections = count($sections);
            $i =1;
            foreach ($sections as $section){
                if($i==$countSections){
                    $sectionIds = $sectionIds.$section['Section']['id'];
                }else {
                    $sectionIds = $sectionIds.$section['Section']['id'].',';
                }
               $i++;
            }
            $sectionIds = $sectionIds.')';
        }*/
        $sectionIds = array();
       if(!empty($sections)){
           foreach ($sections as $section){
               $sectionIds[]= $section['Section']['id'];
           }
       }
        return $sectionIds;
    }

}
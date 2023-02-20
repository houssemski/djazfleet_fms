<?php if (isset($this->params['pass']['1'])){

$i=$this->params['pass']['1'];


    echo "<div  id='Leasing<?php echo $i ?>'>" . $this->Form->input('Leasing.supplier_id', array(
            'label' => __('Supplier'),
            'class' => 'form-control select2',
            'options'=>$selectbox,
            'selected'=>$selectedid,
            'empty' => ''
        )) . "</div>";
 } else {

    echo "<div  >" . $this->Form->input('Car.supplier_id', array(
            'label' => __('Supplier'),
            'class' => 'form-control select2',
            'options'=>$selectbox,
            'selected'=>$selectedid,
            'empty' => ''
        )) . "</div>";
}
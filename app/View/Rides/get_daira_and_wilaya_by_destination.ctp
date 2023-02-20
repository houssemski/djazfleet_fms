<?php
if ($id == 'departure_destination'){
    if(!empty($dairas)){
        echo "<div class='form-group'>".$this->Form->input('Ride.departure_daira_id', array(
                'label' => __('Departure daira'),
                'empty' =>'',
                'id'=>'departure_daira',
                'options' =>$dairas,
                'value'=>$dairaId,
                'class' => 'form-control select2',
            ))."</div>";
    }else {
        echo "<div class='form-group'>".$this->Form->input('Ride.departure_daira_id', array(
                'label' => __('Departure daira'),
                'empty' =>'',
                'id'=>'departure_daira',

                'class' => 'form-control select2',
            ))."</div>";
    }
if(!empty($wilayas)){
    echo "<div class='form-group'>".$this->Form->input('Ride.departure_wilaya_id', array(
            'label' => __('Departure wilaya'),
            'empty' =>'',
            'id'=>'departure_wilaya',
            'options' =>$wilayas,
            'value'=>$wilayaId,
            'class' => 'form-control select2',
        ))."</div>";
}else {
    echo "<div class='form-group'>".$this->Form->input('Ride.departure_wilaya_id', array(
            'label' => __('Departure wilaya'),
            'empty' =>'',

            'class' => 'form-control select2',
        ))."</div>";
}

}else {

    if(!empty($dairas)){
        echo "<div class='form-group'>".$this->Form->input('Ride.arrival_daira_id', array(
                'label' => __('Arrival daira'),
                'empty' =>'',
                'id'=>'arrival_daira',
                'options' =>$dairas,
                'value'=>$dairaId,
                'class' => 'form-control select2',
            ))."</div>";
    }else {
        echo "<div class='form-group'>".$this->Form->input('Ride.arrival_daira_id', array(
                'label' => __('Arrival daira'),
                'empty' =>'',
                'id'=>'arrival_daira',
                'class' => 'form-control select2',
            ))."</div>";
    }
  if(!empty($wilayas)){
      echo "<div class='form-group'>".$this->Form->input('Ride.arrival_wilaya_id', array(
              'label' => __('Arrival wilaya'),
              'empty' =>'',
              'id'=>'arrival_wilaya',
              'options' =>$wilayas,
              'value'=>$wilayaId,
              'class' => 'form-control select2',
          ))."</div>";
  }else {
      echo "<div class='form-group'>".$this->Form->input('Ride.arrival_wilaya_id', array(
              'label' => __('Arrival wilaya'),
              'empty' =>'',
              'id'=>'arrival_wilaya',
              'class' => 'form-control select2',
          ))."</div>";
  }


}
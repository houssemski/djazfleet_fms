<?php
$this->start('css');
echo $this->Html->css('fullcalendar.min');
$this->end();
?>
<h4 class="page-title"> <?=__('Calendrier'); ?></h4>
<div class="box-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card-box p-b-20">

            <div id="calendar"></div>
                <br><br>
                </div>
        </div>



    </div>
    </div>

<?php $this->start('script'); ?>
<?= $this->Html->script('moment.min.js'); ?>
<?= $this->Html->script('jquery-2.1.4.min.js'); ?>

<?= $this->Html->script('fullcalendar.min.js'); ?>
<script type="text/javascript">
    jQuery(function($) {
        /* initialize the calendar
         -----------------------------------------------------------------*/

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

 var calendar = $('#calendar').fullCalendar({
            //isRTL: true,
            //firstDay: 1,// >> change first day of week

            buttonHtml: {
                prev: '<i class="ace-icon fa fa-chevron-left"></i>',
                next: '<i class="ace-icon fa fa-chevron-right"></i>'
            },

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth,listYear,listWeek,listDay'
            },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
            <?php

            foreach($sheetRides as $sheetRide) { ?>
                {

                    id : <?php echo $sheetRide['SheetRide']['id'] ?>,
                    title: '<?php echo $sheetRide['Car']['code'].' '.$sheetRide['Carmodel']['name'].' '.$sheetRide['Customer']['first_name'].' ' .$sheetRide['Customer']['last_name']?>',
                    <?php
                    if(!empty($sheetRide['SheetRide']['real_start_date'])){
                    $dateStart = date_parse($sheetRide['SheetRide']['real_start_date']);
                    }else {
                    $dateStart = date_parse($sheetRide['SheetRide']['start_date']);
                    }
                    $dayStart = $dateStart['day'];
                    $monthStart = $dateStart['month']-1;
                    $yearStart = $dateStart['year'];
                    $hourStart = $dateStart['hour'];
                    $minuteStart = $dateStart['minute'];

                    if(!empty($sheetRide['SheetRide']['real_end_date'])){
                    $dateEnd = date_parse($sheetRide['SheetRide']['real_end_date']);
                    }else {
                    $dateEnd = date_parse($sheetRide['SheetRide']['end_date']);
                    }
                    $dayEnd = $dateEnd['day'];
                    $monthEnd = $dateEnd['month']-1;
                    $yearEnd = $dateEnd['year'];
                    $hourEnd = $dateEnd['hour'];
                    $minuteEnd = $dateEnd['minute'];
                    ?>
                    start: new Date(<?php echo $yearStart ; ?>, <?php echo $monthStart ; ?>, <?php echo $dayStart ; ?>,<?php echo $hourStart ; ?>,<?php echo $minuteStart ; ?> ),
                    end : new Date(<?php echo $yearEnd ; ?>, <?php echo $monthEnd ; ?>,<?php echo $dayEnd ; ?>,<?php echo $hourEnd ; ?>,<?php echo $minuteEnd ; ?>),
                    className: 'label-success'
                },

        <?php  } ?>

        ],




            /**eventResize: function(event, delta, revertFunc) {

			alert(event.title + " end is now " + event.end.format());

			if (!confirm("is this okay?")) {
				revertFunc();
			}

		},*/

            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(date) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                var $extraEventClass = $(this).attr('data-class');


                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = false;
                if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            }
            ,
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {

                bootbox.prompt("New Event Title:", function(title) {
                    if (title !== null) {
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay,
                                className: 'label-info'
                            },
                            true // make the event "stick"
                        );
                    }
                });


                calendar.fullCalendar('unselect');
            }
            ,
            eventClick: function(calEvent, jsEvent, view) {
                alert('Event: ' + calEvent.id);
                var idSheetRide = calEvent.id;
                window.location = '<?php echo $this->Html->url('/sheetRides/edit/')?>' + idSheetRide;

            }

        });


    })
</script>




</script>
<?php $this->end(); ?>

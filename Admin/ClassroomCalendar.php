<?php

require_once '../includes/dbconfig.php';

$user->is_loggedin();
$user->isAdmin();

$classroomId = $_GET['classroomID'];



//echo json_encode(array('classroomID'=>$classroomId));

//echo $classroomId;

if (isset($_POST['NewEventAdd'])){
  $eventDesc = $_POST['eventDesc'];
  $start = $_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
  $end =   $_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];

 $calendar->setNewClassroomEvent($classroomId, $eventDesc, $start, $end, $roleNo, 'false');
}


?>

<script>

var classroomID = "<?php echo $classroomId; ?>";

</script>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
 <head>
<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Select2 -->
      <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
                                                          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
-->
    
    <!-- custom css-->
    <link rel="stylesheet" href="../custom/custom_style.css">

     
    <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
<meta charset='utf-8' />

<!-- jQuery 2.1.4 -->
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Bootstrap 3.3.5 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link href='../plugins/calendar/assets/css/fullcalendar.css' rel='stylesheet' />
<link href='../plugins/calendar/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../plugins/calendar/assets/js/moment.min.js'></script>

<script src='../plugins/calendar/assets/js/jquery-ui.min.js'></script>
<script src='../plugins/calendar/assets/js/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {

		var zone = "05:30";  //Change this to your timezone

	$.ajax({
		url: '../plugins/calendar/ProcessClass.php',
        type: 'POST', // Send post data
        data: 'type=fetch&ClassroomID='+classroomID+'',
        async: false,
        success: function(s){
        	json_events = s;
        }
	});


	var currentMousePos = {
	    x: -1,
	    y: -1
	};
		jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			utc: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			droppable: true, 
			slotDuration: '00:30:00',
			eventReceive: function(event){
				var title = event.title;
				var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
				$.ajax({
		    		url: '../plugins/calendar/ProcessClass.php',
		    		data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone+'&ClassroomID='+classroomID,
		    		type: 'POST',
		    		dataType: 'json',
		    		success: function(response){
		    			event.id = response.eventid;
		    			$('#calendar').fullCalendar('updateEvent',event);
		    		},
		    		error: function(e){
		    			console.log(e.responseText);

		    		}
		    	});
				$('#calendar').fullCalendar('updateEvent',event);
				console.log(event);
			},
			eventDrop: function(event, delta, revertFunc) {
		        var title = event.title;
		        var start = event.start.format();
		        var end = (event.end == null) ? start : event.end.format();
		        $.ajax({
					url: '../plugins/calendar/ProcessClass.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
		    },
		    eventClick: function(event, jsEvent, view) {
		    	console.log(event.id);
		          var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
		          if (title){
		              event.title = title;
		              console.log('type=changetitle&title='+title+'&eventid='+event.id);
		              $.ajax({
				    		url: '../plugins/calendar/ProcessSchool.php',
				    		data: 'type=changetitle&title='+title+'&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){	
				    			if(response.status == 'success')			    			
		              				$('#calendar').fullCalendar('updateEvent',event);
				    		},
				    		error: function(e){
				    			alert('Error processing your request: '+e.responseText);
				    		}
				    	});
		          }
			},
			eventResize: function(event, delta, revertFunc) {
				console.log(event);
				var title = event.title;
				var end = event.end.format();
				var start = event.start.format();
		        update(title,start,end,event.id);
		    },
			eventDragStop: function (event, jsEvent, ui, view) {
			    if (isElemOverDiv()) {
			    	var con = confirm('Are you sure to delete this event permanently?');
			    	if(con == true) {
						$.ajax({
				    		url: '../plugins/calendar/ProcessClass.php',
				    		data: 'type=remove&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){
				    			console.log(response);
				    			if(response.status == 'success'){
				    				$('#calendar').fullCalendar('removeEvents');
            						getFreshEvents();
            					}
				    		},
				    		error: function(e){	
				    			alert('Error processing your request: '+e.responseText);
				    		}
			    		});
					}   
				}
			}
		});

	function getFreshEvents(){
		$.ajax({
			url: '../plugins/calendar/ProcessClass.php',
	        type: 'POST', // Send post data
	        data: 'type=fetch',
	        async: false,
	        success: function(s){
	        	freshevents = s;
	        }
		});
		$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
	}


	function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }

	});

</script>
<style>


	#trash{
		width:32px;
		height:40px;
		float:left;
		padding-bottom: 15px;
		position: relative;
        margin-left:30%;
	}
		
	#wrap {
		width: 1100px;
		margin: 20px auto;
        
	}
		
	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
	
		text-align: left;
        height:190px;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		float: right;
		width: 900px;
	}

</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">

 


 <div class="">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">

          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->

<?php
          include_once '../includes/navbar_left.php';
          include_once '../includes/navbar_right.php';

?>


        </nav>
      </header>

</div>

    
<?php

  include_once '../includes/sidebar.php';

?>



  <!--add news modal -->
  <div class="example-modal">
    <div class="modal fade " id="addEvent">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add Event</h4>
          </div>
          <div class="modal-body">
            <form  method="post">

              <div class="form-group">
                <label for="usr">Event description:</label>
                <textarea class="form-control" rows="10" style="resize: none;" placeholder="Please enter your event details here..." maxlength="255" name="eventDesc" required="required"></textarea>
              </div>

              <div class="form-group">
                <label>Start Date:</label>
                <div class="input-group">
            <?php make_calendar_pulldownsStart(); ?>
                </div><!-- /.input group -->
              </div><!-- /.form group -->

              <div class="form-group">
                <label>End Date:</label>
                <div class="input-group">
                 <?php make_calendar_pulldownsEnd(); ?>
                </div><!-- /.input group -->
              </div><!-- /.form group -->

              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" name="NewEventAdd">Add</button>
              </div>
            </form>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
    <!-- /.example-modal -->
</div>
 
      <div class="row">
      
            <div class="col-md-10 pull-right">
            
	

		<div id='external-events'>
			<h4>Draggable Events</h4>
			<div class='fc-event btn btn-primary'><i class="fa fa-calendar"></i> New Event</div>
			<p>
				<img src="../plugins/calendar/assets/img/trashcan.png" id="trash" alt="" height="50px">
			</p>
        
          <br clear="all" />
             
                      <hr />
                     
                       <a class="btn btn-primary fc-event" data-toggle="modal"
                     data-target="#addEvent">
                    <i class="fa fa-calendar"></i> Add Event
                  </a>
 
		</div>

	<!--	<div id='calendar'></div>-->
      <!-- Calendar -->
              <div class="">
           
                <div class="box-body no-padding">
                  <!--The calendar -->
                        <div id='calendar'></div>
                </div><!-- /.box-body -->

		<div style='clear:both'></div>

	

	</div>

</div>
     
     </div>
   <!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
v1.0.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2015 <a href="http://bubblepoint.ryepeg.ie/">Ryepeg Software Systems. </a></strong>  All rights reserved.
</footer>
 <?php
    function make_calendar_pulldownsStart() {

      // Make the months array:
      $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');



      // Make the days pull-down menu:
      echo '<select required="required" name="start_day" id="day" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Day</option>\n';
      for ($day = 1; $day <= 31; $day++) {
        echo "<option value=\"$day\">$day</option>\n";
      }
      echo '</select>';


// Make the months pull-down menu:
      //echo '<p><label for="dob" style="font-family: Verdana, Arial; font-size: 1.0em; font-weight: 600; color: #595959; line-height: 1.9em;">Date of Birth</label></p>';
      echo '<select required="required" name="start_month" id="month" style="width: 33%; display: inline; float: left; margin-left: 1%; margin-right: 0%">';
      echo '<option selected value="">Month</option>\n';
      foreach ($months as $key => $value) {
        echo "<option value=\"$key\" >$value</option>\n";
      }
      echo '</select>';


      // Make the years pull-down menu:
      echo '<select required="required" name="start_year" id="year" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Year</option>\n';
      for ($year = 2015; $year <= 2030; $year++) {
        echo "<option value=\"$year\">$year</option>\n";
      }
      echo '</select>';
    }


    function make_calendar_pulldownsEnd() {

      // Make the months array:
      $months = array (1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');



      // Make the days pull-down menu:
      echo '<select required="required" name="end_day" id="day" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Day</option>\n';
      for ($day = 1; $day <= 31; $day++) {
        echo "<option value=\"$day\">$day</option>\n";
      }
      echo '</select>';


// Make the months pull-down menu:
      //echo '<p><label for="dob" style="font-family: Verdana, Arial; font-size: 1.0em; font-weight: 600; color: #595959; line-height: 1.9em;">Date of Birth</label></p>';
      echo '<select required="required" name="end_month" id="month" style="width: 33%; display: inline; float: left; margin-left: 1%; margin-right: 0%">';
      echo '<option selected value="">Month</option>\n';
      foreach ($months as $key => $value) {
        echo "<option value=\"$key\" >$value</option>\n";
      }
      echo '</select>';


      // Make the years pull-down menu:
      echo '<select required="required" name="end_year" id="year" style="width: 33%; display: inline; float: left; margin-left: 0%; margin-right: 0%" ;>';
      echo '<option selected value="">Year</option>\n';
      for ($year = 2015; $year <= 2030; $year++) {
        echo "<option value=\"$year\">$year</option>\n";
      }
      echo '</select>';
    }


?>



</body>
</html>

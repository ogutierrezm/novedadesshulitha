<?php 
	session_start();
	
	if (!ISSET($_SESSION['permisos'])) {
		echo '<script language="javascript">window.location= "login.php"</script>';
	}
	$sPermisos = $_SESSION['permisos'];
	$nombreUsuario = $_SESSION['nombreUsuario'];
	
	require_once("inc/init.php"); 
	include("../calls/fn_generales.php");
	include('../conx/conexiones.php');
	
	$sCalendario = foliosMesEnCurso();
	$sCalendario = json_encode($sCalendario['data']);
	
	$variable = obtenerVariableEmpresa(2,1);
	$variable = ISSET($variable['data']['valor'])?$variable['data']['valor']:300;
	echo '<script>	var vTiempoSesion = '.$variable.';
		 </script>';
		 
	
	$Ya = ISSET($_SESSION['expiroinstacia']) ? $_SESSION['expiroinstacia']:0;
	if ($Ya == 0){
		require_once("../php/expire.php");
		$_SESSION['expiroinstacia'] = 1;
	}
?>

<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-fw fa-calendar"></i> 
				Agenda			
		</h1>
	</div>
</div>	
<div class="row">
	
	<div class="col-sm-12 col-md-12 col-lg-12">

		<!-- new widget -->
		<div class="jarviswidget jarviswidget-color-blueDark">
			 
			<header>
				<span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
				<h2> Mis pedidos </h2>
				<!--<div class="widget-toolbar">
					 
					<div class="btn-group">
						<button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
							Mostrar <i class="fa fa-caret-down"></i>
						</button>
						<ul class="dropdown-menu js-status-update pull-right">
							<li>
								<a href="javascript:void(0);" id="mt">Mensual</a>
							</li>
							<li>
								<a href="javascript:void(0);" id="ag">Agenda</a>
							</li>
							<li>
								<a href="javascript:void(0);" id="td">Hoy</a>
							</li>
						</ul>
					</div>
				</div>-->
			</header>

			<!-- widget div-->
			<div>

				<div class="widget-body no-padding">
					<!-- content goes here -->
					<div class="widget-body-toolbar">

						<div id="calendar-buttons">

							<div class="btn-group">
								<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
								<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
							</div>
						</div>
					</div>
					<div id="calendar"></div>

					<!-- end content -->
				</div>

			</div>
			<!-- end widget div -->
		</div>
		<!-- end widget -->

	</div>

</div>

<!-- end row -->

<script type="text/javascript">
	pageSetUp();	
	 
	// PAGE RELATED SCRIPTS

	// pagefunction
	
	var fullviewcalendar;

	var pagefunction = function() {
		
		// full calendar
		
		var date = new Date();
	    var d = date.getDate();
	    var m = date.getMonth();
	    var y = date.getFullYear();
	
	    var hdr = {
	        left: 'title',
	        center: 'month,agendaWeek,agendaDay',
	        right: 'prev,today,next'
	    };
	    
	    /* initialize the calendar
		 -----------------------------------------------------------------*/
	
	    fullviewcalendar = $('#calendar').fullCalendar({
	
	        header: hdr,
	        buttonText: {
	            prev: '<i class="fa fa-chevron-left"></i>',
	            next: '<i class="fa fa-chevron-right"></i>'
	        },
	
	        editable: false,
	        droppable: false,
	        selectable: true, //true, // this allows things to be dropped onto the calendar !!!
	
	        drop: function (date, allDay) { // this function is called when something is dropped
	
	            // retrieve the dropped element's stored Event Object
	            var originalEventObject = $(this).data('eventObject');
	
	            // we need to copy it, so that multiple events don't have a reference to the same object
	            var copiedEventObject = $.extend({}, originalEventObject);
	
	            // assign it the date that was reported
	            copiedEventObject.start = date;
	            copiedEventObject.allDay = allDay;
	
	            // render the event on the calendar
	            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
	            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
	
	            // is the "remove after drop" checkbox checked?
	            if ($('#drop-remove').is(':checked')) {
	                // if so, remove the element from the "Draggable Events" list
	                $(this).remove();
	            }
	
	        },
	
	        select: function (start, end, allDay) {
	            var title = prompt('Event Title:');
	            if (title) {
	                calendar.fullCalendar('renderEvent', {
	                        title: title,
	                        start: start,
	                        end: end,
	                        allDay: allDay
	                    }, true // make the event "stick"
	                );
	            }
	            calendar.fullCalendar('unselect');
	        },
	
	        events: 
					<?PHP echo $sCalendario; ?>
					/*[{
		                id: 1,
		                title: 'Folio 80247',
		                start: new Date(y, m, 15),
		                end: new Date(y, m, 16),
		                allDay: true,
		                className: ["event", "bg-color-blue"],
		                icon: 'fa-clock-o'
		            },
		            {
		                title: 'Folio 87215',
		                start: new Date(y, m, 25),
		                allDay: true
		            }]*/
					
					,

			eventClick: function(calEvent,start, jsEvent, view){

				window.open("#ajax/modificar_pedidos_lista.php?fc="+moment(calEvent.start).format('YYYY-MM-DD') , "_self");

				//alert('Evento: ' + calEvent.title + ' | Fecha:' + moment(calEvent.start).format('YYYY-MM-DD') );
			
			},

			/* captura las fechas seleccionadas */
			select: function(start,end,jsEvent,view){
				window.open("#ajax/modificar_pedidos_lista.php?fc="+moment(start).format('YYYY-MM-DD') , "_self");
				//alert( "Pedido del:" +moment(start).format('YYYY-MM-DD') + " al "+ moment(end).format('YYYY-MM-DD'));
					 
			},
			/*
	
	        eventRender: function (event, element, icon) {
	            if (!event.description == "") {
	                element.find('.fc-event-title').append("<button id='btntj'><br/><span class='ultra-light'>" + event.description +
	                    "</span><button>");
	            }
	            if (!event.icon == "") {
	                element.find('.fc-event-title').append("<button id='btntj'><i class='air air-top-right fa " + event.icon +
	                    " '></i></button>");
	            }
	        },
	        */
	
	        windowResize: function (event, ui) {
	            $('#calendar').fullCalendar('render');
	        }
	    });
	
	    /* hide default buttons */
	    $('.fc-header-right, .fc-header-center').hide();

	
	
		$('#calendar-buttons #btn-prev').click(function () {
		    $('.fc-button-prev').click();
		    return false;
		});
		
		$('#calendar-buttons #btn-next').click(function () {
		    $('.fc-button-next').click();
		    return false;
		});
		
		$('#calendar-buttons #btn-today').click(function () {
		    $('.fc-button-today').click();
			
		    return false;
		});
		
		$('#mt').click(function () {
		    $('#calendar').fullCalendar('changeView', 'month');
		});
		
		$('#ag').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaWeek');
		});
		
		$('#td').click(function () {
		    $('#calendar').fullCalendar('changeView', 'agendaDay');
			
		});
		
	};
	
	
	// end pagefunction
	
	// destroy generated instances 

	// destroy generated instances 
	// pagedestroy is called automatically before loading a new page
	// only usable in AJAX version!

	var pagedestroy = function(){

		/*
		Example below:

		$("#calednar").fullCalendar( 'destroy' );
		if (debugState){
			root.console.log("✔ Calendar destroyed");
		} 

		For common instances, such as Jarviswidgets, Google maps, and Datatables, are automatically destroyed through the app.js loadURL mechanic

		*/
		
		fullviewcalendar.fullCalendar( 'destroy' );
		fullviewcalendar = null;
		$("#add-event").off();
		$("#add-event").remove();

		$('#external-events > li').off();
		$('#external-events > li').remove();
		$('#add-event').off();
		$('#add-event').remove();
		$('#calendar-buttons #btn-prev').off();
		$('#calendar-buttons #btn-prev').remove();
		$('#calendar-buttons #btn-next').off();
		$('#calendar-buttons #btn-next').remove();
		$('#calendar-buttons #btn-today').off();
		$('#calendar-buttons #btn-today').remove();
		$('#mt').off();
		$('#mt').remove();
		$('#ag').off();
		$('#ag').remove();
		$('#td').off();
		$('#td').remove();

		if (debugState){
			root.console.log("✔ Calendar destroyed");
		} 
	}

	// end destroy

	// loadscript and run pagefunction
	loadScript("js/plugin/moment/moment.min.js", function(){
		loadScript("js/plugin/fullcalendar/jquery.fullcalendar.min.js", pagefunction);
	});
</script>

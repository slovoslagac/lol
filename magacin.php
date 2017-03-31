<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage =  basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-truck"></i>
              <h3>Magacin - Mart 2017.</h3>
              <div class="controls">
                    <!-- Button to trigger modal -->
                    <a href="unos_nabavke.php" role="button" class="btn">Dodaj nabavku</a>
                </div> <!-- /controls -->
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th> Artikal </th>
                    <th width="100"> Pr. Cijena </th>
                      <th width="100"> Početak mjeseca </th>
                      <th width="100"> Nabavka </th>
                      <th width="100"> Prodaja </th>
                      <th width="100"> Trenutna količina </th>
                      <th width="100"> Razlika </th>
                      <th width="100"> Nabavna cijena </th>
                      <th width="100"> Zarada </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td> 100 Din </td>
                      <td> 100 </td>
                      <td> 50 </td>
                      <td> 25 </td>
                      <td> 122 </td>
                      <td> 3 <i class="icon-warning-sign"></i></td>
                      <td> 50 Din </td>
                      <td> 1250 Din </td>
                  </tr>
                  <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td> 100 Din </td>
                      <td> 100 </td>
                      <td> 50 </td>
                      <td> 25 </td>
                      <td> 122 </td>
                      <td> 3 </td>
                      <td> 50 Din </td>
                      <td> 1250 Din </td>
                  </tr>
                  <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td> 100 Din </td>
                      <td> 100 </td>
                      <td> 50 </td>
                      <td> 25 </td>
                      <td> 122 </td>
                      <td> 3 </td>
                      <td> 50 Din </td>
                      <td> 1250 Din </td>
                  </tr>
                  <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td> 100 Din </td>
                      <td> 100 </td>
                      <td> 50 </td>
                      <td> 25 </td>
                      <td> 122 </td>
                      <td> 3 </td>
                      <td> 50 Din </td>
                      <td> 1250 Din </td>
                  </tr>    
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget --> 
          
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
        
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 
<script>     

        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }    

        $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          selectable: true,
          selectHelper: true,
          select: function(start, end, allDay) {
            var title = prompt('Event Title:');
            if (title) {
              calendar.fullCalendar('renderEvent',
                {
                  title: title,
                  start: start,
                  end: end,
                  allDay: allDay
                },
                true // make the event "stick"
              );
            }
            calendar.fullCalendar('unselect');
          },
          editable: true,
          events: [
            {
              title: 'All Day Event',
              start: new Date(y, m, 1)
            },
            {
              title: 'Long Event',
              start: new Date(y, m, d+5),
              end: new Date(y, m, d+7)
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d-3, 16, 0),
              allDay: false
            },
            {
              id: 999,
              title: 'Repeating Event',
              start: new Date(y, m, d+4, 16, 0),
              allDay: false
            },
            {
              title: 'Meeting',
              start: new Date(y, m, d, 10, 30),
              allDay: false
            },
            {
              title: 'Lunch',
              start: new Date(y, m, d, 12, 0),
              end: new Date(y, m, d, 14, 0),
              allDay: false
            },
            {
              title: 'Birthday Party',
              start: new Date(y, m, d+1, 19, 0),
              end: new Date(y, m, d+1, 22, 30),
              allDay: false
            },
            {
              title: 'EGrappler.com',
              start: new Date(y, m, 28),
              end: new Date(y, m, 29),
              url: 'http://EGrappler.com/'
            }
          ]
        });
      });
    </script><!-- /Calendar -->
</body>
</html>

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
<?php
include $footerMenuLayout;
?>
</body>
</html>

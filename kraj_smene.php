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
            <div class="widget-header"> <i class="icon-time"></i>
                <h3>26.03.2017. - Druga smena - Stefan</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
            <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="center"> Artikal </th>
                    <th class="center"> Početno</th>
                      <th class="center"> Nabavka</th>
                      <th class="center"> Krajnje</th>
                      <th class="center"> Prodato</th>
                      <th class="center"> Smartlaunch </th>
                      <th class="center"> Razlika </th>
                      <th class="center"> Izmena </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td class="center" width="80"> 20 </td>
                      <td class="center" width="80"> 0 </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                  </tr>
                    <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td class="center" width="80"> 20 </td>
                      <td class="center" width="80"> 0 </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                  </tr>
                    <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td class="center" width="80"> 20 </td>
                      <td class="center" width="80"> 0 </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                  </tr>
                    <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td class="center" width="80"> 20 </td>
                      <td class="center" width="80"> 0 </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                  </tr>
                    <tr>
                    <td> Bravo flašica 0,5 </td>
                    <td class="center" width="80"> 20 </td>
                      <td class="center" width="80"> 0 </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"> 19 </td>
                      <td class="center" width="80"> <b>1</b> </td>
                      <td class="center" width="80"><a href="#vracanje" role="button" class="btn btn-small btn-primary" data-toggle="modal"><i class="btn-icon-only icon-pencil"> </i></a></td>
                  </tr>
                </tbody>
            </table>
                
                </div>
                <a href="pazar.php" role="button" class="btn btn-large btn-primary btn-right">Dalje <i class="btn-icon-only icon-chevron-right"> </i></a>
            </div>
            
            
            
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
<?php
include $footerMenuLayout;
?>
</body>
</html>

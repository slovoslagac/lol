<?php
include(join(DIRECTORY_SEPARATOR, array('includes', 'init.php')));


$currentpage = basename($_SERVER["SCRIPT_FILENAME"]);
include $menuLayout;
?>
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">

                    <div class="widget widget-table action-table">
                        <div class="widget-header"><i class="icon-user"></i>
                            <h3>LOL klub - članovi</h3>
                            <div class="controls">
                                <!-- Button to trigger modal -->
                                <a href="lol_unos.php" role="button" class="btn">Dodaj novog člana</a>
                            </div> <!-- /controls -->
                        </div>
                        <!-- /widget-header -->
                        <div class="widget-content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th> RB</th>
                                    <th> Ime</th>
                                    <th> Prezime</th>
                                    <th> Arena Username</th>
                                    <th> Summoner Name</th>
                                    <th> Rank</th>
                                    <th> Popust</th>
                                    <th> Pozicija</th>
                                    <th> Telefon</th>
                                    <th class="td-actions"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $usr = new user();
                                $allusers = $usr->getAllUsers();
                                $i = 1;
                                foreach ($allusers as $item) { ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td id="<?php echo "name$i" ?>" ><?php echo $item->name ?></td>
                                        <td><?php echo $item->lastname ?></td>
                                        <td><?php echo $item->arenausername ?></td>
                                        <td><?php echo $item->summonername ?></td>
                                        <td><?php echo $item->rankname ?></td>
                                        <td><?php echo ($item->discount == null) ? "0%" : "$item->discount%"; ?>
                                        <td><?php echo $item->positionname ?></td>
                                        <td><?php echo $item->phone ?></td>
                                        <input type="hidden" value="<?php echo $item->id ?>" name="userId">
                                        <input type="hidden" name="deleteUser" value="Obriši">
                                        <td class="td-actions">
                                            <a href="#edit" class="btn btn-small btn-success" data-toggle="modal" onclick="edit(<?php echo $i ?>)"><i class="btn-icon-only icon-ok"> </i></a>
                                            <a href="#" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
                                        </td>
                                    </tr>
                                    </form>


                                    <?php $i++;
                                } ?>


                                </tbody>
                            </table>
                        </div>
                        <!-- /widget-content -->
                    </div>
                    <!-- /widget -->

                </div>
                <!-- /span6 -->
                <!-- Modal -->
                <div id="edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Potvrda rezervacije</h3>
                    </div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="modal-body">
                            <p>Obavezno popuniti sva polja:</p>

                            <div class="field">
                                <label for="firstname">Ime:</label>
                                <input type="text" name="name" min="1" maxlength="50" placeholder="Ime" class="login" required/>
                            </div> <!-- /field -->
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"> Poništi</button>
                            <button class="btn btn-primary" type="submit" name="confirmation" id="confirmation">Potvrdi</button>
                        </div>
                    </form>
                </div>
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

<script>
    function edit(val) {
        console.log('name' + val);
        var name = document.getElementById('name' + val).textContent;
        console.log(name);
        console.log(val);
        $(".name").attr({
            "value": name
        });

    }
</script>
</body>
</html>

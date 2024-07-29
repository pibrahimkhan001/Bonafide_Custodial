<?php
@session_start();
if(!empty($_SESSION['cert_user']) && !empty($_SESSION['priv']) && $_SESSION['priv']=="generator"){

if(!empty($_POST['htno']) && !empty($_POST['stname']) && !empty($_POST['fname']) && !empty($_POST['mname']) && !empty($_POST['gender']) && (!empty($_POST['year']) || !empty($_POST['sem'])) && !empty($_POST['course']) && !empty($_POST['spec']) && !empty($_POST['docs']) && !empty($_POST['dob']) && !empty($_POST['purpose']) && ($_POST['purpose']!='other' || !empty($_POST['otherpurpose']))){

if($_POST['purpose']=="other"){
  $_POST['purpose'] = $_POST['otherpurpose'];
}

$res = $_POST;
  require('header.php');
  ?>

  <div class="container-fluid">
    <div class="row row-offcanvas row-offcanvas-left">

      <div class="col-xs-12 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
        <div class="list-group">
          <?php
          $menu_id = 3;
          require_once("menu.php");
          ?>
        </div>
      </div><!--/span-->

      <div class="col-xs-12 col-sm-9">

        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 align='center'>Custodial Certificate Generation</h4>
          </div>

          <div class="panel-body">
            <form class="form-horizontal" role="form" action="custodial4.php" method="post">
                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Hall Ticket Number:</label>
                    <div class="col-sm-6">
                      <?php echo $res['htno']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Student Name:</label>
                    <div class="col-sm-6">
                      <?php echo $res['stname']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Father Name:</label>
                    <div class="col-sm-6">
                      <?php echo $res['fname']; ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Gender:</label>
                    <div class="col-sm-6">
                      <?php
                      if(strtoupper($res['gender'])=='M' || strtoupper($res['gender'])=='MALE'){
                          echo "Male";
                      }
                      elseif(strtoupper($res['gender'])=='F' || strtoupper($res['gender'])=='FEMALE'){
                          echo "Female";
                      }
                      else{
                        echo "<span style='color:red'>Invalid</span>";
                      }
                       ?>
                    </div>
                  </div>

                  <?php
                    $cls = "";
                    if(!empty($res['year'])){
                      $cls = $res['year']."&nbsp;";
                    }

                    $cls = $cls."".$res['course']." - ";

                    if(!empty($res['sem'])){
                      $cls = $cls."".$res['sem']."&nbsp;Semester - ";
                    }

                    $cls = $cls."".$res['spec'];

                    $dob = $res['dob'];
                  ?>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Class:</label>
                    <div class="col-sm-6">
                      <?php echo $cls; ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Documents:</label>
                    <div class="col-sm-3">
                      <?php
                      require('cgs.php');
                      $cgs_obj = new CGS;

					  echo $_POST['docs1']."<br/>" ;

                      $docs = $cgs_obj->getDocs();
                      foreach ($res['docs'] as $value) {
                        echo $docs[$value]."<br/><input type='hidden' name='docs[]' value='".$value."' />";
                      }

                       ?>
                    </div>
                    <div class="col-sm-3">
                      &nbsp;
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Purpose:</label>
                    <div class="col-sm-3">
                      <?php echo $res['purpose']; ?>
                    </div>
                    <div class="col-sm-3">
                      &nbsp;
                    </div>
                  </div>

                  <input type='hidden' name='htno' value='<?php echo $res['htno']; ?>' />
                  <input type='hidden' name='stname' value='<?php echo $res['stname']; ?>' />
                  <input type='hidden' name='fname' value='<?php echo $res['fname']; ?>' />
                  <input type='hidden' name='mname' value='<?php echo $res['mname']; ?>' />
                  <input type='hidden' name='gender' value='<?php echo $res['gender']; ?>' />
                  <input type='hidden' name='class' value='<?php echo $cls; ?>' />
                  <input type='hidden' name='dob' value='<?php echo $dob; ?>' />
                  <input type='hidden' name='purpose' value='<?php echo $res['purpose']; ?>' />
                  <input type='hidden' name='docs1' value='<?php echo $res['docs1']; ?>' />
                  <div class="form-group">
                    <div class="col-sm-4" align='right'>
                      <a href="custodial1.php" class="btn btn-danger">&nbsp;&nbsp;back&nbsp;&nbsp;</a>
                    </div>
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-default">Generate Certificate</button>
                    </div>
                  </div>


                    </form>
                  </div><!--panel body-->
                </div><!--panel info-->

              </div>
            </div>

          </div>
          <?php
          require('footer.php');

}
else {
  header('Location: custodial1.php');
}

}
else {
  header('Location: ./');
}
 ?>

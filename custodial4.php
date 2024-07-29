<?php
@session_start();
if(!empty($_SESSION['cert_user']) && !empty($_SESSION['priv']) && $_SESSION['priv']=="generator"){

if(!empty($_POST['htno']) && !empty($_POST['stname']) && !empty($_POST['fname']) && !empty($_POST['mname']) && !empty($_POST['gender']) && ($_POST['gender']=='M' || $_POST['gender']=='F') && !empty($_POST['class']) && !empty($_POST['dob']) && !empty($_POST['purpose'])){
$res = $_POST;

$res['docs']['2'] = $res['docs1'];
$docs = implode(",",$_POST['docs']);
require("cgs.php");
$cgs_obj = new CGS;
if($_POST['docs1'] == "SSC Marks Memo"){
	$docs=$docs.",ssc";
	}
else if($_POST['docs1'] == "CBSC Marks Memo"){
		$docs=$docs.",cbsc";
}
else{
		$docs=$docs.",icse";
}
$insres = $cgs_obj->custodialCert($res['htno'],$res['stname'],$res['fname'],$res['gender'],$res['class'],$docs,$res['dob'],$res['purpose'],$_SESSION['cert_user']);

if($res['gender']=='M'){
  $g1 = "Mr.";
  $g2 = "son";
  $g3 = "him";
  $g4 = "his";
  $g5 = "he";
}
else{
  $g1 = "Ms.";
  $g2 = "daughter";
  $g3 = "her";
  $g4 = "her";
  $g5 = "she";
}


  require('header.php');
  ?>

  <div class="container-fluid">
    <div class="row row-offcanvas row-offcanvas-left dontprint">

      <div class="col-xs-12 col-sm-3 sidebar-offcanvas dontprint" id="sidebar" role="navigation">
        <div class="list-group">
          <?php
          $menu_id = 3;
          require_once("menu.php");
          ?>
        </div>
      </div><!--/span-->

      <div class="col-xs-12 col-sm-9">

        <div class="panel panel-info dontprint">
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
                    <label for="inputHtno" class="col-sm-6 control-label labelapply3">Certificate:</label>
                    <div class="col-sm-6">
                      <?php echo "Custodial Certificate"; ?>
                    </div>
                  </div>

                  <div class="col-sm-12" align='center'>
                    <button type="button" name="button" class="btn btn-link" onClick="window.print()" />If Certificate Not Generated automatically, click here</button>
                  </div>
                  <br/>
                  <div class="form-group">
                    <div class="col-sm-4" align='right'>
                      <a href="custodial1.php" class="btn btn-default">&nbsp;&nbsp;Back&nbsp;&nbsp;</a>
                    </div>
                    <div class="col-sm-8">&nbsp;</div>
                  </div>
                  <?php if($insres==0){ ?>
                  <br/>
                  <div class="col-sm-12" align='center'>
                    <span style="color:red"> Please Contact Administrator with ErrorName 'CustodialNotInserted' </span>
                  </div>
                  <?php } ?>

                    </form>
                  </div><!--panel body-->
                </div><!--panel info-->

              </div>
            </div>
          </div>
            <style media="print">
              .data{
                  font-weight: bold;
                  text-decoration: underline;
              }
              .datapurpose{
                  font-weight: bold;

              }
            </style>

            <div class="row doprint" STYLE=" margin:10mm 10mm 1mm 10mm; border: 10px double #000000; width:185mm; height:261mm;">
              <div class="col-sm-12" style="font-family:'Book Antiqua';">
                <div align='center' style=" padding-top:12px; letter-spacing:1px; font-weight: bold;">
                  <span style="font-size:1.3em;">JAWAHARLAL NEHRU TECHNOLOGICAL UNIVERSITY ANANTAPUR</span><br/><br/>
                  <span style="font-size:1.3em;">COLLEGE OF ENGINEERING (<i>Autonomous</i>), ANANTHAPURAMU</span><br/><br/>
                  <span style="font-size:1.1em; padding-top:10px;">ANDHRA PRADESH, INDIA - 515002</span><br/><br/>
                  <img src="images/jntuacea.png" alt="JNTUACEA" width="100px" height="100px" style="margin:10px;" /><br/>
                  <div align='right' style="padding-right:15px; font-weight: bold; font-size:1.1em;">
                    Office of the Principal<br />
                    Date: <?php echo date("d/m/Y"); ?>&nbsp;&emsp;&emsp;&emsp;<br/>
                  </div>
                  <br/><br/><span class="data" style="font-family:'Arial'; font-size:1.4em; margin-bottom:12px; letter-spacing: 3px;">CUSTODIAL CERTIFICATE</span>
                </div><br/><br/><br/>
                <div style="text-align:justify;-moz-text-align:justify; line-height:2.6em;">
                  <p  style="font-family:'Book Antiqua'; font-size:1.3em;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that <?php echo '<span class="data">'.$g1.' '.$res['stname'].'</span>'; ?> bearing Adm. No. <?php echo '<span class="data">'.$res['htno'].'</span>'; ?>
                     is a  student of  <?php echo '<span class="data">'.$res['class'].'</span>'; ?> in our institution. At the time of admission <?php echo $g5; ?> has submitted the following original certificates to our college.<br/><br/>

                     <?php
					 $p=1;
					 echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$p.".&nbsp;".$res['docs1']." (DOB:".$_POST['dob'].")<br/>";
                     $i = 2;
                     $docs_arr = $cgs_obj->getDocs();
                     foreach ($_POST['docs'] as $s) {
                       if($s=="ssc"){
                         echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$i.".".$docs_arr[$s]."<br />";
                       }
                       else {
                         echo "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$i.". ".$docs_arr[$s]."<br />";
                       }
                       $i++;
                     }
                      ?>

                    &emsp; This certificate is issued to <?php echo $g3; ?> on <?php echo $g4; ?> request to apply for "<?php echo '<span class="datapurpose">'.$res['purpose'].'</span>'; ?>".</p>

                </div>
                <div align='right' style="padding-right:15px; font-weight: bold; font-size:1.3em;">
                    <br/><br/>
                  PRINCIPAL&emsp;

                </div>
              </div>
            </div>


          <script type="text/javascript">
            window.print();
          </script>
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

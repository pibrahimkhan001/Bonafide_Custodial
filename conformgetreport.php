<?php

/*
It is not a class
so be careful with variable names used
@nil
*/
@session_start();
if(!empty($_SESSION['cert_user']) && !empty($_SESSION['priv']) && $_SESSION['priv']=="generator" && !empty($_POST['printdate'])){

require_once("db.php");
$dbcred = new Db();
$host = $dbcred->getHost();
$dbname = "bonafide";
$user = $dbcred->getuser();
$pwd = $dbcred->getpwd();

  $mysqli = new mysqli($host, $user, $pwd, $dbname);
   /* check connection */
   if (mysqli_connect_errno()) {
      header('Location: getreport.php?id=networkerror');
   }
   else{


     $ss=0;
     $tables = array();


     if ($stmt = $mysqli->prepare("show tables")) {
          if($stmt->execute()){
            $stmt->bind_result($table);
  				      while ($stmt->fetch()) {
                  $tables[$ss] = $table;
  				        $ss++;
  			        }
            }else{
  			         header('Location: getreport.php?id=dateerror');
            }
            $stmt->close();
      }
      else{
          header('Location: getreport.php?id=networkdberror');
      }

    $s = 1;

    foreach($tables as $tbl){
   /* create a prepared statement */
   $query = "SELECT `htno`, `stname`, `fname`, `gender`, `class`, `period`, `purpose` FROM ".$tbl." WHERE date(updatedon) like ? order by date(updatedon) asc";
   if ($stmt = $mysqli->prepare($query)) {

     $dt = date("Y-m-d",strtotime($_POST['printdate']));
     $dt = $dt."%";
       /* bind parameters for markers */
       $stmt->bind_param("s", $dt);

       /* execute query */
        if($stmt->execute()){

       /* bind result variables */
        $stmt->bind_result($actualids,$stnames,$fnames,$genders,$classs,$periods,$purposes);
				 /* fetch value */
				 while ($stmt->fetch()) {

				 $res_arr = array();
				   $sno[$s] = $s;
				   $htno[$s] = $actualids;
           $stname[$s] = $stnames;
           $fname[$s] = $fnames;
           $gender[$s] = $genders;
           $class[$s] = $classs;
           $period[$s] = $periods;
           $purpose[$s] = $purposes;
				   $s++;
			   }

          }else{
			         header('Location: getreport.php?id=dateerror');
          }
          /* close statement */
          $stmt->close();
      }
      else{
        header('Location: getreport.php?id=networkdberror');
      }
    }
     /* close connection */
     $mysqli->close();
   }



$dbname = "custodial";

     $mysqli = new mysqli($host, $user, $pwd, $dbname);
      /* check connection */
      if (mysqli_connect_errno()) {
         header('Location: getreport.php?id=networkerror');
      }
      else{


        $ss=0;
        $tables = array();


        if ($stmt = $mysqli->prepare("show tables")) {
             if($stmt->execute()){
               $stmt->bind_result($table);
     				      while ($stmt->fetch()) {
                     $tables[$ss] = $table;
     				        $ss++;
     			        }
               }else{
     			         header('Location: getreport.php?id=dateerror');
               }
               $stmt->close();
         }
         else{
             header('Location: getreport.php?id=networkdberror');
         }

       $c = 1;

       foreach($tables as $tbl){
      /* create a prepared statement */
      $query = "SELECT `htno`, `stname`, `fname`, `gender`, `class`, `docs`, `dob`, `purpose` FROM ".$tbl." WHERE date(updatedon) like ? order by date(updatedon) asc";
      if ($stmt = $mysqli->prepare($query)) {

        $dt = date("Y-m-d",strtotime($_POST['printdate']));
        $dt = $dt."%";
          /* bind parameters for markers */
          $stmt->bind_param("s", $dt);

          /* execute query */
           if($stmt->execute()){

          /* bind result variables */
           $stmt->bind_result($actualids,$stnames,$fnames,$genders,$classs,$docs,$dobs,$purposes);
   				 /* fetch value */
   				 while ($stmt->fetch()) {

   				 $res_arr = array();
   				   $snoc[$c] = $c;
   				   $htnoc[$c] = $actualids;
              $stnamec[$c] = $stnames;
              $fnamec[$c] = $fnames;
              $genderc[$c] = $genders;
              $classc[$c] = $classs;
              $docc[$c] = $docs;
              $dobc[$c] = $dobs;
              $purposec[$c] = $purposes;
   				   $c++;
   			   }

             }else{
   			         header('Location: getreport.php?id=dateerror');
             }
             /* close statement */
             $stmt->close();
         }
         else{
           header('Location: getreport.php?id=networkdberror');
         }
       }
        /* close connection */
        $mysqli->close();
      }


if($c>1 || $s>1){
        date_default_timezone_set("Asia/Kolkata");
        $id = date('d_m_Y',strtotime($dt));
        $tstmp = date('d_m_Y_H_i_s');

        $name = "downloads/report_".$tstmp.".xls";
        $dtid = date("d-m-Y",strtotime($_POST['printdate']));

        require_once 'Classes/PHPExcel.php';
        require_once 'Classes/PHPExcel/Writer/Excel5.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();


if($s>1){

  // Fill worksheet from values in array
  $objPHPExcel->setActiveSheetIndex(0);
  $j = 1; /* cell index*/

  $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
  $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'BONAFIDE CERTIFICATES GENERATED ON '.$dtid);
  $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
  $j++;

	$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'S.No.');
	$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Hall Ticket No.');
	$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Student Name');
	$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Father Name');
	$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Gender');
	$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Class');
	$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Period');
	$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Purpose');
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);
	$j++;


	for($i=1;$i<$s;$i++)
	{

	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $sno[$i]);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('B'.$j, $htno[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('C'.$j, $stname[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$j, $fname[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$j, $gender[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$j, $class[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$j, $period[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$j, $purpose[$i],PHPExcel_Cell_DataType::TYPE_STRING);
	$j++;
	}


    $objPHPExcel->getActiveSheet()->setTitle('BONAFIDE CERTIFICATES');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
  }
  else {
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'BONAFIDE CERTIFICATE(S) NOT GENERATED ON '.$dtid);
    $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setTitle('BONAFIDE CERTIFICATES');
  }

  $objPHPExcel->createSheet(1);
  if($c>1){
    // Fill worksheet from values in array
    $objPHPExcel->setActiveSheetIndex(1);
    $j = 1; /* cell index*/

    $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CUSTODIAL CERTIFICATES GENERATED ON '.$dtid);
    $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
    $j++;

  $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'S.No.');
  $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Hall Ticket No.');
  $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Student Name');
  $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Father Name');
  $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Gender');
  $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Class');
  $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Documents');
  $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'DOB');
  $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Purpose');
  $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
  $j++;


  	for($i=1;$i<$c;$i++)
  	{

  	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j, $snoc[$i]);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('B'.$j, $htnoc[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('C'.$j, $stnamec[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$j, $fnamec[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$j, $genderc[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$j, $classc[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$j, $docc[$i],PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$j, $dobc[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('I'.$j, $purposec[$i],PHPExcel_Cell_DataType::TYPE_STRING);
  	$j++;
  	}


      $objPHPExcel->getActiveSheet()->setTitle('CUSTODIAL CERTIFICATES');
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
  		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
  		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
  		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
  		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
  		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    }
    else {
      $objPHPExcel->setActiveSheetIndex(1);
      $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
      $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CUSTODIAL CERTIFICATE(S) NOT GENERATED ON '.$dtid);
      $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
      $objPHPExcel->getActiveSheet()->setTitle('CUSTODIAL CERTIFICATES');
    }

    $xlname = $name;
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($xlname);

    header('Location: ./'.$xlname);
  }
  else{
    header('Location: getreport.php?id=empty');
  }


}else{
  header('Location: getreport.php');
}

?>

<?php
ob_end_clean();
$objPHPExcel = new PHPExcel();

$styleArray1 = array(
	'font' => array(
		'bold' => true,
		'color' => array('argb' => 'FF000000',)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'WrapText' => true,
	),
);
$styleArray2 = array(
	'font' => array(
		'bold' => true,
		'color' => array('argb' => 'FF000000',)
	),
	'alignment' => array(
		'WrapText' => true,
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array(
			'argb' => 'FF92D050',
		),
	)
);
$styleArray3 = array(
	'font' => array(
		'bold' => true,
		'color' => array('argb' => 'FF000000',)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'WrapText' => true,
	)
);
$styleArrayborder = array('borders' => array(
	'allborders' => array(
		'style' => PHPExcel_Style_Border::BORDER_THIN,
		'color' => array('argb' => 'FF000000'),
	),
),);

function getNameFromNumber($num) {
    $numeric = ($num ) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num ) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

$row = 1;
$i = 0;
if(isset($coaches)){
	$fields = array("sn",'registration_id',"full_name",'email','gender',"dob",'state_reference','mobile');
	$field_names = array("SN","Registration Id" ,"Name","Email","Gender","DOB","State of Reference","Contact No");
	$widths = array("10","20","20","10","25","30","30","20");
	$exportData = $coaches;
	$title = 'Coaches';
}
if(isset($licenses)){
	$fields = array("sn","name","description","authorised_by");
	$field_names = array("SN", "License Name", "Description",'Authorised By');
	$widths = array("10","20","20","40");
	$exportData = $licenses;
	$title = 'Licenses';

}
if(isset($courses)){
	$fields = array("sn","name",'license_name','authorised_by','start_date','end_date','fees','venue',"description");
	$field_names = array("SN", "Course Name", "License Name",'Authorised By','Start Date','End Date','Fees','Venue','Description');
	$widths = array("10","20","20","40","20","30","20","20","20");
	$exportData = $courses;
	$title = 'Courses';

}
if(isset($applications)){
	$fields = array("sn",'course_name',"first_name",'middle_name','last_name','status');
	$field_names = array("SN","Course Name", "First Name", "Middle Name","Last Name","Payment Status");
	$widths = array("10","20","20","40","20","30","20","20","20");
	$exportData = $applications;
	$title = 'Applications';

}
if(isset($payments)){
	$fields = array("sn",'course_name',"first_name",'middle_name','last_name','fees','payment_method','cheque_date','cheque_number','bank_name','remarks','status');
	$field_names = array("SN","Course Name", "First Name", "Middle Name","Last Name","Fee Amount","Payment Method","Cheque/Draft Date",'Cheque/Draft Number','Bank Name',"Remarks","Payment Status");
	$widths = array("10","20","20","20","20","30","20","20","20","20","20","20");
	$exportData = $payments;
	$title = 'Payments';

}
if(isset($parameters)){
	$fields = array("sn",'parameter','max_marks');
	$field_names = array("SN","Parameter Name", "Maximum Marks");
	$widths = array("10","30","20","20");
	$exportData = $parameters;
	$title = 'Parameters';

}

if(isset($licenseParameter)){
	$fields = array("sn",'license_name','parameter');
	$field_names = array("SN","License Name","Parameter Name");
	$widths = array("10","30","20","20");
	$exportData = $licenseParameter;
	$title = 'License Parameters';

}

if(isset($applicationsResult)){
	$fields = array("sn",'course_name','license_name',"first_name",'middle_name','last_name','finalResult');
	$field_names = array("SN","Course Name", "License Name","Coach First Name", "Middle Name","Last Name",'Status');
	$widths = array("10","20","20","40","20","30","20","20","20");
	$exportData = $applicationsResult;
	$title = 'Courses List';

}


if(isset($payments)){
	$appStatus =  array(
			"0" => "Approval Pending",
			"1" => "Approved",
		);
	$paymentMethod = array(
		'1' => "Cheque", 
		'2' => "Draft", 
		'3' => "Cash", 
		);
}
else{
	$appStatus =  array(
			"0" => "Approval Pending",
			"1" => "Payment Pending",
			"2" => "Payment Approval Pending",
			"3" => "Approved",
		);
}


foreach ($field_names as $name) {
	$objPHPExcel->getActiveSheet()->SetCellValue( getNameFromNumber($i).$row , $name);
	$objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($i))->setWidth($widths[$i]);
	$i++;
}
$objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber(0).$row.':'.getNameFromNumber($i-1).$row)->applyFromArray($styleArray2);

$row++;

$count = 1;
foreach ($exportData as $data) {
	$i = 0;
	$data = json_decode(json_encode($data), true);

	foreach ($fields as $field) {
		$var = '';
		if($field == 'sn'){
			$var = $count;
		}elseif($field == 'authorised_by'){
			if($data[$field]==1){
				$var = 'AFC';
			}
			else{
				$var = 'AIFF';
			}
		}else if($field == 'dob'){
			$var = date("d-M-y", strtotime($data[$field]));
		}else if($field == 'gender'){
			if($data[$field]==1){
				$var = 'Male';
			}
			else{
				$var = 'Female';
			}
		} 
		else if($field == 'cheque_date'){
			if(date("d-M-y", strtotime($data[$field]))=='01-Jan-70'){
				$var='';
			}
			else{
				$var = date("d-M-y", strtotime($data[$field]));
			}
			
		}
		else if($field == 'start_date'){
			$var = date("d-M-y", strtotime($data[$field]));
		}
		else if($field == 'end_date'){
			$var = date("d-M-y", strtotime($data[$field]));
		}
		else if($field == 'status'){
			$var = $appStatus[$data[$field]];
		}
		else if($field == 'payment_method'){
			$var = $paymentMethod[$data[$field]];
		}
		else if($field == 'finalResult'){
			$var = $resultStatus[$data[$field]];
		}
		else {
			$var = $data[$field];
		}
		$objPHPExcel->getActiveSheet()->SetCellValue( getNameFromNumber($i).$row , $var);
		$i++;
	}
	$count++;
	$row++;
}

// $objPHPExcel->getActiveSheet()->getStyle(getNameFromNumber(0).':'.getNameFromNumber($i+1))->getAlignment()->setWrapText(true);


$objPHPExcel->getProperties()->setCreator("Avyay Technologies")->setLastModifiedBy("Avyay Technologies");
$objPHPExcel->getActiveSheet()->setTitle($title.' Data');
$name = $title.date("d-m-y", strtotime("now"));

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
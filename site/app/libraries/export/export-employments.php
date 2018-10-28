<?php
// ob_end_clean();
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
	$fields = array("sn",'full_name','registration_id','email','club_name','employments','hyperlink');
	$field_names = array("SN","Name",'Registration Id','Email','Organization','Coaching Employments','Contracts');
	$widths = array("10","30","30","30","20","40","40","40","20","20","20","20");
	$exportData = $coaches;
	$title = 'All Coaches ';
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

$objPHPExcel->getProperties()->setCreator("Avyay Technologies")->setLastModifiedBy("Avyay Technologies");
$objPHPExcel->getActiveSheet()->setTitle($title.' Data');
$name = $title.date("d-m-y", strtotime("now"));

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
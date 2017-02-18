<?php
require('config.php');
require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
dol_include_once('/simple/class/grade.class.php');
$langs->load('mandarin@mandarin');
$grade=new Grade;
$PDOdb = new TPDOdb;
$TData = array();
$TChart = array();
$isA=0;
$isB=0;
$isC=0;
$isD=0;
$isE=0;
$result=array();
$mesGrades= array('A','B','C','D','E');
// Formatage du tableau de base
$sql = 'SELECT nom,capital,zip FROM '.MAIN_DB_PREFIX.'societe WHERE capital IS NOT NULL AND zip IS NOT NULL';

$rsult = $PDOdb->Execute($sql);

$TData = $PDOdb->Get_All();
$selectgrade = GETPOST('selectgrade');

foreach($TData as &$line){
	$line->grade = $grade->getGrade($line->capital, $line->zip);
	if($selectgrade>=0 &&  $grade->getGrade($line->capital, $line->zip)==$mesGrades[$selectgrade]){
		
		$result[]=$line;
		
	}
	if($line->grade == 'A'){
		$isA ++;
	} else if($line->grade == 'B'){
		$isB ++;
	} else if($line->grade == 'C'){
		$isC ++;
	} else if($line->grade == 'D'){
		$isD ++;
	} else if($line->grade == 'E'){
		$isE ++;
	}
	
	
}
$TChart[] = array('A',$isA);
$TChart[] = array('B',$isB);
$TChart[] = array('C',$isC);
$TChart[] = array('D',$isD);
$TChart[] = array('E',$isE);
// Begin of page
llxHeader('', $langs->trans('simpleTitleGraphGrade'), '');

$formCore=new TFormCore('auto','form2', 'get');


$ColFormat = array(
		'nom' => 'string'
		,'zip' => 'number'
		,'capital' => 'number'
		,'grade' => 'string'
);

$form = new Form($db);

$headsearch='Grade :';
$headsearch=$form->selectarray('selectgrade', $mesGrades,'',1);

$headsearch.= $formCore->btsubmit($langs->trans('Ok'),'bt_ok');

$listeview = new TListviewTBS('gradeReport');
if(!empty($result)){
	print $listeview->renderArray($PDOdb, $result
			,array(
	
					'liste'=>array(
							'titre'=>$langs->transnoentitiesnoconv('titleGradeReport')." $mesGrades[$selectgrade]",
							'head_search'=>$headsearch
					)
					,'title'=>array(
							'nom' => $langs->transnoentitiesnoconv('Name')
							,'zip' => $langs->transnoentitiesnoconv('Zip')
							,'capital' => $langs->transnoentitiesnoconv('Capital')
							,'grade' => $langs->transnoentitiesnoconv('Grade')
	
					)
	
			)
			);
	
	$listechart = new TListviewTBS('gradeChart');
	print $listechart->renderArray($PDOdb, $result
			,array(
					'type' => 'chart'
					,'chartType' => 'PieChart'
					,'liste'=>array(
							'titre'=>$langs->transnoentitiesnoconv('titleGraphProjectByTypeSearch')." $mesGrades[$selectgrade]"
					)
			)
			);
}
else {
	print $listeview->renderArray($PDOdb, $TData
			,array(
	
					'liste'=>array(
							'titre'=>$langs->transnoentitiesnoconv('titleGradeReport'),
							'head_search'=>$headsearch
					)
					,'title'=>array(
							'nom' => $langs->transnoentitiesnoconv('Name')
							,'zip' => $langs->transnoentitiesnoconv('Zip')
							,'capital' => $langs->transnoentitiesnoconv('Capital')
							,'grade' => $langs->transnoentitiesnoconv('Grade')
	
					)
	
			)
			);
	
	$listechart = new TListviewTBS('gradeChart');
	print $listechart->renderArray($PDOdb, $TChart
			,array(
					'type' => 'chart'
					,'chartType' => 'PieChart'
					,'liste'=>array(
							'titre'=>$langs->transnoentitiesnoconv('titleGraphProjectByType')
					)
			)
			);
}


// End of page
llxFooter();
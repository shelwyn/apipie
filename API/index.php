<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
$db = new PDO("mysql: host=localhost; dbname=wayne_enterprises; charset=utf8","USERID","PASSWORD");
$method = $_SERVER['REQUEST_METHOD'];

		try {
			} catch(PDOException $message) {
			echo $message->getMessage();
				}
				
switch ($method) {
  case 'GET':
		$json = file_get_contents('php://input');
		$data = json_decode($json); 
		$query = $db->prepare("SELECT * FROM employees where empid = :empid");
		$query->bindParam(':empid', $_GET['empid'], PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($data);
   break;
  case 'POST':
		$json = file_get_contents('php://input');
		$data = json_decode($json); 
		$query = $db->prepare("insert into employees (empid,empname,empdesignation,empsalary) values(:empid,:empname,:empdesignation,:empsalary)");
		$query->bindParam(':empid', $data->empid, PDO::PARAM_INT);
		$query->bindParam(':empname', $data->empname, PDO::PARAM_STR,45);
		$query->bindParam(':empdesignation', $data->empdesignation, PDO::PARAM_STR,45);
		$query->bindParam(':empsalary', $data->empsalary, PDO::PARAM_INT);
		$query->execute();
		echo "**** NEW RECORD ADDED ******";
    break;
  case 'PUT':
	    $json = file_get_contents('php://input');
	    $data = json_decode($json); 
	    $query = $db->prepare("update employees set empdesignation = :empdesignation,empsalary = :empsalary where empid = :empid");
		$query->bindParam(':empid', $data->empid, PDO::PARAM_INT);
		$query->bindParam(':empdesignation', $data->empdesignation, PDO::PARAM_STR,45);
		$query->bindParam(':empsalary', $data->empsalary, PDO::PARAM_INT);
		$query->execute();
		echo "**** RECORD WITH ID: " . $data->empid . " UPDATED ******";
   break;
  case 'DELETE':
		$json = file_get_contents('php://input');
		$data = json_decode($json); 
		$query = $db->prepare("delete from employees where empid = :empid");
		$query->bindParam(':empid', $_GET['IdToDelete'], PDO::PARAM_INT);
		$query->execute();
		echo "**** RECORD WITH ID: " . $_GET['IdToDelete']. " DELETED ******";
	break;
}
?>
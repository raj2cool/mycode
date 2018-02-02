<?php
namespace application\Models;
use PDO;
class Post extends \Core\Model
{

/*  ------Login Page------   */

	public function insertdata($data){
		$db=static::getDB();
		$message="";
		$uname=$data['uname'];
		$pass=$data['pass'];

		$q="SELECT * FROM `login`";		
		$check=mysqli_query($db,$q);
		$querry=mysqli_fetch_array($check);
		if ($querry['1']==$uname && $querry['2']==$pass) {
			$redirect='menu.html';
			$message="Welcome";
			$con=[
			'redirect'=>$redirect,
			'message'=>$message
			];
			return $con;
		}
		else{
			$redirect='login.html';
			$message ="Invalid Credentials...";
			$con=[
			'redirect'=>$redirect,
			'message'=>$message
			];
			return $con;
		}	

	}
	public function checkdata($pass){
		$db=static::getDB();
		$message="";
		$q="SELECT * FROM `setting` WHERE Password='$pass' ";
		$check=mysqli_query($db,$q);
		if(mysqli_fetch_array($check)){
		 	header('location:/dashboard/index');
		}
		else{
			$message ="Invalid Credentials...";
			return $message;
		}		

	}

	public function checksetdata($pass){
		$db=static::getDB();
		$message="";
		$q="SELECT * FROM `setting` WHERE Password='$pass' ";
		$check=mysqli_query($db,$q);
		if(mysqli_fetch_array($check)){
		 	header('location:/settings/index');
		}
		else{
			$message ="Invalid Credentials...";
			return $message;
		}		

	}

/*  ------End Login Page------   */


/*  ------Dashboard Section------   */

	public function viewallrecord()
	{
		$db=static::getDB();
		$employee_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM register"),MYSQLI_ASSOC);
		$supplier_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM supplier"),MYSQLI_ASSOC);
		$inventory_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stock"),MYSQLI_ASSOC);
		$supbill_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM suptransaction"),MYSQLI_ASSOC);
		$tentbill_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM tentbill"),MYSQLI_ASSOC);
		$caterbill_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM caterbill"),MYSQLI_ASSOC);
		$data=[
		'employee_data'=>$employee_data,
		'supplier_data'=>$supplier_data,
		'inventory_data'=>$inventory_data,
		'supbill_data'=>$supbill_data,
		'tentbill_data'=>$tentbill_data,
		'caterbill_data'=>$caterbill_data
		];
		return $data;
	}

/*  ------End Dashboard Section------   */







}
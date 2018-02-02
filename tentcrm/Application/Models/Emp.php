<?php
namespace application\Models;
use PDO;
class Emp extends \Core\Model
{

	public function registeremployee($data){
		$db=static::getDB();
		$message="";
		$eid=$data['eid'];
		$fname=$data['fname'];
		$lname=$data['lname'];
		$contact=$data['contact'];
		$acontact=$data['acontact'];
		$email=$data['email'];
		$dob=$data['dob'];
		$gender=$data['gender'];
		$address=$data['address'];
		$designation=$data['designation'];
		$salbasis=$data['salbasis'];
		$samount=$data['samount'];
		$joindate=$data['joindate'];

		$q="INSERT INTO `empregister`(`Eid`, `Fname`, `Lname`, `Contact`, `Acontact`, `Email`, `Dob`, `Gender`, `Address`, `Designation`, `Salbasis`, `Salamount`, `Joindate`) VALUES ('$eid','$fname','$lname','$contact','$acontact','$email','$dob','$gender','$address','$designation','$salbasis','$samount','$joindate')";
		$check=mysqli_query($db,$q);

		if($check){
			$message="New employee registerd successfully";
		}
		else{
			$message="Registring new employee record failed";
		}
		return $message;
	}

	public function viewrecord(){
		$db=static::getDB();
		$q="SELECT * FROM `empregister`";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getemprecord($eid){
		$db=static::getDB();
		$q="SELECT * FROM `empregister` WHERE Eid='$eid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updateemployee($data){
		$db=static::getDB();
		$message="";
		$eid=$data['eid'];
		$fname=$data['fname'];
		$lname=$data['lname'];
		$contact=$data['contact'];
		$acontact=$data['acontact'];
		$email=$data['email'];
		$dob=$data['dob'];
		$gender=$data['gender'];
		$address=$data['address'];
		$designation=$data['designation'];
		$salbasis=$data['salbasis'];
		$samount=$data['samount'];
		$joindate=$data['joindate'];

		$q="UPDATE `empregister` SET `Fname`='$fname',`Lname`='$lname',`Contact`='$contact',`Acontact`='$acontact',`Email`='$email',`Dob`='$dob',`Gender`='$gender',`Address`='$address',`Designation`='$designation',`Salbasis`='$salbasis',`Salamount`='$samount',`Joindate`='$joindate' WHERE `Eid`='$eid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Employee record updated successfully";
		}
		else{
			$message="Updating employee record failed";
		}
		return $message;
	}	

	public function deleteemprecord($eid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `empregister` WHERE Eid='$eid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Employee record successfully deleted";
		}
		else{
			$message="Deleting employee record failed";
		}
		return $message;
	}

	public function getemplopname($eid){
		$db=static::getDB();
		$q="SELECT * FROM empregister WHERE Fname LIKE '%".$eid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function getempstrecord($eid,$d1,$d2){
		$db=static::getDB();
		$edata=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `empregister` WHERE Eid='$eid'"));
		$pdays=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Attendance) AS Attendance FROM `empdailyattd` WHERE Eid='$eid' AND (Adate>='$d1' AND Adate<'$d2')"));
		$pamt=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amount) AS Amount FROM `empsalarydetail` WHERE (Eid='$eid') AND (Paydate>='$d1' AND Paydate<='$d2')"));
		$data=[
		'edata'=>$edata,
		'pdays'=>$pdays,
		'pamt'=>$pamt
		];
		return $data;
	}

	public function addpayment($data){
		$db=static::getDB();
		$message="";
		$eid=$data['eid'];
		$ename=$data['ename'];
		$desig=$data['desig'];
		$salbase=$data['salbase'];
		$salamt=$data['salamt'];
		$dura1=$data['dura1'];
		$dura2=$data['dura2'];
		$wdays=$data['wdays'];
		$attend=$data['attend'];
		$tamt=$data['tamt'];
		if ($data['paid'] == "") {
			$paid = '0';
		}
		else{
			$paid=$data['paid'];			
		}
		$amtbal=$data['amtbal'];
		$amtpaid=$data['amtpaid'];
		$paydt=$data['paydt'];
		$pmode=$data['pmode'];
		$amtp=$paid+$amtpaid;
		$bala=$amtbal-$amtpaid;

		$query="SELECT * FROM empsalary WHERE (Eid='$eid') AND (Duration1='$dura1') AND (Duration2='$dura2')";
		$result=mysqli_query($db,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$c="UPDATE `empsalary` SET `Ename`='$ename',`Designation`='$desig',`Salbasis`='$salbase',`Salamount`='$salamt',
			`Wdays`='$wdays',`Pdays`='$attend',`Pamount`='$tamt',`Paid`='$amtp',`Balance`='$bala' 
			WHERE (Eid='$eid') AND (Duration1='$dura1') AND (Duration2='$dura2')";
			$query=mysqli_query($db,$c);		  
		}
		else {
		 	$c="INSERT INTO `empsalary`(`Eid`, `Ename`, `Designation`, `Salbasis`, `Salamount`, `Duration1`, `Duration2`,
		 	 `Wdays`, `Pdays`, `Pamount`, `Paid`, `Balance`) VALUES ('$eid','$ename','$desig','$salbase',
		 	 '$salamt','$dura1','$dura2','$wdays','$attend','$tamt','$amtp','$bala')";
		 	$query=mysqli_query($db,$c);
		}

		$r="INSERT INTO `empsalarydetail`(`Eid`, `Duration1`, `Duration2`, `Paydate`, `Mode`, `Amount`) 
		VALUES ('$eid','$dura1','$dura2','$paydt','$pmode','$amtpaid')";
		$check=mysqli_query($db,$r);
		if($check && $query){
			$message="Payment Added Successfully";
		}
		else{
			$message="Adding Payment Failed";
		}
		return $message;
	}

	public function getemppayrcd($eid){
		$db=static::getDB();
		$detail=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `empregister` WHERE (Eid='$eid')"));
		$record=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM `empsalary` WHERE (Eid='$eid') ORDER BY Sno DESC"),MYSQLI_ASSOC);
		$edata=[
		'detail'=>$detail,
		'record'=>$record
		];
		return $edata;
	}

	public function getpaydetailrcd($eid,$d1,$d2){
		$db=static::getDB();
		$q="SELECT * FROM `empsalarydetail` WHERE (Eid='$eid') AND (Duration1='$d1') AND (Duration2='$d2')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}


/*  ------End Employee Section------   */
}
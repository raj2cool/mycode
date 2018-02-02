<?php
namespace application\Models;
use PDO;
class Rnt extends \Core\Model
{
	public function registerrentor($data){
		$db=static::getDB();
		$message="";
		$rid=$data['rid'];
		$fname=$data['fname'];
		$lname=$data['lname'];
		$contact=$data['contact'];
		$acontact=$data['acontact'];
		$email=$data['email'];
		$dob=$data['dob'];
		$gender=$data['gender'];
		$address=$data['address'];
		$firmname=$data['firmname'];
		$fcontact=$data['fcontact'];
		$rtype=$data['rtype'];
		$faddress=$data['faddress'];
		$q="INSERT INTO `rentregister`(`Rid`, `Fname`, `Lname`, `Contact`, `Acontact`, `Email`, `Dob`, `Gender`, `Address`, `Firmname`, `Fcontact`, `Rtype`, `Faddress`) 
		VALUES ('$rid','$fname','$lname','$contact','$acontact','$email','$dob','$gender','$address','$firmname','$fcontact','$rtype','$faddress')";
		$check=mysqli_query($db,$q);
		$r="INSERT INTO `rentpayment`(`Rid`, `Fname`, `Lname`, `Rtype`, `Total`, `Paid`, `Balance`) 
		VALUES ('$rid','$fname','$lname','$rtype','0','0','0')";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="New rentor registered successfully";
		}
		else{
			$message="Resistration of new rentor Failed";
		}
		return $message;
	}

	public function viewrentrecord(){
		$db=static::getDB();
		$q="SELECT * FROM `rentregister`";
		$check=mysqli_query($db,$q);
		$data=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $data;
	}

	public function getrentrecord($rid){
		$db=static::getDB();
		$q="SELECT * FROM `rentregister` WHERE Rid='$rid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updaterentor($data){
		$db=static::getDB();
		$message="";
		$rid=$data['rid'];
		$fname=$data['fname'];
		$lname=$data['lname'];
		$contact=$data['contact'];
		$acontact=$data['acontact'];
		$email=$data['email'];
		$dob=$data['dob'];
		$gender=$data['gender'];
		$address=$data['address'];
		$firmname=$data['firmname'];
		$fcontact=$data['fcontact'];
		$rtype=$data['rtype'];
		$faddress=$data['faddress'];

		$q="UPDATE `rentregister` SET `Fname`='$fname',`Lname`='$lname',`Contact`='$contact',`Acontact`='$acontact',`Email`='$email',`Dob`='$dob',`Gender`='$gender',`Address`='$address',`Firmname`='$firmname',`Fcontact`='$fcontact',`Rtype`='$rtype',`Faddress`='$faddress' WHERE `Rid`='$rid'";			
		$check=mysqli_query($db,$q);
		$r="UPDATE `rentpayment` SET `Fname`='$fname',`Lname`='$lname',`Rtype`='$rtype' WHERE `Rid`='$rid'";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="Rentor detail updated successfully";
		}
		else{
			$message="Updating rentor detail failed";
		}
		return $message;
	}

	public function deleterentrecord($rid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `rentregister` WHERE (Rid='$rid') ";
		$check=mysqli_query($db,$q);
		$r="DELETE FROM `rentpayment` WHERE (Rid='$rid')";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="Rentor record deleted successfully";
		}
		else{
			$message="Deleting rentor record failed";
		}
		return $message;
	}

	public function getrentoridname($rid){
		$db=static::getDB();
		$q="SELECT * FROM rentregister WHERE Fname LIKE '%".$rid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function itemtabletrans($rid,$bno,$date,$pname,$desc,$cost,$days){
		$db=static::getDB();
		$amount=$cost*$days;
		$u="INSERT INTO `rentitembilldetail`(`Date`, `Bno`, `Rid`, `Pname`, `Dsc`, `Rate`, `Ndays`, `Amount`) VALUES 
		('$date','$bno','$rid','$pname','$desc','$cost','$days','$amount')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `rentitembilldetail` WHERE (Bno='$bno') AND (Rid='$rid')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function itembilltransaction($rid,$rname,$bno,$date,$amt,$adv,$bal){
		$db=static::getDB();
		$message="";
		$q="INSERT INTO `rentitembill`(`Rid`, `Rname`, `Date`, `Bno`, `Amt`, `Adv`, `Bal`) VALUES ('$rid','$rname','$date','$bno','$amt','$adv','$bal')";
		$check=mysqli_query($db,$q);
		$p="SELECT * FROM `rentpayment` WHERE Rid='$rid'";
		$data=mysqli_query($db,$p);
		$row=mysqli_fetch_array($data);
		$amtt=$row['Total']+$amt;
		$advv=$row['Paid']+$adv;
		$ball=$row['Balance']+$bal;
		$r="UPDATE `rentpayment` SET `Total`='$amtt',`Paid`='$advv',`Balance`='$ball' WHERE `Rid`='$rid'";
		$query=mysqli_query($db,$r);
		if($query && $check){
			$message="Item Bill Added Successfully";
		}
		else{
			$message="Adding Item Bill Failed";
		}
		return $message;
	}

	public function getitembillrcd($rid){
		$db=static::getDB();
		$q="SELECT * FROM `rentitembill` WHERE (Rid='$rid') ORDER BY Sno DESC";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getitembillrecord($bno,$rid){
		$db=static::getDB();
		$q="SELECT * FROM `rentitembilldetail` WHERE (Bno='$bno') AND (Rid='$rid')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getitembillpay($rid){
		$db=static::getDB();
		$q="SELECT * FROM `rentpayment` WHERE Rid='$rid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function additembpayment($data){
		$db=static::getDB();
		$message="";
		$rid=$data['rid'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];
		$p="INSERT INTO `rentpaydetail`(`Rid`, `Date`, `Mode`, `Amt`) VALUES ('$rid','$paydt','$mode','$payamt')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `rentpayment` WHERE Rid='$rid'";
		$data=mysqli_query($db,$q);
		$row=mysqli_fetch_array($data);
		$advv=$row['Paid']+$payamt;
		$ball=$row['Balance']-$payamt;
		$r="UPDATE `rentpayment` SET `Paid`='$advv',`Balance`='$ball' WHERE `Rid`='$rid'";
		$check=mysqli_query($db,$r);
		if($check && $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function paymnetbilldatadetail($rid){
		$db=static::getDB();
		$q="SELECT * FROM `rentpaydetail` WHERE Rid='$rid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}
}
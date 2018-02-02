<?php
namespace application\Models;
use PDO;
class Supp extends \Core\Model
{
	public function registersupplier($data){
		$db=static::getDB();
		$message="";
		$sid=$data['sid'];
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
		$stype=$data['stype'];
		$faddress=$data['faddress'];
		$q="INSERT INTO `supregister`(`Sid`, `Fname`, `Lname`, `Contact`, `Acontact`, `Email`, `Dob`, `Gender`, `Address`, `Firmname`, `fcontact`, `Stype`, `Faddress`) 
		VALUES ('$sid','$fname','$lname','$contact','$acontact','$email','$dob','$gender','$address','$firmname','$fcontact','$stype','$faddress')";
		$check=mysqli_query($db,$q);
		$r="INSERT INTO `suppayment`(`Sid`, `Fname`, `Lname`, `Stype`, `Total`, `Paid`, `Balance`) 
		VALUES ('$sid','$fname','$lname','$stype','0','0','0')";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="New supplier registered successfully";
		}
		else{
			$message="Resistration of new supplier Failed";
		}
		return $message;
	}

	public function viewsuprecord(){
		$db=static::getDB();
		$q="SELECT * FROM `supregister`";
		$check=mysqli_query($db,$q);
		$data=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $data;
	}

	public function getsuprecord($sid){
		$db=static::getDB();
		$q="SELECT * FROM `supregister` WHERE Sid='$sid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updatesupplier($data){
		$db=static::getDB();
		$message="";
		$sid=$data['sid'];
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
		$stype=$data['stype'];
		$faddress=$data['faddress'];

		$q="UPDATE `supregister` SET `Fname`='$fname',`Lname`='$lname',`Contact`='$contact',`Acontact`='$acontact',`Email`='$email',`Dob`='$dob',`Gender`='$gender',`Address`='$address',`Firmname`='$firmname',`Fcontact`='$fcontact',`Stype`='$stype',`Faddress`='$faddress' WHERE `Sid`='$sid'";			
		$check=mysqli_query($db,$q);
		$r="UPDATE `suppayment` SET `Fname`='$fname',`Lname`='$lname',`Stype`='$stype' WHERE `Sid`='$sid'";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="Supplier detail updated successfully";
		}
		else{
			$message="Updating supplier detail failed";
		}
		return $message;
	}

	public function deletesuprecord($sid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `supregister` WHERE (Sid='$sid')";
		$check=mysqli_query($db,$q);
		$r="DELETE FROM `suppayment` WHERE (Sid='$sid')";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="Supplier record deleted successfully";
		}
		else{
			$message="Deleting supplier record failed";
		}
		return $message;
	}

	public function getitemsupidname($sid){
		$db=static::getDB();
		$q="SELECT * FROM supregister WHERE Fname LIKE '%".$sid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function getitempname($pname){
		$db=static::getDB();
		$tname=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stocktent WHERE Pname LIKE '%".$pname."%'"),MYSQLI_ASSOC);
		$cname=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockcatering WHERE Pname LIKE '%".$pname."%'"),MYSQLI_ASSOC);
		$oname=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockother WHERE Pname LIKE '%".$pname."%'"),MYSQLI_ASSOC);
		$data=[
		'tname'=>$tname,
		'cname'=>$cname,
		'oname'=>$oname
		];
		return $data;
	}

	public function itemtabletrans($sid,$bno,$date,$pname,$qty,$unit,$cost){
		$db=static::getDB();
		$quantity="$qty$unit";
		$amount=$cost*$qty;
		$u="INSERT INTO `supitembilldetail`(`Date`, `Bno`, `Sid`, `Pname`, `Cost`, `Qty`, `Amt`) VALUES ('$date','$bno','$sid','$pname','$cost','$quantity','$amount')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `supitembilldetail` WHERE (Bno='$bno') AND (Sid='$sid')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function itembilltransaction($sid,$sname,$bno,$date,$amt,$adv,$bal){
		$db=static::getDB();
		$message="";
		$q="INSERT INTO `supitembill`(`Sid`, `Sname`, `Date`, `Bno`, `Amt`, `Adv`, `Bal`) VALUES ('$sid','$sname','$date','$bno','$amt','$adv','$bal')";
		$check=mysqli_query($db,$q);
		$p="SELECT * FROM `suppayment` WHERE Sid='$sid'";
		$data=mysqli_query($db,$p);
		$row=mysqli_fetch_array($data);
		$amtt=$row['Total']+$amt;
		$advv=$row['Paid']+$adv;
		$ball=$row['Balance']+$bal;
		$r="UPDATE `suppayment` SET `Total`='$amtt',`Paid`='$advv',`Balance`='$ball' WHERE `Sid`='$sid'";
		$query=mysqli_query($db,$r);
		if($query && $check){
			$message="Item Bill Added Successfully";
		}
		else{
			$message="Adding Item Bill Failed";
		}
		return $message;
	}

	public function workertabletrans($sid,$bno,$date,$name,$age,$type,$cost){
		$db=static::getDB();
		$u="INSERT INTO `supworkbilldetail`(`Date`, `Bno`, `Sid`, `Name`, `Age`, `Type`, `Rate`) VALUES ('$date','$bno','$sid','$name','$age','$type','$cost')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `supworkbilldetail` WHERE (Bno='$bno') AND (Sid='$sid')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function workerbilltransaction($sid,$sname,$bno,$date,$amt,$adv,$bal){
		$db=static::getDB();
		$q="INSERT INTO `supworkbill`(`Sid`, `Sname`, `Date`, `Bno`, `Amt`, `Adv`, `Bal`) VALUES ('$sid','$sname','$date','$bno','$amt','$adv','$bal')";
		$check=mysqli_query($db,$q);
		$p="SELECT * FROM `suppayment` WHERE Sid='$sid'";
		$data=mysqli_query($db,$p);
		$row=mysqli_fetch_array($data);
		$amtt=$row['Total']+$amt;
		$advv=$row['Paid']+$adv;
		$ball=$row['Balance']+$bal;
		$r="UPDATE `suppayment` SET `Total`='$amtt',`Paid`='$advv',`Balance`='$ball' WHERE `Sid`='$sid'";
		$query=mysqli_query($db,$r);
		if($check && $query){
			$message="Worker Bill Added Successfully";
		}
		else{
			$message="Adding Worker Bill Failed";
		}
		return $message;
	}

	public function getitemsupbillrcd($sid){
		$db=static::getDB();
		$q="SELECT * FROM `supitembill` WHERE (Sid='$sid') ORDER BY Sno DESC";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getitembillrecord($billno,$sid){
		$db=static::getDB();
		$q="SELECT * FROM `supitembilldetail` WHERE (Bno='$billno') AND (Sid='$sid')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getworksupbillrcd($sid){
		$db=static::getDB();
		$q="SELECT * FROM `supworkbill` WHERE (Sid='$sid') ORDER BY Sno DESC";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getworkbillrecord($billno,$sid){
		$db=static::getDB();
		$q="SELECT * FROM `supworkbilldetail` WHERE (Bno='$billno') AND (Sid='$sid')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getsuppay($sid){
		$db=static::getDB();
		$q="SELECT * FROM `suppayment` WHERE Sid='$sid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function addsuppayment($data){
		$db=static::getDB();
		$sid=$data['sid'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];
		$p="INSERT INTO `suppaydetail`(`Sid`, `Date`, `Mode`, `Amt`) VALUES ('$sid','$paydt','$mode','$payamt')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `suppayment` WHERE Sid='$sid'";
		$data=mysqli_query($db,$q);
		$row=mysqli_fetch_array($data);
		$advv=$row['Paid']+$payamt;
		$ball=$row['Balance']-$payamt;
		$r="UPDATE `suppayment` SET `Paid`='$advv',`Balance`='$ball' WHERE `Sid`='$sid'";
		$check=mysqli_query($db,$r);
		if($check & $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function getpaidsupdata($sid){
		$db=static::getDB();
		$q="SELECT * FROM `suppaydetail` WHERE Sid='$sid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

}
<?php
namespace application\Models;
use PDO;
class Sett extends \Core\Model
{

/* -------Setting Section-------  */

	public function viewbill(){
		$db=static::getDB();
		$tent=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `setting` WHERE `No`='1'"));
		$cater=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `setting` WHERE `No`='2'"));
		$estimate=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `setting` WHERE `No`='3'"));
		$data=[
		'tent'=>$tent,
		'cater'=>$cater,
		'estimate'=>$estimate
		];
		return $data;
	}

	public function settentbill($data){
		$db=static::getDB();
		$message="";
		$btype=$data['btype'];
		$header1=$data['header1'];
		$header2=$data['header2'];
		$header3=$data['header3'];
		$terms=$data['terms'];
		$footer1=$data['footer1'];
		$footer2=$data['footer2'];

		$q="UPDATE `setting` SET `Btype`='$btype',`Header1`='$header1',`Header2`='$header2',`Header3`='$header3',`Terms`='$terms',`Footer1`='$footer1',`Footer2`='$footer2' WHERE `No`='1'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Tent bill settings updated successfully";
		}
		else{
			$message="Updating tent bill settings failed";
		}
		return $message;
	}

	public function setcaterbill($data){
		$db=static::getDB();
		$message="";
		$btype=$data['btype'];
		$header1=$data['header1'];
		$header2=$data['header2'];
		$header3=$data['header3'];
		$terms=$data['terms'];
		$footer1=$data['footer1'];
		$footer2=$data['footer2'];

		$q="UPDATE `setting` SET `Btype`='$btype',`Header1`='$header1',`Header2`='$header2',`Header3`='$header3',`Terms`='$terms',`Footer1`='$footer1',`Footer2`='$footer2' WHERE `No`='2'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Cater bill settings updated successfully";
		}
		else{
			$message="Updating cater bill settings failed";
		}
		return $message;
	}

	public function setestimatebill($data){
		$db=static::getDB();
		$message="";
		$btype=$data['btype'];
		$header1=$data['header1'];
		$header2=$data['header2'];
		$header3=$data['header3'];
		$terms=$data['terms'];
		$footer1=$data['footer1'];
		$footer2=$data['footer2'];

		$q="UPDATE `setting` SET `Btype`='$btype',`Header1`='$header1',`Header2`='$header2',`Header3`='$header3',`Terms`='$terms',`Footer1`='$footer1',`Footer2`='$footer2' WHERE `No`='3'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Estimate bill settings updated successfully";
		}
		else{
			$message="Updating estimate bill settings failed";
		}
		return $message;
	}

	public function setpass($data){
		$db=static::getDB();
		$message="";
		$opwd=$data['opwd'];
		$npwd1=$data['npwd1'];

		$q="UPDATE `setting` SET `Password`='$npwd1' WHERE `Password`='$opwd'";
		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Password Changed Successfully";
		}
		else{
			$message="Old Password not matched";
		}
		return $message;
	}

/* -------End Setting Section-------  */

}
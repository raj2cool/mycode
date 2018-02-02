<?php
namespace application\Models;
use PDO;
class Invent extends \Core\Model
{

/*  ------Inventory Section------   */

	public function regtentinventory($data){
		$db=static::getDB();
		$message="";
		$tpid=$data['tpid'];
		$tpname=$data['tpname'];
		$tqty=$data['tqty'];
		$tunit=$data['tunit'];
		$tcp=$data['tcp'];
		$tbp=$data['tbp'];

		$q="INSERT INTO `stocktent`(`Pid`, `Pname`, `Qty`, `Unit`, `Cp`, `Bp`) VALUES ('$tpid','$tpname','$tqty','$tunit','$tcp','$tbp')";

		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Tent item added successfully";
		}
		else{
			$message="Adding tent item failed";
		}
		return $message;
	}
	public function regcaterinventory($data){
		$db=static::getDB();
		$message="";
		$cpid=$data['cpid'];
		$cpname=$data['cpname'];
		$cqty=$data['cqty'];
		$cunit=$data['cunit'];
		$ccp=$data['ccp'];

		$q="INSERT INTO `stockcatering`(`Pid`, `Pname`, `Qty`, `Unit`, `Cp`) VALUES ('$cpid','$cpname','$cqty','$cunit','$ccp')";

		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Cater item added successfully";
		}
		else{
			$message="Adding cater item failed";
		}
		return $message;
	}

	public function regmenuinventory($data){
		$db=static::getDB();
		$message="";
		$mpid=$data['mpid'];
		$mtype=$data['mtype'];
		$smtype=$data['smtype'];
		$mpname=$data['mpname'];
		$mcp=$data['mcp'];
		$mbp=$data['mbp'];

		$q="INSERT INTO `stockmenu`(`Pid`, `Mtype`, `Smtype`, `Pname`, `Cp`, `Bp`) VALUES ('$mpid','$mtype','$smtype','$mpname','$mcp','$mbp')";

		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Menu item added successfully";
		}
		else{
			$message="Adding menu item failed";
		}
		return $message;
	}

	public function regdecorinventory($data){
		$db=static::getDB();
		$message="";
		$dpid=$data['dpid'];
		$dsname=$data['dsname'];
		$dcp=$data['dcp'];
		$dbp=$data['dbp'];

		$q="INSERT INTO `stockdecoration`(`Pid`, `Sname`, `Cp`, `Bp`) VALUES ('$dpid','$dsname','$dcp','$dbp')";

		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Decoration item added successfully";
		}
		else{
			$message="Adding decoration item failed";
		}
		return $message;
	}

	public function regotherinventory($data){
		$db=static::getDB();
		$message="";
		$opid=$data['opid'];
		$opname=$data['opname'];
		$oqty=$data['oqty'];
		$ounit=$data['ounit'];
		$ocp=$data['ocp'];

		$q="INSERT INTO `stockother`(`Pid`, `Pname`, `Qty`, `Unit`, `Cp`) VALUES ('$opid','$opname','$oqty','$ounit','$ocp')";

		$check=mysqli_query($db,$q);
		if(mysqli_affected_rows($db)){
			$message="Other item added successfully";
		}
		else{
			$message="Adding other item failed";
		}
		return $message;
	}


	public function viewinventoryrecord(){
		$db=static::getDB();
		$tent_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stocktent"),MYSQLI_ASSOC);
		$cater_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockcatering"),MYSQLI_ASSOC);
		$menu_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockmenu"),MYSQLI_ASSOC);
		$decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockdecoration"),MYSQLI_ASSOC);
		$other_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM stockother"),MYSQLI_ASSOC);
		$data=[
		'tent_data'=>$tent_data,
		'cater_data'=>$cater_data,
		'menu_data'=>$menu_data,
		'decor_data'=>$decor_data,
		'other_data'=>$other_data
		];
		return $data;
	}

	public function gettentrecord($pid){
		$db=static::getDB();
		$q="SELECT * FROM `stocktent` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updatetentinv($data){
		$db=static::getDB();
		$message="";
		$pid=$data['pid'];
		$tpname=$data['tpname'];
		$tqty=$data['tqty'];
		$tunit=$data['tunit'];
		$tcp=$data['tcp'];
		$tbp=$data['tbp'];

		$q="UPDATE `stocktent` SET `Pname`='$tpname',`Qty`='$tqty',`Unit`='$tunit',`Cp`='$tcp',`Bp`='$tbp' WHERE `Pid`='$pid'";

		$check=mysqli_query($db,$q);
		if($check){
			$message="Tent item updated successfully";
		}
		else{
			$message="Updating tent item failed";
		}
		return $message;
	}

	public function deletetentinvrec($pid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `stocktent` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Tent item deleted successfully";
		}
		else{
			$message="Deleting tent item failed";
		}
		return $message;
	}

	public function getcaterrecord($pid){
		$db=static::getDB();
		$q="SELECT * FROM `stockcatering` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updatecaterinv($data){
		$db=static::getDB();
		$message="";
		$pid=$data['pid'];
		$cpname=$data['cpname'];
		$cqty=$data['cqty'];
		$cunit=$data['cunit'];
		$ccp=$data['ccp'];

		$q="UPDATE `stockcatering` SET `Pname`='$cpname',`Qty`='$cqty',`Unit`='$cunit',`Cp`='$ccp' WHERE `Pid`='$pid'";

		$check=mysqli_query($db,$q);
		if($check){
			$message="Cater item updated successfully";
		}
		else{
			$message="Updating cater item failed";
		}
		return $message;
	}

	public function deletecaterinvrec($pid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `stockcatering` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Cater item deleted successfully";
		}
		else{
			$message="Deleting cater item failed";
		}
		return $message;
	}

	public function getmenurecord($pid){
		$db=static::getDB();
		$q="SELECT * FROM `stockmenu` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;

	}

	public function updatemenuinv($data){
		$db=static::getDB();
		$message="";
		$pid=$data['pid'];
		$mtype=$data['mtype'];
		$smtype=$data['smtype'];
		$mpname=$data['mpname'];
		$mcp=$data['mcp'];
		$mbp=$data['mbp'];

		$q="UPDATE `stockmenu` SET `Mtype`='$mtype',`Smtype`='$smtype',`Pname`='$mpname',`Cp`='$mcp',`Bp`='$mbp' WHERE `Pid`='$pid'";

		$check=mysqli_query($db,$q);
		if($check){
			$message="Menu item updated successfully";
		}
		else{
			$message="Updating menu item failed";
		}
		return $message;
	}

	public function deletemenuinvrec($pid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `stockmenu` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Menu item deleted successfully";
		}
		else{
			$message="Deleting menu item failed";
		}
		return $message;
	}

	public function getdecorecord($pid){
		$db=static::getDB();
		$q="SELECT * FROM `stockdecoration` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updatedecoinv($data){
		$db=static::getDB();
		$message="";
		$pid=$data['pid'];
		$dsname=$data['dsname'];
		$dcp=$data['dcp'];
		$dbp=$data['dbp'];

		$q="UPDATE `stockdecoration` SET `Sname`='$dsname',`Cp`='$dcp',`Bp`='$dbp' WHERE `Pid`='$pid'";

		$check=mysqli_query($db,$q);
		if($check){
			$message="Decoration item updated successfully";
		}
		else{
			$message="Updating decoration item failed";
		}
		return $message;
	}

	public function deletedecoinvrec($pid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `stockdecoration` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Decoration item deleted successfully";
		}
		else{
			$message="Deleting decoration item failed";
		}
		return $message;
	}

	public function getotherrecord($pid){
		$db=static::getDB();
		$q="SELECT * FROM `stockother` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function updateotherinv($data){
		$db=static::getDB();
		$message="";
		$pid=$data['pid'];
		$opname=$data['opname'];
		$oqty=$data['oqty'];
		$ounit=$data['ounit'];
		$ocp=$data['ocp'];

		$q="UPDATE `stockother` SET `Pname`='$opname',`Qty`='$oqty',`Unit`='$ounit',`Cp`='$ocp' WHERE `Pid`='$pid'";

		$check=mysqli_query($db,$q);
		if($check){
			$message="Other item updated successfully";
		}
		else{
			$message="Updating other item failed";
		}
		return $message;
	}

	public function deleteotherinvrec($pid){
		$db=static::getDB();
		$message="";
		$q="DELETE FROM `stockother` WHERE Pid='$pid'";
		$check=mysqli_query($db,$q);
		if($check){
			$message="Other item deleted successfully";
		}
		else{
			$message="Deleting other item failed";
		}
		return $message;
	}

	public function gettentitempname($pid){
		$db=static::getDB();
		$q="SELECT * FROM stocktent WHERE Pname LIKE '%".$pid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function addtentqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$incqty=$data['incqty'];
		$q="SELECT * FROM `stocktent` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$incqty=$row['Qty']+$incqty;
		$r="UPDATE `stocktent` SET `Qty`='$incqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Incoming tent quantity added successfully";
		}
		else{
			$message="Adding incoming tent quantity failed";
		}
		return $message;
	}

	public function getcateritempname($pid){
		$db=static::getDB();
		$q="SELECT * FROM stockcatering WHERE Pname LIKE '%".$pid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function addcaterqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$incqty=$data['incqty'];
		$q="SELECT * FROM `stockcatering` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$incqty=$row['Qty']+$incqty;
		$r="UPDATE `stockcatering` SET `Qty`='$incqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Incoming cater quantity added successfully";
		}
		else{
			$message="Adding incoming cater quantity failed";
		}
		return $message;
	}

	public function getotheritempname($pid){
		$db=static::getDB();
		$q="SELECT * FROM stockother WHERE Pname LIKE '%".$pid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function addotherqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$incqty=$data['incqty'];
		$q="SELECT * FROM `stockother` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$incqty=$row['Qty']+$incqty;
		$r="UPDATE `stockother` SET `Qty`='$incqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Incoming other quantity added successfully";
		}
		else{
			$message="Adding incoming other quantity failed";
		}
		return $message;
	}

	public function subtentqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$decqty=$data['decqty'];
		$q="SELECT * FROM `stocktent` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$decqty=$row['Qty']-$decqty;
		$r="UPDATE `stocktent` SET `Qty`='$decqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Outgoing tent quantity subtracted successfully";
		}
		else{
			$message="Subtracting outgoing tent quantity failed";
		}
		return $message;
	}

	public function subcaterqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$decqty=$data['decqty'];
		$q="SELECT * FROM `stockcatering` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$decqty=$row['Qty']-$decqty;
		$r="UPDATE `stockcatering` SET `Qty`='$decqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Outgoing cater quantity subtracted successfully";
		}
		else{
			$message="Subtracting outgoing cater quantity failed";
		}
		return $message;
	}

	public function subotherqty($data){
		$db=static::getDB();
		$pid=$data['pid'];
		$decqty=$data['decqty'];
		$q="SELECT * FROM `stockother` WHERE `Pid`='$pid'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$decqty=$row['Qty']-$decqty;
		$r="UPDATE `stockother` SET `Qty`='$decqty' WHERE `Pid`='$pid'";
		$check=mysqli_query($db,$r);
		if($check){
			$message="Outgoing other quantity subtracted successfully";
		}
		else{
			$message="Subtracting outgoing other quantity failed";
		}
		return $message;
	}

/*  ------End Inventory Section------   */

}
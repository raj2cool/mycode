<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Invent;
class Inventory extends \Core\Controller
{
	public function indexAction(){
		$edata=Invent::viewinventoryrecord();
		$tentdata=$edata['tent_data'];
		$caterdata=$edata['cater_data'];
		$menudata=$edata['menu_data'];
		$decordata=$edata['decor_data'];
		$otherdata=$edata['other_data'];
		View::renderTemplate('inventory.html',['tentdata'=>$tentdata,'caterdata'=>$caterdata,'menudata'=>$menudata,'decordata'=>$decordata,'otherdata'=>$otherdata]);
	}	


	public function regtent(){
		$tpname=$_POST['tpname'];
		$tqty=$_POST['tqty'];
		$tunit=$_POST['tunit'];
		$tcp=$_POST['tcp'];
		$tbp=$_POST['tbp'];
		$t=rand(1000,9999);
		$tpid="T$tpname[0]-$t";
		$data=[
		'tpid'=>$tpid,
		'tpname'=>$tpname,
		'tqty'=>$tqty,
		'tunit'=>$tunit,
		'tcp'=>$tcp,
		'tbp'=>$tbp
		];
		$submitdata=Invent::regtentinventory($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
		
	}

	public function regcater(){
		$cpname=$_POST['cpname'];
		$cqty=$_POST['cqty'];
		$cunit=$_POST['cunit'];
		$ccp=$_POST['ccp'];
		$t=rand(1000,9999);
		$cpid="C$cpname[0]-$t";
		$data=[
		'cpid'=>$cpid,
		'cpname'=>$cpname,
		'cqty'=>$cqty,
		'cunit'=>$cunit,
		'ccp'=>$ccp
		];
		$submitdata=Invent::regcaterinventory($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function regmenu(){
		$mtype=$_POST['mtype'];
		$smtype=$_POST['smtype'];
		$mpname=$_POST['mpname'];
		$mcp=$_POST['mcp'];
		$mbp=$_POST['mbp'];
		$t=rand(1000,9999);
		$mpid="M$mtype[0]$smtype[0]$mpname[0]-$t";
		$data=[
		'mpid'=>$mpid,
		'mtype'=>$mtype,
		'smtype'=>$smtype,
		'mpname'=>$mpname,
		'mcp'=>$mcp,
		'mbp'=>$mbp
		];
		$submitdata=Invent::regmenuinventory($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function regdecor(){
		$dsname=$_POST['dsname'];
		$dcp=$_POST['dcp'];
		$dbp=$_POST['dbp'];
		$t=rand(1000,9999);
		$dpid="D$dsname[0]-$t";
		$data=[
		'dpid'=>$dpid,
		'dsname'=>$dsname,
		'dcp'=>$dcp,
		'dbp'=>$dbp
		];
		$submitdata=Invent::regdecorinventory($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function regother(){
		$opname=$_POST['opname'];
		$oqty=$_POST['oqty'];
		$ounit=$_POST['ounit'];
		$ocp=$_POST['ocp'];
		$t=rand(1000,9999);
		$opid="O$opname[0]-$t";
		$data=[
		'opid'=>$opid,
		'opname'=>$opname,
		'oqty'=>$oqty,
		'ounit'=>$ounit,
		'ocp'=>$ocp
		];
		$submitdata=Invent::regotherinventory($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function teditAction(){
		$pid=$_GET['pid'];		
		$edata=Invent::gettentrecord($pid);
		View::renderTemplate('invedittent.html',['edata'=>$edata]);
	}

	public function tupdate(){
		$pid=$_POST['pid'];
		$tpname=$_POST['tpname'];
		$tqty=$_POST['tqty'];
		$tunit=$_POST['tunit'];
		$tcp=$_POST['tcp'];
		$tbp=$_POST['tbp'];
		$data=[
		'pid'=>$pid,
		'tpname'=>$tpname,
		'tqty'=>$tqty,
		'tunit'=>$tunit,
		'tcp'=>$tcp,
		'tbp'=>$tbp
		];
		$submitdata=Invent::updatetentinv($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function tdeleteAction(){
		$pid=$_GET['pid'];
		$edata=Invent::deletetentinvrec($pid);
		echo "<script>
		alert('$edata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function ceditAction(){
		$pid=$_GET['pid'];		
		$edata=Invent::getcaterrecord($pid);
		View::renderTemplate('inveditcater.html',['edata'=>$edata]);
	}

	public function cupdate(){
		$pid=$_POST['pid'];
		$cpname=$_POST['cpname'];
		$cqty=$_POST['cqty'];
		$cunit=$_POST['cunit'];
		$ccp=$_POST['ccp'];
		$data=[
		'pid'=>$pid,
		'cpname'=>$cpname,
		'cqty'=>$cqty,
		'cunit'=>$cunit,
		'ccp'=>$ccp,
		];
		$submitdata=Invent::updatecaterinv($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function cdeleteAction(){
		$pid=$_GET['pid'];
		$edata=Invent::deletecaterinvrec($pid);
		echo "<script>
		alert('$edata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function meditAction(){
		$pid=$_GET['pid'];	
		$edata=Invent::getmenurecord($pid);
		View::renderTemplate('inveditmenu.html',['edata'=>$edata]);
	}

	public function mupdate(){
		$pid=$_POST['pid'];
		$mtype=$_POST['mtype'];
		$smtype=$_POST['smtype'];
		$mpname=$_POST['mpname'];
		$mcp=$_POST['mcp'];
		$mbp=$_POST['mbp'];
		$data=[
		'pid'=>$pid,
		'mtype'=>$mtype,
		'smtype'=>$smtype,
		'mpname'=>$mpname,
		'mcp'=>$mcp,
		'mbp'=>$mbp
		];
		$submitdata=Invent::updatemenuinv($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function mdeleteAction(){
		$pid=$_GET['pid'];
		$edata=Invent::deletemenuinvrec($pid);
		echo "<script>
		alert('$edata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function deditAction(){
		$pid=$_GET['pid'];	
		$edata=Invent::getdecorecord($pid);
		View::renderTemplate('inveditdecor.html',['edata'=>$edata]);
	}

	public function dupdate(){
		$pid=$_POST['pid'];
		$dsname=$_POST['dsname'];
		$dcp=$_POST['dcp'];
		$dbp=$_POST['dbp'];
		$dmp=$_POST['dmp'];
		$data=[
		'pid'=>$pid,
		'dsname'=>$dsname,
		'dcp'=>$dcp,
		'dbp'=>$dbp,
		'dmp'=>$dmp
		];
		$submitdata=Invent::updatedecoinv($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function ddeleteAction(){
		$pid=$_GET['pid'];
		$edata=Invent::deletedecoinvrec($pid);
		echo "<script>
		alert('$edata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function oeditAction(){
		$pid=$_GET['pid'];		
		$edata=Invent::getotherrecord($pid);
		View::renderTemplate('inveditother.html',['edata'=>$edata]);
	}

	public function oupdate(){
		$pid=$_POST['pid'];
		$opname=$_POST['opname'];
		$oqty=$_POST['oqty'];
		$ounit=$_POST['ounit'];
		$ocp=$_POST['ocp'];
		$data=[
		'pid'=>$pid,
		'opname'=>$opname,
		'oqty'=>$oqty,
		'ounit'=>$ounit,
		'ocp'=>$ocp,
		];
		$submitdata=Invent::updateotherinv($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function odeleteAction(){
		$pid=$_GET['pid'];
		$edata=Invent::deleteotherinvrec($pid);
		echo "<script>
		alert('$edata');
		window.location.href='/inventory/index';
		</script>";
	}

	public function gettentpnameAction(){
		$pid=$_POST['pid'];
		$result=Invent::gettentitempname($pid);
		foreach ($result as $data){
			echo '<option value="'.$data['Pid'].'"> '.$data['Pname'].'</option>';
		}
	}

	public function addtentinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::gettentrecord($pid);
		echo 
			'<form method="post" action="tentaddon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Addon) :</label>
						    	<input type="text" class="form-control" name="qaddon" placeholder="Enter Quantity To Addon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function tentaddonAction(){
		$incqty=$_POST['qaddon'];
		$pid=$_POST['pid'];
		$data = [
			'incqty'=>$incqty,
			'pid'=>$pid
		];
		$message=Invent::addtentqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}

	public function getcaterpnameAction(){
		$pid=$_POST['pid'];
		$result=Invent::getcateritempname($pid);
		foreach ($result as $data){
			echo '<option value="'.$data['Pid'].'"> '.$data['Pname'].'</option>';
		}
	}

	public function addcaterinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::getcaterrecord($pid);
		echo 
			'<form method="post" action="cateraddon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Addon) :</label>
						    	<input type="text" class="form-control" name="cqaddon" placeholder="Enter Quantity To Addon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function cateraddon(){
		$incqty=$_POST['cqaddon'];
		$pid=$_POST['pid'];
		$data = [
			'incqty'=>$incqty,
			'pid'=>$pid
		];
		$message=Invent::addcaterqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}

	public function getotherpnameAction(){
		$pid=$_POST['pid'];
		$result=Invent::getotheritempname($pid);
		foreach ($result as $data){
			echo '<option value="'.$data['Pid'].'"> '.$data['Pname'].'</option>';
		}
	}

	public function addotherinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::getotherrecord($pid);
		echo 
			'<form method="post" action="otheraddon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Addon) :</label>
						    	<input type="text" class="form-control" name="oqaddon" placeholder="Enter Quantity To Addon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function otheraddon(){
		$incqty=$_POST['oqaddon'];
		$pid=$_POST['pid'];
		$data = [
			'incqty'=>$incqty,
			'pid'=>$pid
		];
		$message=Invent::addotherqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}

	public function subtentinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::gettentrecord($pid);
		echo 
			'<form method="post" action="tentsubon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Subon) :</label>
						    	<input type="text" class="form-control" name="tsubon" placeholder="Enter Quantity To Subon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function tentsubon(){
		$decqty=$_POST['tsubon'];
		$pid=$_POST['pid'];
		$data = [
			'decqty'=>$decqty,
			'pid'=>$pid
		];
		$message=Invent::subtentqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}

	public function subcaterinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::getcaterrecord($pid);
		echo 
			'<form method="post" action="catersubon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Subon) :</label>
						    	<input type="text" class="form-control" name="csubon" placeholder="Enter Quantity To Subon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function catersubon(){
		$decqty=$_POST['csubon'];
		$pid=$_POST['pid'];
		$data = [
			'decqty'=>$decqty,
			'pid'=>$pid
		];
		$message=Invent::subcaterqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}

	public function subotherinv(){
		$pid=$_POST['pid'];
		$getdetail=Invent::getotherrecord($pid);
		echo 
			'<form method="post" action="othersubon">
				<input type="hidden" name="pid" value="'.$pid.'">
				<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label for="pname">Product Name :</label>
						    	<input type="text" class="form-control" name="pname" value="'.$getdetail['Pname'].'" readonly>
							</div>							    
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
							<div>
								<label>Quntity (In-Stock) :</label>
								<input type="text" class="form-control" name="qstock" value="'.$getdetail['Qty'].' '.$getdetail['Unit'].'" readonly>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<div class="form-group" style="padding:0px 100px 0px 0px;">
						    <div>
								<label>Quantity (To-Subon) :</label>
						    	<input type="text" class="form-control" name="osubon" placeholder="Enter Quantity To Subon" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
					<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
					<input type="submit" value="Update" >
				</div>
			</form>';
	}

	public function othersubon(){
		$decqty=$_POST['osubon'];
		$pid=$_POST['pid'];
		$data = [
			'decqty'=>$decqty,
			'pid'=>$pid
		];
		$message=Invent::subotherqty($data);
		echo "<script>
		alert('$message');
		window.location.href='/inventory/index';
		</script>";
	}


}
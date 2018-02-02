<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Emp;
class Employee extends \Core\Controller
{	
	
	public function indexAction(){
		$edata=Emp::viewrecord();
		View::renderTemplate('employee.html',['edata'=>$edata]);
	}
		
	public function register(){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$contact=$_POST['contact'];
		$acontact=$_POST['acontact'];
		$email=$_POST['email'];
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];
		$address=$_POST['address'];
		$designation=$_POST['designation'];
		$salbasis=$_POST['salbasis'];
		$samount=$_POST['samount'];
		$joindate=$_POST['joindate'];
		$t=rand(1000,9999);
		$eid="$fname[0]$lname[0]-$t";
		$data=[
		'eid'=>$eid,
		'fname'=>$fname,
		'lname'=>$lname,
		'contact'=>$contact,
		'acontact'=>$acontact,
		'email'=>$email,
		'dob'=>$dob,
		'gender'=>$gender,
		'address'=>$address,
		'designation'=>$designation,
		'salbasis'=>$salbasis,
		'samount'=>$samount,
		'joindate'=>$joindate
		];
		$submitdata=Emp::registeremployee($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/employee/index';
		</script>";
	}

	public function editAction(){
		$eid=$_GET['eid'];
		$edata=Emp::getemprecord($eid);
		View::renderTemplate('employeeedit.html',['edata'=>$edata]);
	}

	public function empupdate(){		
		$eid=$_POST['eid'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$contact=$_POST['contact'];
		$acontact=$_POST['acontact'];
		$email=$_POST['email'];
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];
		$address=$_POST['address'];
		$designation=$_POST['designation'];
		$salbasis=$_POST['salbasis'];
		$samount=$_POST['samount'];
		$joindate=$_POST['joindate'];
		$data=[
		'eid'=>$eid,
		'fname'=>$fname,
		'lname'=>$lname,
		'contact'=>$contact,
		'acontact'=>$acontact,
		'email'=>$email,
		'dob'=>$dob,
		'gender'=>$gender,
		'address'=>$address,
		'designation'=>$designation,
		'salbasis'=>$salbasis,
		'samount'=>$samount,
		'joindate'=>$joindate
		];
		$submitdata=Emp::updateemployee($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/employee/index';
		</script>";
	}

	public function deleteAction(){
		$eid=$_GET['eid'];
		$edata=Emp::deleteemprecord($eid);
		echo "<script>
		alert('$edata');
		window.location.href='/employee/index';
		</script>";
	}

	public function getempidpnameAction(){
		$eid=$_POST['eid'];
		$result=Emp::getemplopname($eid);
		foreach ($result as $data){
			echo '<option value="'.$data['Eid'].'"> '.$data['Fname'].' '.$data['Lname'].'</option>';
		}
	}	
	
	public function adpaydetail(){
		$eid=$_POST['eid'];
		$d1=$_POST['dura1'];
		$avg=$_POST['avg'];
		$d2=$_POST['dura2'];
		$wdays=$_POST['wdays'];
		$getdetail=Emp::getempstrecord($eid,$d1,$d2);
		$empdata=$getdetail['edata'];
		$samt=$empdata['Salamount'];
		$sbase=$empdata['Salbasis'];
		$pdata=$getdetail['pdays'];
		$attend=$pdata['Attendance']/'2';
		
		$pamt=$getdetail['pamt'];
		$paid=$pamt['Amount'];
		if ($sbase=='Annually') {
			$pay=($samt/'365')*$attend;
			$sal=round($pay,2);
		}
		else if ( $sbase=='Monthly') {
			$pay=($samt/$avg)*$attend;
			$sal=round($pay,2);
		}
		else{
			$pay=$samt*$attend;
			$sal=round($pay,2);
		}
		$bal=$sal-$paid;
		echo 
		'<form method="post" action="newpayment">
			<input type="hidden" name="eid" value="'.$eid.'">
			<input type="hidden" name="d1" value="'.$d1.'">
			<input type="hidden" name="d2" value="'.$d2.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
				<legend>Personal Detail :</legend>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Name :</label>
				    	<input type="text" class="form-control" name="ename" value="'.$empdata['Fname'].'  '.$empdata['Lname'].'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label for="designation">Designation :</label>
				    	<input type="text" class="form-control" name="desig" value="'.$empdata['Designation'].'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Salary Basis :</label>
					    <input type="text" class="form-control" name="salbase" value="'.$empdata['Salbasis'].'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Salary Amount :</label>
				    	<input type="text" class="form-control" name="salamt" value="'.$empdata['Salamount'].'" readonly>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Working Days:</label>
				    	<input type="text" class="form-control" name="wdays" value="'.$wdays.'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Total Present:</label>
				    	<input type="text" class="form-control" name="attend" value="'.$attend.'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Total Payment:</label>
				    	<input type="text" class="form-control" name="tamt" value="'.$sal.'" readonly>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label>Total Paid:</label>
				    	<input type="text" class="form-control" name="paid" value="'.$paid.'" readonly>
					</div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<legend>Add Payment</legend>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
					<label>Amount Balance</label>
					<input type="text" class="form-control" name="amtbal" value="'.$bal.'" readonly>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
					<label>Amount Paid</label>
					<input type="text" class="form-control" name="amtpaid" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
					<label>Mode of Payment :</label>
					<select class="form-control" name="pmode">
						<option>Cash</option>
						<option>Cheque</option>
						<option>NEFT</option>
						<option>RTGS</option>
					</select>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
					<label>Payment Date :</label>
					<input type="date" class="form-control" name="paydt" required>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
				<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
				<input type="submit" value="Add" >
			</div>
		</form>';
	}

	public function newpaymentAction(){
		$eid=$_POST['eid'];
		$ename=$_POST['ename'];
		$desig=$_POST['desig'];
		$salbase=$_POST['salbase'];
		$salamt=$_POST['salamt'];
		$dura1=$_POST['d1'];
		$dura2=$_POST['d2'];
		$wdays=$_POST['wdays'];
		$attend=$_POST['attend'];
		$tamt=$_POST['tamt'];
		$paid=$_POST['paid'];
		$amtbal=$_POST['amtbal'];
		$amtpaid=$_POST['amtpaid'];
		$paydt=$_POST['paydt'];
		$pmode=$_POST['pmode'];
		$data = [
			'eid'=>$eid,
			'ename'=>$ename,
			'desig'=>$desig,
			'salbase'=>$salbase,
			'salamt'=>$salamt,
			'dura1'=>$dura1,
			'dura2'=>$dura2,
			'wdays'=>$wdays,
			'attend'=>$attend,
			'tamt'=>$tamt,
			'paid'=>$paid,
			'amtbal'=>$amtbal,
			'amtpaid'=>$amtpaid,
			'paydt'=>$paydt,
			'pmode'=>$pmode
		];
		$message=Emp::addpayment($data);
		echo "<script>
		alert('$message');
		window.location.href='/employee/index';
		</script>";

	}

	public function payrcod(){
		$eid=$_POST['eid'];
		$getdetails=Emp::getemppayrcd($eid);
		$detail=$getdetails['detail'];
		$record=$getdetails['record'];
		echo 
		'<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<label>Employee Name:</label>
				<input type="text" class="form-control" value="'.$detail['Fname'].' '.$detail['Lname'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<label>Dasignation:</label>
				<input type="text" class="form-control" value="'.$detail['Designation'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<label>Salary Basis:</label>
				<input type="text" class="form-control" value="'.$detail['Salbasis'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<label>Salary Amount:</label>
				<input type="text" class="form-control" value="'.$detail['Salamount'].'" readonly>
			</div>
		</div>
		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">			
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Duration(From)</th>
				        <th>Duration(To)</th>
				        <th>W_Days</th>
				        <th>P_Days</th>
				        <th>Payment</th>
				        <th>Paid</th>
				        <th>Balance</th>
				        <th>ACTION</th>
				      </tr>
				    </thead>
				    <tbody>';

				    foreach ($record as $getdetail) {
				    echo '
				      <tr>
				        <td>'.$getdetail['Duration1'].'</td>
				        <td>'.$getdetail['Duration2'].'</td>
				        <td>'.$getdetail['Wdays'].'</td>
				        <td>'.$getdetail['Pdays'].'</td>
				        <td>'.$getdetail['Pamount'].'</td>
				        <td>'.$getdetail['Paid'].'</td>
				        <td>'.$getdetail['Balance'].'</td>
				        <td><a class="btn btn-primary" data-toggle="modal" data-target="#payrcddetail" href="paydetailrcd?eid='.$getdetail['Eid'].'&d1='.$getdetail['Duration1'].'&d2='.$getdetail['Duration2'].'">Detail</a></td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
				<div class="modal fade" id="payrcddetail" role="dialog">
				    <div class="modal-dialog modal-lg" >
				    	<div class="modal-content">
				    	</div>
				    </div>
				</div>
			</div>
    	</div>';
	}

	public function paydetailrcd(){
		$eid=$_GET['eid'];
		$d1=$_GET['d1'];
		$d2=$_GET['d2'];
		$getdatas=Emp::getpaydetailrcd($eid,$d1,$d2);
		echo 
		'<div style="margin:10px;">
    		<div id="salarypaydetail" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Payment_Date</th>
				        <th>Mode</th>
				        <th>Amount</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdatas as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Paydate'].'</td>
					        <td>'.$getdata['Mode'].'</td>
					        <td>'.$getdata['Amount'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>		    
	    	<div style="text-align:center;">
			    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
			    <button type="button" class="btn btn-danger" onclick="printsalarydetail()">Print</button>
			</div>
		</div>';
	}

	// public function uppaydetail(){
	// 	$eid=$_POST['eid'];
	// 	$d1=$_POST['d1'];
	// 	$d2=$_POST['d2'];
	// 	$getdetail=Emp::getuppayrecord($eid,$d1,$d2);
	// 	echo 
	// 	'<form method="post" action="uppayment">
	// 		<input type="hidden" name="eid" value="'.$eid.'">
	// 		<input type="hidden" name="d1" value="'.$d1.'">
	// 		<input type="hidden" name="d2" value="'.$d2.'">
	// 		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
	// 			<legend>Salary Detail :</legend>
	// 			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	// 				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	// 				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
	// 						<label>Name :</label>
	// 				    	<input type="text" class="form-control" name="ename" value="'.$getdetail['Ename'].'" readonly>
	// 					</div>
	// 				    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;">
	// 						<label>Designation :</label>
	// 				    	<input type="text" class="form-control" name="desig" value="'.$getdetail['Designation'].'" readonly>
	// 					</div>
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-left:0px;">
	// 						<label>Duration (From) :</label>
	// 				    	<input type="text" class="form-control" name="dura1" value="'.$getdetail['Duration1'].'" readonly>
	// 					</div>
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-right:0px;">
	// 						<label>Duration (To) :</label>
	// 				    	<input type="text" class="form-control" name="dura2" value="'.$getdetail['Duration2'].'" readonly>
	// 					</div>						    
	// 				</div>
	// 				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	// 			</div>
	// 			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	// 				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	// 				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
	// 						<label>Salary Basis :</label>
	// 				    	<input type="text" class="form-control" name="salbase" value="'.$getdetail['Salbasis'].'" readonly>
	// 					</div>
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;">
	// 						<label>Salary Amount :</label>
	// 				    	<input type="text" class="form-control" name="salamt" value="'.$getdetail['Salamount'].'" readonly>
	// 					</div>
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-left:0px;">
	// 						<label>Amount Paid :</label>
	// 				    	<input type="text" class="form-control" name="paid" value="'.$getdetail['Paid'].'" readonly>
	// 					</div>						
	// 					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-right:0px;">
	// 						<label>Balance :</label>
	// 				    	<input type="text" class="form-control" name="Bal" value="'.$getdetail['Balance'].'" readonly>
	// 					</div>
	// 				</div>
	// 				<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	// 			</div>
	// 		</div>
	// 		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
	// 			<legend>Payment</legend>
	// 			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
	// 				<label>Payment Amount</label>
	// 				<input type="text" class="form-control" name="amtpaid" required>
	// 			</div>
	// 			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
	// 				<label>Mode of Payment :</label>
	// 				<select class="form-control" name="pmode">
	// 					<option>Cash</option>
	// 					<option>Cheque</option>
	// 					<option>NEFT</option>
	// 					<option>RTGS</option>
	// 				</select>
	// 			</div>
	// 			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
	// 				<label>Payment Date :</label>
	// 				<input type="date" class="form-control" name="paydt" required>
	// 			</div>
	// 		</div>
	// 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
	// 			<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
	// 			<input type="submit" value="Add" >
	// 		</div>
	// 	</form>';
	// }

	// public function uppaymentAction(){
	// 	$eid=$_POST['eid'];
	// 	$ename=$_POST['ename'];
	// 	$desig=$_POST['desig'];
	// 	$salbase=$_POST['salbase'];
	// 	$salamt=$_POST['salamt'];
	// 	$dura1=$_POST['dura1'];
	// 	$dura2=$_POST['dura2'];
	// 	$paid=$_POST['paid'];
	// 	$Bal=$_POST['Bal'];
	// 	$amtpaid=$_POST['amtpaid'];
	// 	$paydt=$_POST['paydt'];
	// 	$pmode=$_POST['pmode'];
	// 	$data = [
	// 		'eid'=>$eid,
	// 		'ename'=>$ename,
	// 		'desig'=>$desig,
	// 		'salbase'=>$salbase,
	// 		'salamt'=>$salamt,
	// 		'dura1'=>$dura1,
	// 		'dura2'=>$dura2,
	// 		'paid'=>$paid,
	// 		'Bal'=>$Bal,
	// 		'amtpaid'=>$amtpaid,
	// 		'paydt'=>$paydt,
	// 		'pmode'=>$pmode
	// 	];
	// 	$message=Emp::updatepayment($data);
	// 	echo "<script>
	// 	alert('$message');
	// 	window.location.href='/employee/index';
	// 	</script>";

	// }



}
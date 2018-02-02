<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Rnt;
class Rent extends \Core\Controller
{	
	public function indexAction(){
		$edata=Rnt::viewrentrecord();
		View::renderTemplate('rent.html',['rentdata'=>$edata]);
	}

	public function regrentor(){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$contact=$_POST['contact'];
		$acontact=$_POST['acontact'];
		$email=$_POST['email'];		
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];
		$address=$_POST['address'];
		$firmname=$_POST['firmname'];
		$fcontact=$_POST['fcontact'];
		$rtype=$_POST['rtype'];
		$faddress=$_POST['faddress'];
		$t=rand(1000,9999);
		$rid="$rtype[0]$fname[0]-$t";
		$data=[
		'rid'=>$rid,
		'fname'=>$fname,
		'lname'=>$lname,
		'contact'=>$contact,
		'acontact'=>$acontact,		
		'email'=>$email,
		'dob'=>$dob,
		'gender'=>$gender,
		'address'=>$address,
		'firmname'=>$firmname,
		'fcontact'=>$fcontact,
		'rtype'=>$rtype,
		'faddress'=>$faddress
		];
		$submitdata=Rnt::registerrentor($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/rent/index';
		</script>";
	}

	public function editrentAction(){
		$rid=$_GET['rid'];
		$edata=Rnt::getrentrecord($rid);
		View::renderTemplate('rentedit.html',['edata'=>$edata]);
	}

	public function rentupdate(){		
		$rid=$_POST['rid'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$contact=$_POST['contact'];
		$acontact=$_POST['acontact'];
		$email=$_POST['email'];
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];
		$address=$_POST['address'];
		$firmname=$_POST['firmname'];
		$fcontact=$_POST['fcontact'];
		$rtype=$_POST['rtype'];
		$faddress=$_POST['faddress'];
		$data=[
		'rid'=>$rid,
		'fname'=>$fname,
		'lname'=>$lname,
		'contact'=>$contact,
		'acontact'=>$acontact,
		'email'=>$email,
		'dob'=>$dob,
		'gender'=>$gender,
		'address'=>$address,
		'firmname'=>$firmname,
		'fcontact'=>$fcontact,
		'rtype'=>$rtype,
		'faddress'=>$faddress
		];
		$submitdata=Rnt::updaterentor($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/rent/index';
		</script>";
	}

	public function deleterentAction(){
		$rid=$_GET['rid'];
		$edata=Rnt::deleterentrecord($rid);
		echo "<script>
		alert('$edata');
		window.location.href='/rent/index';
		</script>";
	}

	public function getrentridnameAction(){
		$rid=$_POST['rid'];
		$result=Rnt::getrentoridname($rid);
		foreach ($result as $data){
			echo '<option value="'.$data['Rid'].'"> '.$data['Fname'].' '.$data['Lname'].'</option>';
		}
	}

	public function addrentnewtrans(){
		$rid=$_POST['rid'];
		$getdetail=Rnt::getrentrecord($rid);
		echo '
		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
				<input type="hidden" name="rid" value="'.$rid.'">
				<lable>Supplier Name :</label>
				<input type="text" id="rname" class="form-control" value="'.$getdetail['Fname'].' '.$getdetail['Lname'].' " readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Supplier Contact :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Contact'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Rentor Type :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Rtype'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group" style="margin-top:20px;">
			    <a class="btn btn-primary" data-target="#addrentbilldata" data-toggle="collapse">Proceed</a>
			</div>
			
		</div>
		';
	}

	public function tablerentitem(){
		$rid=$_POST['rid'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$pname=$_POST['pname'];
		$desc=$_POST['desc'];
		$cost=$_POST['cost'];
		$days=$_POST['days'];
		$getdetail=Rnt::itemtabletrans($rid,$bno,$date,$pname,$desc,$cost,$days);
		foreach ($getdetail as $supbilldetail) {
			echo 
			'<tr>
				<td>'.$supbilldetail['Pname'].'</td>
				<td>'.$supbilldetail['Dsc'].'</td>
				<td>'.$supbilldetail['Rate'].'</td>
				<td>'.$supbilldetail['Ndays'].'</td>
				<td class="countme">'.$supbilldetail['Amount'].'</td>
			</tr>';
		}
	}

	public function rentbilltrans(){
		$rid=$_POST['rid'];
		$rname=$_POST['rname'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$amt=$_POST['amt'];
		$adv=$_POST['adv'];
		$bal=$_POST['bal'];
		$data=[
		'rid'=>$rid,
		'rname'=>$rname,
		'bno'=>$bno,
		'date'=>$date,
		'amt'=>$amt,
		'adv'=>$adv,
		'bal'=>$bal
		];
		$getdetail=Rnt::itembilltransaction($rid,$rname,$bno,$date,$amt,$adv,$bal);
		echo "<script>
		alert('$getdetail');
		window.location.href='/rent/index';
		</script>";
	}

	public function viewbillrcdetail(){
		$rid=$_POST['rid'];
		$getdetails=Rnt::getitembillrcd($rid);
		echo 
		'<div id="printitembills" class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill_Date</th>
				        <th>Bill_No</th>
				        <th>Rentor_Id</th>
				        <th>Rentor_Name</th>
				        <th>Total_Amount</th>
				        <th>Advance_Paid</th>
				        <th>Balance_Left</th>
				        <th>ACTION</th>
				      </tr>
				    </thead>
				    <tbody>';

				    foreach ($getdetails as $getdetail) {
				    echo '
				      <tr>
				        <td>'.$getdetail['Date'].'</td>
				        <td>'.$getdetail['Bno'].'</td>
				        <td>'.$getdetail['Rid'].'</td>
				        <td>'.$getdetail['Rname'].'</td>
				        <td>'.$getdetail['Amt'].'</td>
				        <td>'.$getdetail['Adv'].'</td>
				        <td>'.$getdetail['Bal'].'</td>
				        <td><a class="btn btn-primary" data-toggle="modal" data-target="#payrcddetail" href="viewitembilldetail?bno='.$getdetail['Bno'].'&rid='.$getdetail['Rid'].'">Detail</a></td>
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
			<div style="text-align:center;">
		    	<button type="button" class="btn btn-danger" onclick="printitemsupbill()">Print</button>
		    </div>
    	</div>';
	}

	public function viewitembilldetail(){
		$bno=$_GET['bno'];
		$rid=$_GET['rid'];
		$getdatas=Rnt::getitembillrecord($bno,$rid);
		echo 
		'<div style="margin:10px;">
    		<div id="billdetailview" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Pname</th>
				        <th>Desc</th>
				        <th>Rate</th>
				        <th>N.Days</th>
				        <th>Amount</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdatas as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Pname'].'</td>
					        <td>'.$getdata['Dsc'].'</td>
					        <td>'.$getdata['Rate'].'</td>
					        <td>'.$getdata['Ndays'].'</td>
					        <td>'.$getdata['Amount'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">
		    	<button class="btn btn-success" data-dismiss="modal">Close</button>
		    	<button class="btn btn-danger" onclick="printbilldetail()">Print</button>
		    </div>
		</div>';
	}

	public function itempaydetail(){
		$rid=$_POST['rid'];
		$data=Rnt::getitembillpay($rid);
		echo 
		'<form method="post" action="itempayment">
			<input type="hidden" name="rid" value="'.$rid.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">	    		
				<legend>Bill Detail :</legend>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="sid">Rentor Id :</label>
				    	<input type="text" class="form-control" name="r_id" value="'.$data['Rid'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="name">Rentor Name :</label>
				    	<input type="text" class="form-control" name="name" value="'.$data['Fname'].' '.$data['Lname'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="name">Rentor Type :</label>
				    	<input type="text" class="form-control" name="rtype" value="'.$data['Rtype'].'" readonly>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="advance">Total Bill Amount :</label>
					    <input type="text" class="form-control" name="total" value="'.$data['Total'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="advance">Total Paid :</label>
				    	<input type="text" class="form-control" name="advance" value="'.$data['Paid'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="balance">Balance Left :</label>
					    <input type="text" class="form-control" name="balleft" value="'.$data['Balance'].'" readonly>
					</div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Payment Date :</label>
					<input type="date" class="form-control" name="paydt" placeholder="Enter Payment Mode" required>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
					<label>Payment Amount :</label>
					<input type="text" class="form-control" name="payamt" placeholder="Add Payment Amount" required>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
					<label>Mode of Payment :</label>
					<select class="form-control" name="mode" required>
						<option>Cash</option>
						<option>Cheque</option>
						<option>Online</option>
						<option>NEFT</option>
						<option>RTGS</option>
						<option>IMPS</option>
						<option>Third Party</option>
						<option>Others</option>
					</select>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;margin-top:-10px;">
				<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
				<input type="submit" value="Update" >
			</div>
		</form>';
	}

	public function itempaymentAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$rid=$_POST['rid'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'rid'=>$rid
		];
		$message=Rnt::additembpayment($data);
		header('location:/rent/index');
	}
	public function billpaymentdetail(){
		$rid = $_POST['rid'];
		$getdetail=Rnt::paymnetbilldatadetail($rid);
		echo '<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div id="paydatadetail" class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Date</th>
								<th>Mode</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>';
						foreach ($getdetail as $detail) {
							echo '
								<tr>
									<td>'.$detail['Date'].'</td>
									<td>'.$detail['Mode'].'</td>
									<td>'.$detail['Amt'].'</td>
								</tr>
							';
						}
						echo'
						</tbody>
					</table>
				</div>
				<div style="text-align:center;">
					<button class="btn btn-danger" onclick="printpaydatadetail()">Print</button>
				</div>
		</div>';
	}
}
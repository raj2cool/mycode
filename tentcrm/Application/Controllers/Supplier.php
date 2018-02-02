<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Supp;
class Supplier extends \Core\Controller
{	
	public function indexAction(){
		$edata=Supp::viewsuprecord();
		View::renderTemplate('supplier.html',['supdata'=>$edata]);
	}

	public function registersup(){
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
		$stype=$_POST['stype'];
		$faddress=$_POST['faddress'];
		$t=rand(1000,9999);
		$sid="$stype[0]$fname[0]-$t";
		$data=[
		'sid'=>$sid,
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
		'stype'=>$stype,
		'faddress'=>$faddress
		];
		$submitdata=Supp::registersupplier($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/supplier/index';
		</script>";
	}

	public function editsupAction(){
		$sid=$_GET['sid'];
		$edata=Supp::getsuprecord($sid);
		View::renderTemplate('supplieredit.html',['edata'=>$edata]);
	}

	public function supupdate(){		
		$sid=$_POST['sid'];
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
		$stype=$_POST['stype'];
		$faddress=$_POST['faddress'];
		$data=[
		'sid'=>$sid,
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
		'stype'=>$stype,
		'faddress'=>$faddress
		];
		$submitdata=Supp::updatesupplier($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/supplier/index';
		</script>";
	}

	public function deletesupAction(){
		$sid=$_GET['sid'];
		$edata=Supp::deletesuprecord($sid);
		echo "<script>
		alert('$edata');
		window.location.href='/supplier/index';
		</script>";
	}

	public function getitemsupidpnameAction(){
		$sid=$_POST['sid'];
		$result=Supp::getitemsupidname($sid);
		foreach ($result as $data){
			echo '<option value="'.$data['Sid'].'"> '.$data['Fname'].' '.$data['Lname'].'</option>';
		}
	}

	public function getitempnameAction(){
		$pname=$_POST['pname'];
		$result=Supp::getitempname($pname);
		foreach ($result as $data) {
			echo '<option value="'.$data['Pname'].'"></option>';
		}
	}

	public function additemnewtrans(){
		$sid=$_POST['sid'];
		$getdetail=Supp::getsuprecord($sid);
		echo '
		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
				<input type="hidden" name="sid" value="'.$sid.'">
				<lable>Supplier Name :</label>
				<input type="text" id="isname" class="form-control" value="'.$getdetail['Fname'].' '.$getdetail['Lname'].' " readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Supplier Contact :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Contact'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Supplier Type :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Stype'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group" style="margin-top:20px;">
			    <a class="btn btn-primary" data-target="#additembilldata" data-toggle="collapse">Proceed</a>
			</div>			
		</div>';
	}

	public function tableitemprod(){
		$sid=$_POST['sid'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$pname=$_POST['pname'];
		$qty=$_POST['qty'];
		$unit=$_POST['unit'];
		$cost=$_POST['cost'];
		$getdetail=Supp::itemtabletrans($sid,$bno,$date,$pname,$qty,$unit,$cost);
		foreach ($getdetail as $supbilldetail) {
			echo 
			'<tr>
				<td>'.$supbilldetail['Pname'].'</td>
				<td>'.$supbilldetail['Cost'].'</td>
				<td>'.$supbilldetail['Qty'].'</td>
				<td class="icountme">'.$supbilldetail['Amt'].'</td>
			</tr>';
		}
	}

	public function itembilltrans(){
		$sid=$_POST['sid'];
		$sname=$_POST['sname'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$amt=$_POST['amt'];
		$adv=$_POST['adv'];
		$bal=$_POST['bal'];
		$data=[
		'sid'=>$sid,
		'sname'=>$sname,
		'bno'=>$bno,
		'date'=>$date,
		'amt'=>$amt,
		'adv'=>$adv,
		'bal'=>$bal
		];
		$getdetail=Supp::itembilltransaction($sid,$sname,$bno,$date,$amt,$adv,$bal);
		echo "<script>
		alert('$getdetail');
		window.location.href='/supplier/index';
		</script>";
	}

	public function addworkernewtrans(){
		$sid=$_POST['sid'];
		$getdetail=Supp::getsuprecord($sid);
		echo '
		<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
				<input type="hidden" name="sid" value="'.$sid.'">
				<lable>Supplier Name :</label>
				<input type="text" id="wsname" class="form-control" value="'.$getdetail['Fname'].' '.$getdetail['Lname'].' " readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Supplier Contact :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Contact'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group">
			    <lable>Supplier Type :</label>
			    <input type="text" class="form-control" value="'.$getdetail['Stype'].'" readonly>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 form-group" style="margin-top:20px;">
			    <a class="btn btn-primary" data-target="#addworkerbilldata" data-toggle="collapse">Proceed</a>
			</div>			
		</div>';
	}

	public function tableworkeritem(){
		$sid=$_POST['sid'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$name=$_POST['name'];
		$age=$_POST['age'];
		$type=$_POST['type'];
		$cost=$_POST['cost'];
		$getdetail=Supp::workertabletrans($sid,$bno,$date,$name,$age,$type,$cost);
		foreach ($getdetail as $supbilldetail) {
			echo 
			'<tr>
				<td>'.$supbilldetail['Name'].'</td>
				<td>'.$supbilldetail['Age'].'</td>
				<td>'.$supbilldetail['Type'].'</td>
				<td class="wcountme">'.$supbilldetail['Rate'].'</td>
			</tr>';
		}
	}

	public function workerbilltrans(){
		$sid=$_POST['sid'];
		$sname=$_POST['sname'];
		$bno=$_POST['bno'];
		$date=$_POST['date'];
		$amt=$_POST['amt'];
		$adv=$_POST['adv'];
		$bal=$_POST['bal'];
		$data=[
		'sid'=>$sid,
		'sname'=>$sname,
		'bno'=>$bno,
		'date'=>$date,
		'amt'=>$amt,
		'adv'=>$adv,
		'bal'=>$bal
		];
		$getdetail=Supp::workerbilltransaction($sid,$sname,$bno,$date,$amt,$adv,$bal);
		echo "<script>
		alert('$getdetail');
		window.location.href='/supplier/index';
		</script>";
	}

	public function itemsupbill(){
		$sid=$_POST['sid'];
		$getdetails=Supp::getitemsupbillrcd($sid);
		echo 
		'<div id="printitembills" class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill_Date</th>
				        <th>Bill_No.</th>
				        <th>Sup_Id</th>
				        <th>Sup_Name</th>
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
				        <td>'.$getdetail['Sid'].'</td>
				        <td>'.$getdetail['Sname'].'</td>
				        <td>'.$getdetail['Amt'].'</td>
				        <td>'.$getdetail['Adv'].'</td>
				        <td>'.$getdetail['Bal'].'</td>
				        <td><a class="btn btn-primary" data-toggle="modal" data-target="#itembilldata" href="viewitembilldetail?billno='.$getdetail['Bno'].'&sid='.$sid.'">Detail</a></td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
				<div class="modal fade" id="itembilldata" role="dialog">
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
		$billno=$_GET['billno'];
		$sid=$_GET['sid'];
		$getdatas=Supp::getitembillrecord($billno,$sid);
		echo 
		'<div style="margin:10px;">
    		<div id="vitembill" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Pname</th>
				        <th>Cost</th>
				        <th>Quantity</th>
				        <th>Amount</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdatas as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Pname'].'</td>
					        <td>'.$getdata['Cost'].'</td>
					        <td>'.$getdata['Qty'].'</td>
					        <td>'.$getdata['Amt'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">
		    	<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		    	<button type="button" class="btn btn-danger" onclick="printviewitembill()">Print</button>
		    </div>
		</div>';
	}

	public function worksupbill(){
		$sid=$_POST['sid'];
		$getdetails=Supp::getworksupbillrcd($sid);
		echo 
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>DATE</th>
				        <th>BILL NO.</th>
				        <th>SUP_ID</th>
				        <th>SUP_NAME</th>
				        <th>TOTAL AMOUNT</th>
				        <th>ADVANCE PAID</th>
				        <th>BALANCE LEFT</th>
				        <th>ACTION</th>
				      </tr>
				    </thead>
				    <tbody>';

				    foreach ($getdetails as $getdetail) {
				    echo '
				      <tr>
				        <td>'.$getdetail['Date'].'</td>
				        <td>'.$getdetail['Bno'].'</td>
				        <td>'.$getdetail['Sid'].'</td>
				        <td>'.$getdetail['Sname'].'</td>
				        <td>'.$getdetail['Amt'].'</td>
				        <td>'.$getdetail['Adv'].'</td>
				        <td>'.$getdetail['Bal'].'</td>
				        <td><a class="btn btn-primary" data-toggle="modal" data-target="#workbilldata" href="viewworkbilldetail?billno='.$getdetail['Bno'].'&sid='.$sid.'">Detail</a></td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
				<div class="modal fade" id="workbilldata" role="dialog">
				    <div class="modal-dialog modal-lg" >
				    	<div class="modal-content">
				    	</div>						    
				    </div>
				</div>
			</div>
    	</div>';
	}

	public function viewworkbilldetail(){
		$billno=$_GET['billno'];
		$sid=$_GET['sid'];
		$getdatas=Supp::getworkbillrecord($billno,$sid);
		echo 
		'<div style="margin:10px;">
    		<div id="workerbill" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Name</th>
				        <th>Age</th>
				        <th>Type</th>
				        <th>Rate</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdatas as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Name'].'</td>
					        <td>'.$getdata['Age'].'</td>
					        <td>'.$getdata['Type'].'</td>
					        <td>'.$getdata['Rate'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">
		    	<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
		    	<button type="button" class="btn btn-danger" onclick="printvieworkerbill()">Print</button>
		    </div>
		</div>';
	}

	public function suppaydetail(){
		$sid=$_POST['sid'];
		$data=Supp::getsuppay($sid);
		echo 
		'<form method="post" action="supplierpayment">
			<input type="hidden" name="sid" value="'.$sid.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
				<legend>Bill Detail :</legend>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="sid">Supplier_Id :</label>
				    	<input type="text" class="form-control" name="s_id" value="'.$data['Sid'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="name">Supplier Name :</label>
				    	<input type="text" class="form-control" name="name" value="'.$data['Fname'].' '.$data['Lname'].'" readonly>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<label for="name">Supplier Type :</label>
				    	<input type="text" class="form-control" name="stype" value="'.$data['Stype'].'" readonly>
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
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
				<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
				<input type="submit" value="Update" >
			</div>
		</form>';
	}

	public function supplierpaymentAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$sid=$_POST['sid'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'sid'=>$sid
		];
		$message=Supp::addsuppayment($data);
		header('location:/supplier/index');
	}

	public function paybdetails(){
		$sid=$_POST['sid'];
		$data=Supp::getpaidsupdata($sid);
		echo
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive" id="paybdatadetail">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Date</th>
				        <th>Payment Mode</th>
				        <th>Amount</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($data as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Date'].'</td>
					        <td>'.$getdata['Mode'].'</td>
					        <td>'.$getdata['Amt'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">
		    	<button class="btn btn-danger" onclick="printtbpaydetail()">Print</button>
		    </div>
		</div>';
	}
	
}
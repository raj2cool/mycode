<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Dash;
class Dashboard extends \Core\Controller
{	
	public function indexAction()
	{
		$data=Dash::viewallduesbooks();
		$duenum=$data['due_rows'];
		$booknum=$data['bookings'];
		$tearn=$data['total_earn'];
		$texp=$data['total_exp'];
		$tinc=$data['total_income'];
		$cbreak=$data['break_book'];
		$clunch=$data['lunch_book'];
		$chight=$data['hight_book'];
		$cdinner=$data['dinner_book'];
		$cdecor=$data['decor_book'];
		$tdecor=$data['tdecor_book'];
		$tdue=$data['tentdue'];
		$cdue=$data['caterdue'];
		View::renderTemplate('dashboard.html',[
			'duenum'=>$duenum,
			'booknum'=>$booknum,
			'tearn'=>$tearn,
			'texp'=>$texp,
			'tinc'=>$tinc,
			'cbreak'=>$cbreak,
			'clunch'=>$clunch,
			'chight'=>$chight,
			'cdinner'=>$cdinner,
			'cdecor'=>$cdecor,
			'tdecor'=>$tdecor,
			'tdue'=>$tdue,
			'cdue'=>$cdue
			]);
	}

	public function cbillbookings(){
		$bdt=$_POST['bdt'];
		$getdetails=Dash::getcbillbookrcd($bdt);
		$break=$getdetails['break_data'];
		$lunch=$getdetails['lunch_data'];
		$hight=$getdetails['hight_data'];
		$dinner=$getdetails['dinner_data'];
		$decor=$getdetails['decor_data'];
		echo 
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill No.</th>
				        <th>Cust_Id</th>
				        <th>Cust_Name</th>
				        <th>Contact</th>
				        <th>Event</th>
				        <th>Time</th>
				        <th>Venue</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($break as $bdata) {
				    echo '
				      <tr>
				        <td>'.$bdata['Bno'].'</td>
				        <td>'.$bdata['Cid'].'</td>
				        <td>'.$bdata['Cname'].'</td>
				        <td>'.$bdata['Contact'].'</td>
				        <td>Breakfast</td>
				        <td>'.$bdata['Time'].'</td>
				        <td>'.$bdata['Venue'].'</td>
				      </tr>';
				     }
				     foreach ($lunch as $ldata) {
				    echo '
				      <tr>
				        <td>'.$ldata['Bno'].'</td>
				        <td>'.$ldata['Cid'].'</td>
				        <td>'.$ldata['Cname'].'</td>
				        <td>'.$ldata['Contact'].'</td>
				        <td>Lunch</td>
				        <td>'.$ldata['Time'].'</td>
				        <td>'.$ldata['Venue'].'</td>
				      </tr>';
				     }
				     foreach ($hight as $hdata) {
				    echo '
				      <tr>
				        <td>'.$hdata['Bno'].'</td>
				        <td>'.$hdata['Cid'].'</td>
				        <td>'.$hdata['Cname'].'</td>
				        <td>'.$hdata['Contact'].'</td>
				        <td>High Tea</td>
				        <td>'.$hdata['Time'].'</td>
				        <td>'.$hdata['Venue'].'</td>
				      </tr>';
				     }
				     foreach ($dinner as $rdata) {
				    echo '
				      <tr>
				        <td>'.$rdata['Bno'].'</td>
				        <td>'.$rdata['Cid'].'</td>
				        <td>'.$rdata['Cname'].'</td>
				        <td>'.$rdata['Contact'].'</td>
				        <td>Dinner</td>
				        <td>'.$rdata['Time'].'</td>
				        <td>'.$rdata['Venue'].'</td>
				      </tr>';
				     }
				     foreach ($decor as $ddata) {
				    echo '
				      <tr>
				        <td>'.$ddata['Bno'].'</td>
				        <td>'.$ddata['Cid'].'</td>
				        <td>'.$ddata['Cname'].'</td>
				        <td>'.$ddata['Contact'].'</td>
				        <td>'.$ddata['Sname'].'</td>
				        <td>'.$ddata['Time'].'</td>
				        <td>'.$ddata['Venue'].'</td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
			</div>
    	</div>';
	}

	public function tbillbookings(){
		$bdt=$_POST['bdt'];
		$getdetail=Dash::gettbillbookrcd($bdt);
		echo 
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill No.</th>
				        <th>Cust_Id</th>
				        <th>Cust_Name</th>
				        <th>Contact</th>
				        <th>Service</th>
				        <th>Time</th>
				        <th>Venue</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdetail as $detail) {
				    echo '
				      <tr>
				        <td>'.$detail['Bno'].'</td>
				        <td>'.$detail['Cid'].'</td>
				        <td>'.$detail['Cname'].'</td>
				        <td>'.$detail['Contact'].'</td>
				        <td>'.$detail['Sname'].'</td>
				        <td>'.$detail['Time'].'</td>
				        <td>'.$detail['Venue'].'</td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
			</div>
    	</div>';
	}

	public function cbilldues(){
		$bdt=$_POST['bdt'];
		$getdetails=Dash::getcbillduercd($bdt);
		echo 
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill No.</th>
				        <th>Bill_Date</th>
				        <th>Cust_Id</th>
				        <th>Cust_Name</th>
				        <th>Contact</th>
				        <th>Total_Amount</th>
				        <th>Amount_Paid</th>
				        <th>Balance</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdetails as $getdetail) {
				    echo '
				      <tr>
				        <td>'.$getdetail['Bno'].'</td>
				        <td>'.$getdetail['Bdate'].'</td>
				        <td>'.$getdetail['Cid'].'</td>
				        <td>'.$getdetail['Cname'].'</td>
				        <td>'.$getdetail['Contact'].'</td>
				        <td>'.$getdetail['Newamt'].'</td>
				        <td>'.$getdetail['Paid'].'</td>
				        <td>'.$getdetail['Balance'].'</td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
			</div>
    	</div>';
	}

	public function tbilldues(){
		$bdt=$_POST['bdt'];
		$getdetails=Dash::gettbillduercd($bdt);
		echo 
		'<div class="well" style="margin-top:10px;">
    		<div class="table-responsive">          
				<table class="table">
				    <thead>
				      <tr>
				        <th>Bill No.</th>
				        <th>Bill_Date</th>
				        <th>Cust_Id</th>
				        <th>Cust_Name</th>
				        <th>Contact</th>
				        <th>Total_Amount</th>
				        <th>Amount_Paid</th>
				        <th>Balance</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($getdetails as $getdetail) {
				    echo '
				      <tr>
				        <td>'.$getdetail['Bno'].'</td>
				        <td>'.$getdetail['Bdate'].'</td>
				        <td>'.$getdetail['Cid'].'</td>
				        <td>'.$getdetail['Cname'].'</td>
				        <td>'.$getdetail['Contact'].'</td>
				        <td>'.$getdetail['Newamt'].'</td>
				        <td>'.$getdetail['Paid'].'</td>
				        <td>'.$getdetail['Balance'].'</td>
				      </tr>';
				     }
				     echo '
				    </tbody>
				</table>
			</div>
    	</div>';
	}

	public function expcaterbilldetail(){
		$bno=$_POST['bno'];
		$getdetail=Dash::getcaterbillpay($bno);
		echo 
		'<form method="post" action="caterexpense">
			<input type="hidden" name="bno" value="'.$bno.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
				<legend>Bill Detail :</legend>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-bottom:10px;">
							<label for="contact">Bill No. :</label>
					    	<input type="text" class="form-control" name="bnot" value="'.$getdetail['Bno'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Bill Date :</label>
					    	<input type="text" class="form-control" name="bdate" value="'.$getdetail['Bdate'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-top:10px;">
							<label for="topay">Total Amount :</label>
					    	<input type="text" class="form-control" name="topay" value="'.$getdetail['Newamt'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-top:10px;">
							<label for="advance">Amount Paid :</label>
					    	<input type="text" class="form-control" name="advance" value="'.$getdetail['Paid'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-left:0px;margin-bottom:10px;">
							<label for="sid">Cust._Id :</label>
					    	<input type="text" class="form-control" name="cidt" value="'.$getdetail['Cid'].'" readonly>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Customer Name :</label>
					    	<input type="text" class="form-control" name="name" value="'.$getdetail['Cname'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-left:0px;">
							<label for="balance">Balance Left :</label>
					    	<input type="text" class="form-control" name="balleft" value="'.$getdetail['Balance'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 style="margin-top:10px;padding-right:0px;">
							<label>Total Expense :</label>
					    	<input type="text" class="form-control" name="expense" value="'.$getdetail['Expense'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expense Date :</label>
					<input type="date" class="form-control" name="paydt" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expense Amount :</label>
					<input type="text" class="form-control" name="payamt" placeholder="Add Expense Amount" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expensed On :</label>
					<input type="text" class="form-control" name="purpose" placeholder="Enter Expense Purpose" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Mode of Expense :</label>
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
				<a class="btn btn-danger" href="" style="text-decoration:none;color:white">Close</a>
				<input type="submit" class="btn btn-success" value="Update" >
			</div>
		</form>';
	}

	public function caterexpenseAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$purpose=$_POST['purpose'];
		$bno=$_POST['bno'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'purpose'=>$purpose,
			'bno'=>$bno
		];
		$message=Dash::addcaterexpense($data);
		header('location:/dashboard/index');
	}

	public function exptentbilldetail(){
		$bno=$_POST['bno'];
		$data=Dash::gettentbillpay($bno);
		$getdetail=$data[0];
		echo 
		'<form method="post" action="tentexpense">
			<input type="hidden" name="bno" value="'.$bno.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
				<legend>Bill Detail :</legend>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-bottom:10px;">
							<label for="contact">Bill No. :</label>
					    	<input type="text" class="form-control" name="bnot" value="'.$getdetail['Bno'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Bill Date :</label>
					    	<input type="text" class="form-control" name="bdate" value="'.$getdetail['Bdate'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-top:10px;">
							<label for="topay">Total Amount :</label>
					    	<input type="text" class="form-control" name="topay" value="'.$getdetail['Newamt'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-top:10px;">
							<label for="advance">Amount Paid :</label>
					    	<input type="text" class="form-control" name="advance" value="'.$getdetail['Paid'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-left:0px;margin-bottom:10px;">
							<label for="sid">Cust._Id :</label>
					    	<input type="text" class="form-control" name="cidt" value="'.$getdetail['Cid'].'" readonly>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Customer Name :</label>
					    	<input type="text" class="form-control" name="name" value="'.$getdetail['Cname'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-left:0px;">
							<label for="balance">Balance Left :</label>
					    	<input type="text" class="form-control" name="balleft" value="'.$getdetail['Balance'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-right:0px;">
							<label>Total Expense :</label>
					    	<input type="text" class="form-control" name="expense" value="'.$getdetail['Expense'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expense Date :</label>
					<input type="date" class="form-control" name="paydt" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expense Amount :</label>
					<input type="text" class="form-control" name="payamt" placeholder="Add Expense Amount" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Expensed On :</label>
					<input type="text" class="form-control" name="purpose" placeholder="Enter Expense Purpose" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Mode of Expense :</label>
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
				<a class="btn btn-danger" href="" style="text-decoration:none;color:white">Close</a>
				<input type="submit" class="btn btn-success" value="Update" >
			</div>
		</form>';
	}

	public function tentexpenseAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$purpose=$_POST['purpose'];
		$bno=$_POST['bno'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'purpose'=>$purpose,
			'bno'=>$bno
		];
		$message=Dash::addtentexpense($data);
		header('location:/dashboard/index');
	}

	public function personalesxpense(){
		$date=$_POST['date'];
		$amount=$_POST['amount'];
		$reason=$_POST['reason'];
		$mode=$_POST['mode'];
		$getdetail=Dash::addpersexpdetail($date,$amount,$reason,$mode);


	}

	public function expensedetails(){
		$type=$_POST['type'];
		$bno=$_POST['bno'];
		$data=Dash::getexpensebilldata($type,$bno);
		echo
		'<div class="well" style="margin-top:10px;">
    		<div id="paybilsdetail" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>B_no</th>
				        <th>Date</th>
				        <th>Amount</th>
				        <th>Purpose</th>
				        <th>Mode</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($data as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Bno'].'</td>
					        <td>'.$getdata['EDate'].'</td>
					        <td>'.$getdata['Amount'].'</td>
					        <td>'.$getdata['Purpose'].'</td>
					        <td>'.$getdata['Mode'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">   	
	    		<a type="button" class="btn btn-danger" onclick="printpaymentbilsdetail()">Print</a>
		    </div>
		</div>';
	}

	public function expensepdetails(){
		$date=$_POST['date'];
		$data=Dash::getexpensepbilldata($date);
		echo
		'<div class="well" style="margin-top:10px;">
    		<div id="paybilsdetail" class="table-responsive">          
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Date</th>
				        <th>Amount</th>
				        <th>Purpose</th>
				        <th>Mode</th>
				      </tr>
				    </thead>
				    <tbody>';
				    foreach ($data as $getdata) 
				    {
				    	echo 
				    	'<tr>
					        <td>'.$getdata['Edate'].'</td>
					        <td>'.$getdata['Amount'].'</td>
					        <td>'.$getdata['Reason'].'</td>
					        <td>'.$getdata['Mode'].'</td>
				      	</tr>';
				    }
				    echo '
				    </tbody>
				</table>
		    </div>
		    <div style="text-align:center;">   	
	    		<a type="button" class="btn btn-danger" onclick="printpaymentbilsdetail()">Print</a>
		    </div>
		</div>';
	}

	public function getenameAction(){
		$ename=$_POST['ename'];
		$result=Dash::getempname($ename);
		foreach ($result as $data){
			echo '<option value="'.$data['Eid'].'"> '.$data['Fname'].' '.$data['Lname'].'</option>';
		}
	}

	public function listempppp(){
		$date=$_POST['date'];
		$id=$_POST['id'];
		$attd=$_POST['attd'];
		$getdetail=Dash::empattdtable($date,$id,$attd);
		foreach ($getdetail as $edata) {
			echo 
			'<tr>
				<td>'.$edata['Adate'].'</td>
				<td>'.$edata['Eid'].'</td>
				<td>'.$edata['Ename'].'</td>
			</tr>';
		}
	}
}
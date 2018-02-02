<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Bill;
class Billing extends \Core\Controller
{	
	public function indexAction(){
		$edata=Bill::viewallbillrecord();
		$tbno=$edata['tent_bno'];
		$cbno=$edata['cater_bno'];
		$ebno=$edata['estimate_bno'];
		$tentdata=$tbno[0]['max(Bno)+1'];
		$caterdata=$cbno[0]['max(Bno)+1'];
		$estimatedata=$ebno[0]['max(Bno)+1'];
		$viewtent=$edata['tent_view'];
		$viewcater=$edata['cater_view'];
		$viewestim=$edata['estim_view'];
		View::renderTemplate('billing.html',[
			'tentdata'=>$tentdata,
			'caterdata'=>$caterdata,
			'viewtent'=>$viewtent,
			'viewcater'=>$viewcater,
			'estimatedata'=>$estimatedata,
			'viewestim'=>$viewestim
			]);
	}

	public function gettpnameAction(){
		$pid=$_POST['pid'];
		$result=Bill::gettentpname($pid);
		foreach ($result as $data){
			echo '<option value="'.$data['Pid'].'"> '.$data['Pname'].'</option>';
		}
	}

	public function billtent(){
		$tbno=$_POST['tbno'];
		$tpid=$_POST['tpid'];
		$tqty=$_POST['tqty'];
		$tunit=$_POST['tunit'];
		$bookdt=$_POST['bookdt'];
		$returndt=$_POST['returndt'];
		$tndays=$_POST['tndays'];
		$getdetail=Bill::tentbilltable($tbno,$tpid,$tqty,$tunit,$bookdt,$returndt,$tndays);
		foreach ($getdetail as $tentdata) {
			echo 
			'<tr>
				<td>'.$tentdata['Pname'].'</td>
				<td>'.$tentdata['Quantity'].' '.$tentdata['Unit'].'</td>
				<td>'.$tentdata['Bookdt'].'</td>
				<td>'.$tentdata['Returndt'].'</td>
				<td>'.$tentdata['Ndays'].'</td>
				<td>'.$tentdata['Rate'].'</td>
				<td class="tcount">'.$tentdata['T_amount'].'</td>
			</tr>';
		}
	}

	public function gettdpnameAction(){
		$pid=$_POST['pid'];
		$result=Bill::getdecorpname($pid);
		foreach ($result as $data){
			echo '<option value="'.$data['Pid'].'"> '.$data['Sname'].'</option>';
		}
	}

	public function billtentdecor(){
		$tbno=$_POST['tbno'];
		$tdpid=$_POST['tdpid'];
		$tddate=$_POST['tddate'];
		$tdtime=$_POST['tdtime'];
		$tdvenue=$_POST['tdvenue'];
		$getdetail=Bill::tentdecorbilltable($tbno,$tdpid,$tddate,$tdtime,$tdvenue);
		foreach ($getdetail as $tentdata) {
			echo 
			'<tr>
				<td>'.$tentdata['Sname'].'</td>
				<td>'.$tentdata['Date'].'</td>
				<td>'.$tentdata['Time'].'</td>
				<td>'.$tentdata['Venue'].'</td>
				<td class="tdcount">'.$tentdata['Rate'].'</td>
			</tr>';
		}
	}

	public function tentbilltrans(){
		$bno=$_POST['bno'];
		$bdate=$_POST['bdate'];
		$cname=$_POST['cname'];
		$contact=$_POST['contact'];
		$ttotal=$_POST['ttotal'];
		$dtotal=$_POST['dtotal'];
		$amt=$_POST['amt'];
		$disc=$_POST['disc'];
		$namt=$_POST['namt'];
		$adv=$_POST['adv'];
		$bal=$_POST['bal'];
		$duedt=$_POST['duedt'];
		$t=rand(1000,9999);
		$cid="T$cname[0]-$t";
		$data=[
		'cid'=>$cid,
		'bno'=>$bno,
		'bdate'=>$bdate,
		'cname'=>$cname,
		'contact'=>$contact,
		'ttotal'=>$ttotal,
		'dtotal'=>$dtotal,
		'amt'=>$amt,
		'disc'=>$disc,
		'namt'=>$namt,
		'adv'=>$adv,
		'bal'=>$bal,
		'duedt'=>$duedt
		];
		$getdetail=Bill::tentbilltransaction($cid,$bno,$bdate,$cname,$contact,$ttotal,$dtotal,$amt,$disc,$namt,$adv,$bal,$duedt);
	}

	public function billtentbillAction(){
		$bno=$_GET['bno'];
		$edata=Bill::viewtenbilltrecord($bno);
		$tdata=$edata['bill_data'];
		$bdata=$edata['detail_data'];
		$ddata=$edata['decor_data'];
		$sdata=$edata['setting'];
		View::renderTemplate('billtent.html',['tdata'=>$tdata,'bdata'=>$bdata,'sdata'=>$sdata,'ddata'=>$ddata]);
	}

	public function addeventdate(){
		$bno=$_POST['bno'];
		$edate=$_POST['edate'];
		$getdetail=Bill::addcaterevent($bno,$edate);
	}

	public function getcsnameAction(){
		$sname=$_POST['sname'];
		$result=Bill::getmenusname($sname);
		foreach ($result as $data){
			echo '<option value="'.$data['Pname'].'">'.$data['Pid'].'</option>';
		}
	}

	public function billcaterbreak(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cbtime=$_POST['cbtime'];
		$cbvenue=$_POST['cbvenue'];
		$cbguest=$_POST['cbguest'];
		$cbiname=$_POST['cbiname'];
		$getdetail=Bill::cbreakbilltable($cbno,$cedate,$cbtime,$cbvenue,$cbguest,$cbiname);
		echo 
		'<tr>
			<td>'.$getdetail['Iname'].'</td>
		</tr>';
	}

	public function billcaterlunchmain(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cltime=$_POST['cltime'];
		$clvenue=$_POST['clvenue'];
		$clguest=$_POST['clguest'];
		$clminame=$_POST['clminame'];
		$getdetail=Bill::clunchmainbilltable($cbno,$cedate,$cltime,$clvenue,$clguest,$clminame);
		$i='0';
		foreach ($getdetail as $cmaindata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$cmaindata['Item'].'</td>
			</tr>';
		}
	}

	public function getostypeAction(){
		$stype=$_POST['stype'];
		$result=Bill::getmenustype($stype);
		foreach ($result as $data){
			echo '<option value="'.$data['Smtype'].'"></option>';
		}
	}

	public function billcaterlunchother(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cltime=$_POST['cltime'];
		$clvenue=$_POST['clvenue'];
		$clguest=$_POST['clguest'];
		$clostype=$_POST['clostype'];
		$cloiname=$_POST['cloiname'];
		$getdetail=Bill::clunchotherbilltable($cbno,$cedate,$cltime,$clvenue,$clguest,$clostype,$cloiname);
	}

	public function billcaterhight(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$chtime=$_POST['chtime'];
		$chvenue=$_POST['chvenue'];
		$chguest=$_POST['chguest'];
		$chiname=$_POST['chiname'];
		$getdetail=Bill::chightbilltable($cbno,$cedate,$chtime,$chvenue,$chguest,$chiname);
		echo 
		'<tr>
			<td>'.$getdetail['Iname'].'</td>
		</tr>';
	}

	public function billcaterdinnermain(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cdtime=$_POST['cdtime'];
		$cdvenue=$_POST['cdvenue'];
		$cdguest=$_POST['cdguest'];
		$cdminame=$_POST['cdminame'];
		$getdetail=Bill::cdinnermainbilltable($cbno,$cedate,$cdtime,$cdvenue,$cdguest,$cdminame);
		$i='0';
		foreach ($getdetail as $cmaindata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$cmaindata['Item'].'</td>
			</tr>';
		}
	}

	public function billcaterdinnerother(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cdtime=$_POST['cdtime'];
		$cdvenue=$_POST['cdvenue'];
		$cdguest=$_POST['cdguest'];
		$cdostype=$_POST['cdostype'];
		$cdoiname=$_POST['cdoiname'];
		$getdetail=Bill::cdinnerotherbilltable($cbno,$cedate,$cdtime,$cdvenue,$cdguest,$cdostype,$cdoiname);
	}

	public function billcaterdecor(){
		$cbno=$_POST['cbno'];
		$cddate=$_POST['cddate'];
		$cdtime=$_POST['cdtime'];
		$cdvenue=$_POST['cdvenue'];
		$cdpname=$_POST['cdpname'];
		$getdetail=Bill::caterdecorbilltable($cbno,$cddate,$cdtime,$cdvenue,$cdpname);
		$i='0';
		foreach ($getdetail as $tentdata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$tentdata['Sname'].'</td>
				<td>'.$tentdata['Date'].'</td>
				<td>'.$tentdata['Time'].'</td>
				<td>'.$tentdata['Venue'].'</td>
			</tr>';
		}
	}

	public function caterbilltrans(){
		$bno=$_POST['bno'];
		$bdate=$_POST['bdate'];
		$cname=$_POST['cname'];
		$contact=$_POST['contact'];
		$amt=$_POST['amt'];
		$disc=$_POST['disc'];
		$namt=$_POST['namt'];
		$adv=$_POST['adv'];
		$bal=$_POST['bal'];
		$duedt=$_POST['duedt'];
		$t=rand(1000,9999);
		$cid="C$cname[0]-$t";
		$data=[
		'cid'=>$cid,
		'bno'=>$bno,
		'bdate'=>$bdate,
		'cname'=>$cname,
		'contact'=>$contact,
		'amt'=>$amt,
		'disc'=>$disc,
		'namt'=>$namt,
		'adv'=>$adv,
		'bal'=>$bal,
		'duedt'=>$duedt
		];
		$getdetail=Bill::caterbilltransaction($cid,$bno,$bdate,$cname,$contact,$amt,$disc,$namt,$adv,$bal,$duedt);
	}

	public function billcaterbillAction(){
		$bno=$_GET['bno'];
		$edata=Bill::viewcaterbilltrecord($bno);
		$tdata=$edata['bill_data'];
		$qdata=$edata['event_data'];
		$ddata=$edata['decor_data'];
		$sdata=$edata['setting'];		
	}

	public function tentbilldt(){
		$bno=$_GET['bno'];
		$tddata=Bill::viewtentbilldt($bno);		
		$bdata=$tddata['tbill'];	
		$tdata=$tddata['tbilldt'];
		$ddata=$tddata['dbilldt'];
		echo '
			<div id="tentbilldetail" class="table-responsive">
	    			<table class="table table-bordered">
	    				<caption>Tent</caption>
	    				<thead>
	    					<tr>
	    						<th>Prod_Name</th>
		    					<th>Quantity</th>
		    					<th>Book_Dt</th>
		    					<th>Return_Dt</th>
		    					<th>Ndays</th>
		    					<th>Rate/Day</th>
		    					<th>Amount</th>
	    					</tr>						    					
	    				</thead>
	    				<tbody>';
	    				foreach ($tdata as $data) {
	    				echo'
	    					<tr>
	    						<td>'.$data['Pname'].'</td>
	    						<td>'.$data['Quantity'].' '.$data['Unit'].'</td>
	    						<td>'.$data['Bookdt'].'</td>
	    						<td>'.$data['Returndt'].'</td>
	    						<td>'.$data['Ndays'].'</td>
	    						<td>'.$data['Rate'].'</td>
	    						<td>'.$data['T_amount'].'</td>
	    					</tr>';
	    				}echo '
	    					<tr>
	    						<td colspan="6" style="text-align:right;">Total</td>
	    						<td>'.$bdata['Ttotal'].'</td>
	    					</tr>
	    				</tbody>
	    			</table>
	    			<table class="table table-bordered">
	    				<caption>Decoration</caption>
	    				<thead>
	    					<tr>
	    						<th>Service_name</th>
	    						<th>Date</th>
	    						<th>Time</th>
	    						<th>Venue</th>
	    						<th>Rate</th>
	    					</tr>						    					
	    				</thead>
	    				<tbody>';
	    				foreach ($ddata as $data) {
	    				echo'
	    					<tr>
	    						<td>'.$data['Sname'].'</td>
	    						<td>'.$data['Date'].'</td>
	    						<td>'.$data['Time'].'</td>
	    						<td>'.$data['Venue'].'</td>
	    						<td>'.$data['Rate'].'</td>
	    					</tr>';
	    				}echo '
	    					<tr>
	    						<td colspan="4" style="text-align:right;">Total</td>
	    						<td>'.$bdata['Dtotal'].'</td>
	    					</tr>
	    				</tbody>
	    			</table>
	    		</div>
	    		<div style="text-align:center;">
	    			<a type="button" class="btn btn-success" href="/billing/index">Close</a>
	    			<a type="button" class="btn btn-danger" onclick="printtentbilldetail()">Print</a>
	    		</div>
		';
	}

	public function caterbilldt(){
		$bno=$_GET['bno'];
		$tddata=Bill::viewcaterbilldt($bno);
	}

	public function tentbillpaydetail(){
		$bno=$_POST['bno'];
		$getdetail=Bill::gettentbillpay($bno);
		echo 
		'<form method="post" action="tentpayment">
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
							<label for="sid">Customer Id :</label>
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
							<label for="balance">Due Pay Date :</label>
					    	<input type="text" class="form-control" name="duedt" value="'.$getdetail['Duedt'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Payment Date :</label>
					<input type="date" class="form-control" name="paydt" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Payment Amount :</label>
					<input type="text" class="form-control" name="payamt" placeholder="Add Payment Amount" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
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
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Next Pay Date :</label>
					<input type="date" class="form-control" name="nduedt" required>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
				<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
				<input type="submit" value="Update" >
			</div>
		</form>';
	}

	public function tentpaymentAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$nduedt=$_POST['nduedt'];
		$bno=$_POST['bno'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'nduedt'=>$nduedt,
			'bno'=>$bno
		];
		$message=Bill::addtentpayment($data);
		header('location:/billing/index');
	}

	public function caterbillpaydetail(){
		$bno=$_POST['bno'];
		$data=Bill::getcaterbillpay($bno);
		echo 
		'<form method="post" action="caterpayment">
			<input type="hidden" name="bno" value="'.$bno.'">
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">	    		
				<legend>Bill Detail :</legend>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-bottom:10px;">
							<label for="contact">Bill No. :</label>
					    	<input type="text" class="form-control" name="bnot" value="'.$data['Bno'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Bill Date :</label>
					    	<input type="text" class="form-control" name="bdate" value="'.$data['Bdate'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;margin-top:10px;">
							<label for="topay">Total Amount :</label>
					    	<input type="text" class="form-control" name="topay" value="'.$data['Newamt'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;margin-top:10px;">
							<label for="advance">Amount Paid :</label>
					    	<input type="text" class="form-control" name="advance" value="'.$data['Paid'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 form-group">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="padding-left:0px;margin-bottom:10px;">
							<label for="sid">Customer Id :</label>
					    	<input type="text" class="form-control" name="cidt" value="'.$data['Cid'].'" readonly>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-right:0px;margin-bottom:10px;">
							<label for="name">Customer Name :</label>
					    	<input type="text" class="form-control" name="name" value="'.$data['Cname'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-left:0px;">
							<label for="balance">Balance Left :</label>
					    	<input type="text" class="form-control" name="balleft" value="'.$data['Balance'].'" readonly>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-top:10px;padding-right:0px;">
							<label>Last Due Pay Date:</label>
							<input type="text" class="form-control" name="duedt" value="'.$data['Duedt'].'" readonly>
						</div>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
				</div>
			</div>
			<div class="well col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Payment Date :</label>
					<input type="date" class="form-control" name="paydt" placeholder="Enter Payment Mode" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Payment Amount :</label>
					<input type="text" class="form-control" name="payamt" placeholder="Add Payment Amount" required>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
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
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<label>Next Pay Date:</label>
					<input type="date" class="form-control" name="nduedt" required>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
				<label style="background:red;padding:10px 30px;"><a href="" style="text-decoration:none;color:white">Close</a></label>
				<input type="submit" value="Update" >
			</div>
		</form>';
	}

	public function caterpaymentAction(){
		$paydt=$_POST['paydt'];
		$payamt=$_POST['payamt'];
		$mode=$_POST['mode'];
		$nduedt=$_POST['nduedt'];
		$bno=$_POST['bno'];
		$data = [
			'paydt'=>$paydt,
			'payamt'=>$payamt,
			'mode'=>$mode,
			'nduedt'=>$nduedt,
			'bno'=>$bno
		];
		$message=Bill::addcaterpayment($data);
		header('location:/billing/index');
	}

	public function paybdetails(){
		$cat=$_POST['cat'];
		$bno=$_POST['bno'];
		$data=Bill::getpaidbilldata($cat,$bno);
		echo
		'<div class="well" style="margin-top:10px;">
    		<div id="paybilsdetail" class="table-responsive">          
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
					        <td>'.$getdata['Amount'].'</td>
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

	public function eaddeventdate(){
		$bno=$_POST['bno'];
		$edate=$_POST['edate'];
		$getdetail=Bill::addestimateevent($bno,$edate);
	}

	public function billestimatebreak(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cbguest=$_POST['cbguest'];
		$cbiname=$_POST['cbiname'];
		$getdetail=Bill::ebreakbilltable($cbno,$cedate,$cbguest,$cbiname);
		echo 
		'<tr>
			<td>'.$getdetail['Iname'].'</td>
		</tr>';
	}

	public function billestimatelunchmain(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$clguest=$_POST['clguest'];
		$clminame=$_POST['clminame'];
		$getdetail=Bill::elunchmainbilltable($cbno,$cedate,$clguest,$clminame);
		$i='0';
		foreach ($getdetail as $cmaindata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$cmaindata['Item'].'</td>
			</tr>';
		}
	}

	public function billestimatelunchother(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$clguest=$_POST['clguest'];
		$clostype=$_POST['clostype'];
		$cloiname=$_POST['cloiname'];
		$getdetail=Bill::elunchotherbilltable($cbno,$cedate,$clguest,$clostype,$cloiname);
	}

	public function billestimatehight(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$chguest=$_POST['chguest'];
		$chiname=$_POST['chiname'];
		$getdetail=Bill::ehightbilltable($cbno,$cedate,$chguest,$chiname);
		echo 
		'<tr>
			<td>'.$getdetail['Iname'].'</td>
		</tr>';
	}

	public function billestimatedinnermain(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cdguest=$_POST['cdguest'];
		$cdminame=$_POST['cdminame'];
		$getdetail=Bill::edinnermainbilltable($cbno,$cedate,$cdguest,$cdminame);
		$i='0';
		foreach ($getdetail as $cmaindata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$cmaindata['Item'].'</td>
			</tr>';
		}
	}

	public function billestimatedinnerother(){
		$cbno=$_POST['cbno'];
		$cedate=$_POST['cedate'];
		$cdguest=$_POST['cdguest'];
		$cdostype=$_POST['cdostype'];
		$cdoiname=$_POST['cdoiname'];
		$getdetail=Bill::edinnerotherbilltable($cbno,$cedate,$cdguest,$cdostype,$cdoiname);
	}

	public function billestimatedecor(){
		$cbno=$_POST['cbno'];
		$cddate=$_POST['cddate'];
		$cdpname=$_POST['cdpname'];
		$getdetail=Bill::estimatedecorbilltable($cbno,$cddate,$cdpname);
		$i='0';
		foreach ($getdetail as $tentdata) {
			echo 
			'<tr>
				<td>'.++$i.'</td>
				<td>'.$tentdata['Sname'].'</td>
				<td>'.$tentdata['Date'].'</td>
			</tr>';
		}
	}

	public function estimatebilltrans(){
		$bno=$_POST['bno'];
		$bdate=$_POST['bdate'];
		$cname=$_POST['cname'];
		$contact=$_POST['contact'];
		$amt=$_POST['amt'];
		$disc=$_POST['disc'];
		$namt=$_POST['namt'];
		$t=rand(1000,9999);
		$cid="E$cname[0]-$t";
		$data=[
		'cid'=>$cid,
		'bno'=>$bno,
		'bdate'=>$bdate,
		'cname'=>$cname,
		'contact'=>$contact,
		'amt'=>$amt,
		'disc'=>$disc,
		'namt'=>$namt
		];
		$getdetail=Bill::estimatebilltransaction($cid,$bno,$bdate,$cname,$contact,$amt,$disc,$namt);
	}

	public function billestimatebillAction(){
		$bno=$_GET['bno'];
		$edata=Bill::viewestimatebilltrecord($bno);	
	}

	public function estimbilldt(){
		$bno=$_GET['bno'];
		$tddata=Bill::viewestimatebilldt($bno);
	}
}
<?php
namespace application\Models;
use PDO;
class Bill extends \Core\Model
{

	public function viewallbillrecord(){
		$db=static::getDB();
		$tent_bno=mysqli_fetch_all(mysqli_query($db,"SELECT max(Bno)+1 FROM tentbill"),MYSQLI_ASSOC);
		$cater_bno=mysqli_fetch_all(mysqli_query($db,"SELECT max(Bno)+1 FROM caterbill"),MYSQLI_ASSOC);
		$estimate_bno=mysqli_fetch_all(mysqli_query($db,"SELECT max(Bno)+1 FROM estimatebill"),MYSQLI_ASSOC);
		$tent_view=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM tentbill WHERE Bno!='0' ORDER BY Bno DESC"),MYSQLI_ASSOC);
		$cater_view=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM caterbill WHERE Bno!='0' ORDER BY Bno DESC"),MYSQLI_ASSOC);
		$estim_view=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM estimatebill WHERE Bno!='0' ORDER BY Bno DESC"),MYSQLI_ASSOC);
		$data=[
		'tent_bno'=>$tent_bno,
		'cater_bno'=>$cater_bno,
		'estimate_bno'=>$estimate_bno,
		'tent_view'=>$tent_view,
		'cater_view'=>$cater_view,
		'estim_view'=>$estim_view
		];
		return $data;
	}

	public function gettentpname($pid){
		$db=static::getDB();
		$q="SELECT * FROM stocktent WHERE Pname LIKE '%".$pid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function tentbilltable($tbno,$tpid,$tqty,$tunit,$bookdt,$returndt,$tndays){
		$db=static::getDB();
		$q="SELECT * FROM stocktent WHERE Pid='$tpid'";
		$z=mysqli_fetch_array(mysqli_query($db,$q));
		$pname=$z['Pname'];
		$bookp=$z['Bp'];
		$amount=$bookp*$tqty*$tndays;
		$u="INSERT INTO `tentbilldetail`(`Bno`, `Pname`, `Quantity`, `Unit`, `Bookdt`, `Returndt`, `Ndays`, `Rate`, `T_amount`) 
		VALUES ('$tbno','$pname','$tqty','$tunit','$bookdt','$returndt','$tndays','$bookp','$amount')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `tentbilldetail` WHERE Bno='$tbno'";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getdecorpname($pid){
		$db=static::getDB();
		$q="SELECT * FROM stockdecoration WHERE Sname LIKE '%".$pid."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function tentdecorbilltable($tbno,$tdpid,$tddate,$tdtime,$tdvenue){
		$db=static::getDB();
		$q="SELECT * FROM stockdecoration WHERE Pid='$tdpid'";
		$z=mysqli_fetch_array(mysqli_query($db,$q));
		$pname=$z['Sname'];
		$bookp=$z['Bp'];
		$u="INSERT INTO `tentdecordetail`(`Bno`, `Sname`, `Date`, `Time`, `Venue`, `Rate`) 
		VALUES ('$tbno','$pname','$tddate','$tdtime','$tdvenue','$bookp')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `tentdecordetail` WHERE (Bno='$tbno')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function tentbilltransaction($cid,$bno,$bdate,$cname,$contact,$ttotal,$dtotal,$amt,$disc,$namt,$adv,$bal,$duedt){
		$db=static::getDB();
		$x="INSERT INTO `tentbill`(`Bno`, `Bdate`, `Cid`, `Cname`, `Contact`, `Ttotal`, `Dtotal`, `Totalamt`, 
			`Discount`, `Newamt`, `Paid`, `Balance`, `Duedt`, `Expense`) 
		VALUES ('$bno','$bdate','$cid','$cname','$contact','$ttotal','$dtotal','$amt','$disc',
			'$namt','$adv','$bal','$duedt','0')";
		$tryx=mysqli_query($db,$x);
	}

	public function viewtenbilltrecord($bno){
		$db=static::getDB();
		$bill_data=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `tentbill` WHERE Bno='$bno'"));
		$detail_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM `tentbilldetail` WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM `tentdecordetail` WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$setting=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting WHERE No='1'"));
		$data=[
		'bill_data'=>$bill_data,
		'detail_data'=>$detail_data,
		'decor_data'=>$decor_data,
		'setting'=>$setting
		];
		return $data;
	}

	public function addcaterevent($bno,$edate){
		$db=static::getDB();
		$q="INSERT INTO `catereventtable`(`Bno`, `Edate`) VALUES ('$bno','$edate')";
		$query=mysqli_query($db,$q);
	}

	public function getmenusname($sname){
		$db=static::getDB();
		$q="SELECT * FROM stockmenu WHERE Pname LIKE '%".$sname."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function cbreakbilltable($cbno,$cedate,$cbtime,$cbvenue,$cbguest,$cbiname){
		$db=static::getDB();

		$query="SELECT * FROM `caterbreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$result=mysqli_query($db,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$a="SELECT * FROM `caterbreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
			$abcd=mysqli_query($db,$a);
			$check=mysqli_fetch_array($abcd);
			$iname=$check['Iname'];
			$niname="$iname, $cbiname";
			$c="UPDATE `caterbreakfast` SET `Iname`='$niname' WHERE (`Bno`='$cbno') AND (`Edate`='$cedate')";
			$query=mysqli_query($db,$c);		  
		}
		else {
		 	$c="INSERT INTO `caterbreakfast`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Iname`) 
		 	VALUES ('$cbno','$cedate','$cbtime','$cbvenue','$cbguest','$cbiname')";
		 	$query=mysqli_query($db,$c);
		}
		$t="SELECT * FROM `caterbreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function clunchmainbilltable($cbno,$cedate,$cltime,$clvenue,$clguest,$clminame){
		$db=static::getDB();
		$u="INSERT INTO `caterlunch`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cltime','$clvenue','$clguest','Main Course','$clminame')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `caterlunch` WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype='Main Course')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getmenustype($stype){
		$db=static::getDB();
		$q="SELECT * FROM stockmenu WHERE Smtype LIKE '%".$stype."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function clunchotherbilltable($cbno,$cedate,$cltime,$clvenue,$clguest,$clostype,$cloiname){
		$db=static::getDB();
		$u="INSERT INTO `caterlunch`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cltime','$clvenue','$clguest','$clostype','$cloiname')";
		$r=mysqli_query($db,$u);
		
		$mdata=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterlunch WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype!='Main Course')");
		$data=mysqli_fetch_all($mdata,MYSQLI_ASSOC);
		foreach ($data as $type) {
			$edata=$type['Mtype'];
			echo 
			'<tr>
				<th colspan="2">'.$edata.'</th>
			</tr>';
			$s="SELECT Item FROM caterlunch WHERE (Mtype='$edata') AND (Bno='$cbno') AND (Edate='$cedate')";
			$r=mysqli_query($db,$s);
			$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
			$i='0';
			foreach ($check as $ite) {
				echo 
				'<tr>
					<td>'.++$i.'</td>
					<td>'.$ite['Item'].'</td>
				</tr>';
			}
		}
	}

	public function chightbilltable($cbno,$cedate,$chtime,$chvenue,$chguest,$chiname){
		$db=static::getDB();

		$query="SELECT * FROM `caterhight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$result=mysqli_query($db,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$a="SELECT * FROM `caterhight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
			$abcd=mysqli_query($db,$a);
			$check=mysqli_fetch_array($abcd);
			$iname=$check['Iname'];
			$niname="$iname,$chiname";
			$c="UPDATE `caterhight` SET `Iname`='$niname' WHERE (`Bno`='$cbno') AND (`Edate`='$cedate')";
			$query=mysqli_query($db,$c);		  
		}
		else {
		 	$c="INSERT INTO `caterhight`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Iname`) 
		 	VALUES ('$cbno','$cedate','$chtime','$chvenue','$chguest','$chiname')";
		 	$query=mysqli_query($db,$c);
		}
		$t="SELECT * FROM `caterhight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function cdinnermainbilltable($cbno,$cedate,$cdtime,$cdvenue,$cdguest,$cdminame){
		$db=static::getDB();
		$u="INSERT INTO `caterdinner`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cdtime','$cdvenue','$cdguest','Main Course','$cdminame')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `caterdinner` WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype='Main Course')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function cdinnerotherbilltable($cbno,$cedate,$cdtime,$cdvenue,$cdguest,$cdostype,$cdoiname){
		$db=static::getDB();
		$u="INSERT INTO `caterdinner`(`Bno`, `Edate`, `Time`, `Venue`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cdtime','$cdvenue','$cdguest','$cdostype','$cdoiname')";
		$r=mysqli_query($db,$u);
		
		$mdata=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterdinner WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype!='Main Course')");
		$data=mysqli_fetch_all($mdata,MYSQLI_ASSOC);
		foreach ($data as $type) {
			$edata=$type['Mtype'];
			echo 
			'<tr>
				<th colspan="2">'.$edata.'</th>
			</tr>';
			$s="SELECT Item FROM caterdinner WHERE (Mtype='$edata') AND (Bno='$cbno') AND (Edate='$cedate')";
			$r=mysqli_query($db,$s);
			$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
			$i='0';
			foreach ($check as $ite) {
				echo 
				'<tr>
					<td>'.++$i.'</td>
					<td style="Text-align:left;">'.$ite['Item'].'</td>
				</tr>';
			}

		}
	}

	public function caterdecorbilltable($cbno,$cddate,$cdtime,$cdvenue,$cdpname){
		$db=static::getDB();
		$q="SELECT * FROM stockdecoration WHERE Pid='$cdpname'";
		$z=mysqli_fetch_array(mysqli_query($db,$q));
		$pname=$z['Sname'];
		$u="INSERT INTO `caterdecordetail`(`Bno`, `Sname`, `Date`, `Time`, `Venue`) 
		VALUES ('$cbno','$pname','$cddate','$cdtime','$cdvenue')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `caterdecordetail` WHERE (Bno='$cbno')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function caterbilltransaction($cid,$bno,$bdate,$cname,$contact,$amt,$disc,$namt,$adv,$bal,$duedt){
		$db=static::getDB();
		$x="INSERT INTO `caterbill`(`Bno`, `Bdate`, `Cid`, `Cname`, `Contact`, `Totalamt`, `Discount`, `Newamt`, `Paid`, 
			`Balance`, `Duedt`, `Expense`) VALUES ('$bno','$bdate','$cid','$cname','$contact','$amt','$disc',
			'$namt','$adv','$bal','$duedt','0')";
		$tryx=mysqli_query($db,$x);
	}

	public function viewcaterbilltrecord($bno){
		$db=static::getDB();
		$bill_data=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM caterbill WHERE Bno='$bno'"));
		$event_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM catereventtable WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$Decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM caterdecordetail WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$setting=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting WHERE No='2'"));
		echo '
		<div id="caterbillformat" class="tab-pane fade in active">
			<div style="margin:4px;text-align:center;">'.$setting['Btype'].'</div>
			<div style="margin:4px;text-align:center;"><h1>'.$setting['Header1'].'</h1></div>
			<div style="margin:4px;text-align:center;"><h4>'.$setting['Header2'].'</h4></div>
			<div style="margin:4px;text-align:center;"><h5>'.$setting['Header3'].'</h5></div>
			<div style="padding-left:81%;"><label>Date :</label>'.$bill_data['Bdate'].'</div>
			<div style="margin:4px;"><label>Agreement No. :</label>'.$bill_data['Bno'].'</div>
			<div style="margin:4px;"><label>Cust. Id :</label>'.$bill_data['Cid'].'</div>
			<div style="margin:4px;"><label>Customer Name :</label>'.$bill_data['Cname'].'</div>
			<div style="margin:4px;"><label>Contact :</label>'.$bill_data['Contact'].'</div>';
			foreach ($event_data as $edate) {
				$event=$edate['Edate'];
				$b=mysqli_query($db,"SELECT * FROM `caterbreakfast` WHERE (Edate='$event') AND (Bno='$bno')");
				$break=mysqli_fetch_array($b);
				$h=mysqli_query($db,"SELECT * FROM `caterhight` WHERE (Edate='$event') AND (Bno='$bno')");
				$hight=mysqli_fetch_array($h);
				$clv=mysqli_query($db,"SELECT * FROM `caterlunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$venue=mysqli_fetch_array($clv);
				$clm=mysqli_query($db,"SELECT * FROM `caterlunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$lunchmain=mysqli_fetch_all($clm,MYSQLI_ASSOC);

				$clo=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterlunch WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$lunchother=mysqli_fetch_all($clo,MYSQLI_ASSOC);

				$cdv=mysqli_query($db,"SELECT * FROM `caterdinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dvenue=mysqli_fetch_array($cdv);
				$cdm=mysqli_query($db,"SELECT * FROM `caterdinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dinnermain=mysqli_fetch_all($cdm,MYSQLI_ASSOC);

				$cdo=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterdinner WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$dinnerother=mysqli_fetch_all($cdo,MYSQLI_ASSOC);
				
				echo '
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:10px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Event Date:</label>'.$edate['Edate'].'
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered"> 
									<caption>Breakfast</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$break['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$break['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$break['Venue'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$break['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Lunch</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$venue['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$venue['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$venue['Venue'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($lunchmain as $lmain) {
										echo '
											<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$lmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($lunchother as $lother) {
										$ltype=$lother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$ltype.'</label></td>
										</tr>
										';
										$s="SELECT Item FROM caterlunch WHERE (Mtype='$ltype') AND (Bno='$bno') AND (Edate='$event')";
										$r=mysqli_query($db,$s);
										$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
										$i='0';
										foreach ($check as $ite) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td>'.$ite['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<caption>High Tea</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$hight['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$hight['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$hight['Venue'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$hight['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Dinner</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$dvenue['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$dvenue['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$dvenue['Venue'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td style="text-align:center;" colspan="2"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($dinnermain as $dmain) {
										echo '
											<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$dmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($dinnerother as $dother) {
										$dtype=$dother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$dtype.'</label></td>
										</tr>
										';
										$w="SELECT Item FROM caterdinner WHERE (Mtype='$dtype') AND (Bno='$bno') AND (Edate='$event')";
										$x=mysqli_query($db,$w);
										$checkd=mysqli_fetch_all($x,MYSQLI_ASSOC);
										$i='0';
										foreach ($checkd as $ited) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$ited['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
					</div>
				';
			}
			echo '			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:5px;">
				<div class="dc col-lg-12 col-md-12 col-sm-12 col-xs-12">				
					<table class="table table-bordered">
						<thead>
							<caption><label>Decoration</label></caption>
							<tr style="height:35px;">
								<th width="5%">#</th>
								<th>Service_Name</th>
								<th>Date</th>
								<th>Time</th>
								<th>Venue</th>
							</tr>
						</thead>
						<tbody>';
							$i='0';
							foreach ($Decor_data as $decor) {
								echo '
								<tr>
									<td>'.++$i.'</td>
									<td>'.$decor['Sname'].'</td>
									<td>'.$decor['Date'].'</td>
									<td>'.$decor['Time'].'</td>
									<td>'.$decor['Venue'].'</td>
								</tr>								
								';
							}
							echo '							
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:15px 4px 4px 4px;padding-left:70%;">
				<label>Total Amount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Totalamt'].'
			</div>
			<div style="margin:4px;padding-left:73.5%;">
				<label>Discount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Discount'].'
			</div>
			<div style="margin:4px;padding-left:70.2%;">
				<label>New Amount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Newamt'].'
			</div>
			<div style="margin:4px;padding-left:69.4%;">
				<label>Advance Paid:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Paid'].'
			</div>
			<div style="margin:4px;padding-left:70.5%;">
				<label>Balance Left:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Balance'].'
			</div>
			<div style="margin:4px;padding-left:69.6%;">
				<label>Due Pay Date:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Duedt'].'
			</div>
			<div style="margin:10px;text-align:left;">
				&nbsp;&nbsp;&nbsp;<label>Amount (in words.) :</label> .............................................................................................
			</div>
			<div style="margin-top:20px;;text-align:left;">
				<span style="margin-left:3%;"><label>Customer Signature</label></span><span style="margin-left:57%;"><label>Proprietor Signature</label></span>
			</div>
			<div style="border-top:1px solid gray;"></div>
			<div class="form-group" style="margin:4px;">
				<label>Terms &amp; Conditions&nbsp;:</label>
				<textarea class="form-control" rows="15" style="font-size:14px;width:100%;border:none;">'.$setting['Terms'].'</textarea>
			</div>
			<div style="border-top:1px solid gray;margin:10px;"></div>
			<div class="form-group" style="margin:4px;text-align:center;">
				<textarea class="form-control" rows="5" style="text-align:center;width:80%;font-size:16px;margin:0 auto;border:none;">'.$setting['Footer1'].'</textarea>
			</div>
			<div class="form-group" style="margin:4px;text-align:center;">'.$setting['Footer2'].'</div>	
		</div>
		<div style="text-align:center;">
			<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
			<button class="btn btn-danger" onclick="caterprintbill()">Print</button>
		</div>
		';
	}

	public function viewtentbilldt($bno){
		$db=static::getDB();
		$tbill=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM tentbill WHERE Bno='$bno'"));
		$tbilldt=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM tentbilldetail WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$dbilldt=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM tentdecordetail WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$data=[
		'tbill'=>$tbill,
		'tbilldt'=>$tbilldt,
		'dbilldt'=>$dbilldt
		];
		return $data;
	}

	public function viewcaterbilldt($bno){
		$db=static::getDB();

		$event_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM catereventtable WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$Decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM caterdecordetail WHERE Bno='$bno'"),MYSQLI_ASSOC);

		echo '
		<div id="caterbilldetail" class="tab-pane fade in active">';
			foreach ($event_data as $edate) {
				$event=$edate['Edate'];
				$b=mysqli_query($db,"SELECT * FROM `caterbreakfast` WHERE (Edate='$event') AND (Bno='$bno')");
				$break=mysqli_fetch_array($b);
				$h=mysqli_query($db,"SELECT * FROM `caterhight` WHERE (Edate='$event') AND (Bno='$bno')");
				$hight=mysqli_fetch_array($h);
				$clv=mysqli_query($db,"SELECT * FROM `caterlunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$venue=mysqli_fetch_array($clv);
				$clm=mysqli_query($db,"SELECT * FROM `caterlunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$lunchmain=mysqli_fetch_all($clm,MYSQLI_ASSOC);

				$clo=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterlunch WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$lunchother=mysqli_fetch_all($clo,MYSQLI_ASSOC);

				$cdv=mysqli_query($db,"SELECT * FROM `caterdinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dvenue=mysqli_fetch_array($cdv);
				$cdm=mysqli_query($db,"SELECT * FROM `caterdinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dinnermain=mysqli_fetch_all($cdm,MYSQLI_ASSOC);

				$cdo=mysqli_query($db,"SELECT DISTINCT Mtype FROM caterdinner WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$dinnerother=mysqli_fetch_all($cdo,MYSQLI_ASSOC);
				
				echo '
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:10px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Event Date:</label>'.$edate['Edate'].'
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered"> 
									<caption>Breakfast</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$break['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$break['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$break['Venue'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$break['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Lunch</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$venue['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$venue['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$venue['Venue'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($lunchmain as $lmain) {
										echo '
											<tr>
												<td>'.++$i.'</td>
												<td>'.$lmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($lunchother as $lother) {
										$ltype=$lother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$ltype.'</label></td>
										</tr>
										';
										$s="SELECT Item FROM caterlunch WHERE (Mtype='$ltype') AND (Bno='$bno') AND (Edate='$event')";
										$r=mysqli_query($db,$s);
										$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
										$i='0';
										foreach ($check as $ite) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td>'.$ite['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<caption>High Tea</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$hight['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$hight['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$hight['Venue'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$hight['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Dinner</caption>
									<thead>
										<tr>
											<td style="text-align:left;"><label>Guests:&nbsp;</label>&nbsp;'.$dvenue['Guest'].'</td>
											<td style="text-align:left;"><label>Time:&nbsp;</label>&nbsp;'.$dvenue['Time'].'</td>
											<td style="text-align:left;" colspan="2"><label>Venue:&nbsp;</label>&nbsp;'.$dvenue['Venue'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($dinnermain as $dmain) {
										echo '
											<tr>
												<td>'.++$i.'</td>
												<td>'.$dmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($dinnerother as $dother) {
										$dtype=$dother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$dtype.'</label></td>
										</tr>
										';
										$w="SELECT Item FROM caterdinner WHERE (Mtype='$dtype') AND (Bno='$bno') AND (Edate='$event')";
										$x=mysqli_query($db,$w);
										$checkd=mysqli_fetch_all($x,MYSQLI_ASSOC);
										$i='0';
										foreach ($checkd as $ited) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td>'.$ited['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
					</div>
				';
			}
			echo '			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:5px;">
				<div class="dc col-lg-12 col-md-12 col-sm-12 col-xs-12">				
					<table class="table table-bordered">
						<thead>
							<caption><label>Decoration</label></caption>
							<tr style="height:35px;">
								<th width="5%">#</th>
								<th>Service_Name</th>
								<th>Date</th>
								<th>Time</th>
								<th>Venue</th>
							</tr>
						</thead>
						<tbody>';
							$i='0';
							foreach ($Decor_data as $decor) {
								echo '
								<tr>
									<td>'.++$i.'</td>
									<td>'.$decor['Sname'].'</td>
									<td>'.$decor['Date'].'</td>
									<td>'.$decor['Time'].'</td>
									<td>'.$decor['Venue'].'</td>
								</tr>								
								';
							}
							echo '							
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div style="text-align:center;">
		   	<a type="button" class="btn btn-success" href="/billing/index" style="margin-top:20px;">Close</a>
	 		<a type="button" class="btn btn-danger" onclick="printcaterbilldetail()" style="margin-top:20px;">Print</a>
		</div>
		';
	}

	public function gettentbillpay($bno){
		$db=static::getDB();
		$q="SELECT * FROM `tentbill` WHERE Bno='$bno'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function addtentpayment($data){
		$db=static::getDB();
		$bno=$data['bno'];
		$nduedt=$data['nduedt'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];
		$p="INSERT INTO `billpaydetail`(`Category`, `Bno`, `Date`, `Mode`, `Amount`) 
		VALUES ('Tent','$bno','$paydt','$mode','$payamt')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `tentbill` WHERE Bno='$bno'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$bal=$row['Balance']-$payamt;
		$adv=$row['Paid']+$payamt;
		$r="UPDATE `tentbill` SET `Paid`='$adv',`Balance`='$bal',`Duedt`='$nduedt' WHERE `Bno`='$bno'";
		$check=mysqli_query($db,$r);
		if($check & $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function getcaterbillpay($bno){
		$db=static::getDB();
		$q="SELECT * FROM `caterbill` WHERE (Bno='$bno')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function addcaterpayment($data){
		$db=static::getDB();
		$nduedt=$data['nduedt'];
		$bno=$data['bno'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];

		$p="INSERT INTO `billpaydetail`(`Category`, `Bno`, `Date`, `Mode`, `Amount`) 
		VALUES ('Catering','$bno','$paydt','$mode','$payamt')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `caterbill` WHERE Bno='$bno'";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$bal=$row['Balance']-$payamt;
		$adv=$row['Paid']+$payamt;
		$r="UPDATE `caterbill` SET `Paid`='$adv',`Balance`='$bal',`Duedt`='$nduedt' WHERE `Bno`='$bno'";
		$check=mysqli_query($db,$r);
		if($check & $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function getpaidbilldata($cat,$bno){
		$db=static::getDB();
		$q="SELECT * FROM `billpaydetail` WHERE (Bno='$bno') AND (Category='$cat')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function addestimateevent($bno,$edate){
		$db=static::getDB();
		$q="INSERT INTO `estimateeventtable`(`Bno`, `Edate`) VALUES ('$bno','$edate')";
		$query=mysqli_query($db,$q);
	}

	public function ebreakbilltable($cbno,$cedate,$cbguest,$cbiname){
		$db=static::getDB();

		$query="SELECT * FROM `estimatebreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$result=mysqli_query($db,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$a="SELECT * FROM `estimatebreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
			$abcd=mysqli_query($db,$a);
			$check=mysqli_fetch_array($abcd);
			$iname=$check['Iname'];
			$niname="$iname,$cbiname";
			$c="UPDATE `estimatebreakfast` SET `Iname`='$niname' WHERE (`Bno`='$cbno') AND (`Edate`='$cedate')";
			$query=mysqli_query($db,$c);		  
		}
		else {
		 	$c="INSERT INTO `estimatebreakfast`(`Bno`, `Edate`, `Guest`, `Iname`) 
		 	VALUES ('$cbno','$cedate','$cbguest','$cbiname')";
		 	$query=mysqli_query($db,$c);
		}
		$t="SELECT * FROM `estimatebreakfast` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function elunchmainbilltable($cbno,$cedate,$clguest,$clminame){
		$db=static::getDB();
		$u="INSERT INTO `estimatelunch`(`Bno`, `Edate`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$clguest','Main Course','$clminame')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `estimatelunch` WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype='Main Course')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function elunchotherbilltable($cbno,$cedate,$clguest,$clostype,$cloiname){
		$db=static::getDB();
		$u="INSERT INTO `estimatelunch`(`Bno`, `Edate`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$clguest','$clostype','$cloiname')";
		$r=mysqli_query($db,$u);
		
		$mdata=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatelunch WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype!='Main Course')");
		$data=mysqli_fetch_all($mdata,MYSQLI_ASSOC);
		foreach ($data as $type) {
			$edata=$type['Mtype'];
			echo 
			'<tr>
				<th colspan="2">'.$edata.'</th>
			</tr>';
			$s="SELECT Item FROM estimatelunch WHERE (Mtype='$edata') AND (Bno='$cbno') AND (Edate='$cedate')";
			$r=mysqli_query($db,$s);
			$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
			$i='0';
			foreach ($check as $ite) {
				echo 
				'<tr>
					<td>'.++$i.'</td>
					<td>'.$ite['Item'].'</td>
				</tr>';
			}
		}
	}

	public function ehightbilltable($cbno,$cedate,$chguest,$chiname){
		$db=static::getDB();

		$query="SELECT * FROM `estimatehight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$result=mysqli_query($db,$query);
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			$a="SELECT * FROM `estimatehight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
			$abcd=mysqli_query($db,$a);
			$check=mysqli_fetch_array($abcd);
			$iname=$check['Iname'];
			$niname="$iname,$chiname";
			$c="UPDATE `estimatehight` SET `Iname`='$niname' WHERE (`Bno`='$cbno') AND (`Edate`='$cedate')";
			$query=mysqli_query($db,$c);		  
		}
		else {
		 	$c="INSERT INTO `estimatehight`(`Bno`, `Edate`, `Guest`, `Iname`) 
		 	VALUES ('$cbno','$cedate','$chguest','$chiname')";
		 	$query=mysqli_query($db,$c);
		}
		$t="SELECT * FROM `estimatehight` WHERE (Bno='$cbno') AND (Edate='$cedate')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function edinnermainbilltable($cbno,$cedate,$cdguest,$cdminame){
		$db=static::getDB();
		$u="INSERT INTO `estimatedinner`(`Bno`, `Edate`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cdguest','Main Course','$cdminame')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `estimatedinner` WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype='Main Course')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function edinnerotherbilltable($cbno,$cedate,$cdguest,$cdostype,$cdoiname){
		$db=static::getDB();
		$u="INSERT INTO `estimatedinner`(`Bno`, `Edate`, `Guest`, `Mtype`, `Item`) 
		VALUES ('$cbno','$cedate','$cdguest','$cdostype','$cdoiname')";
		$r=mysqli_query($db,$u);
		
		$mdata=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatedinner WHERE (Bno='$cbno') AND (Edate='$cedate') AND (Mtype!='Main Course')");
		$data=mysqli_fetch_all($mdata,MYSQLI_ASSOC);
		foreach ($data as $type) {
			$edata=$type['Mtype'];
			echo 
			'<tr>
				<th colspan="2">'.$edata.'</th>
			</tr>';
			$s="SELECT Item FROM estimatedinner WHERE (Mtype='$edata') AND (Bno='$cbno') AND (Edate='$cedate')";
			$r=mysqli_query($db,$s);
			$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
			$i='0';
			foreach ($check as $ite) {
				echo 
				'<tr>
					<td>'.++$i.'</td>
					<td style="Text-align:left;">'.$ite['Item'].'</td>
				</tr>';
			}

		}
	}

	public function estimatedecorbilltable($cbno,$cddate,$cdpname){
		$db=static::getDB();
		$q="SELECT * FROM stockdecoration WHERE Pid='$cdpname'";
		$z=mysqli_fetch_array(mysqli_query($db,$q));
		$pname=$z['Sname'];
		$u="INSERT INTO `estimatedecordetail`(`Bno`, `Sname`, `Date`) 
		VALUES ('$cbno','$pname','$cddate')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `estimatedecordetail` WHERE (Bno='$cbno')";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function estimatebilltransaction($cid,$bno,$bdate,$cname,$contact,$amt,$disc,$namt){
		$db=static::getDB();
		$x="INSERT INTO `estimatebill`(`Bno`, `Bdate`, `Cid`, `Cname`, `Contact`, `Totalamt`, `Discount`, `Newamt`) 
		VALUES ('$bno','$bdate','$cid','$cname','$contact','$amt','$disc','$namt')";
		$tryx=mysqli_query($db,$x);
	}

	public function viewestimatebilltrecord($bno){
		$db=static::getDB();
		$bill_data=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM estimatebill WHERE Bno='$bno'"));
		$event_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM estimateeventtable WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$Decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM estimatedecordetail WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$setting=mysqli_fetch_array(mysqli_query($db,"SELECT * FROM setting WHERE No='3'"));
		echo '
		<div id="estimatebillformat" class="tab-pane fade in active">
			<div style="margin:4px;text-align:center;">'.$setting['Btype'].'</div>
			<div style="margin:4px;text-align:center;"><h1>'.$setting['Header1'].'</h1></div>
			<div style="margin:4px;text-align:center;"><h4>'.$setting['Header2'].'</h4></div>
			<div style="margin:4px;text-align:center;"><h5>'.$setting['Header3'].'</h5></div>
			<div style="padding-left:81%;"><label>Date :</label>'.$bill_data['Bdate'].'</div>
			<div style="margin:4px;"><label>Estimate No. :</label>'.$bill_data['Bno'].'</div>
			<div style="margin:4px;"><label>Cust. Id :</label>'.$bill_data['Cid'].'</div>
			<div style="margin:4px;"><label>Customer Name :</label>'.$bill_data['Cname'].'</div>
			<div style="margin:4px;"><label>Contact :</label>'.$bill_data['Contact'].'</div>';
			foreach ($event_data as $edate) {
				$event=$edate['Edate'];
				$b=mysqli_query($db,"SELECT * FROM `estimatebreakfast` WHERE (Edate='$event') AND (Bno='$bno')");
				$break=mysqli_fetch_array($b);
				$h=mysqli_query($db,"SELECT * FROM `estimatehight` WHERE (Edate='$event') AND (Bno='$bno')");
				$hight=mysqli_fetch_array($h);
				$clv=mysqli_query($db,"SELECT * FROM `estimatelunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$venue=mysqli_fetch_array($clv);
				$clm=mysqli_query($db,"SELECT * FROM `estimatelunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$lunchmain=mysqli_fetch_all($clm,MYSQLI_ASSOC);

				$clo=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatelunch WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$lunchother=mysqli_fetch_all($clo,MYSQLI_ASSOC);

				$cdv=mysqli_query($db,"SELECT * FROM `estimatedinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dvenue=mysqli_fetch_array($cdv);
				$cdm=mysqli_query($db,"SELECT * FROM `estimatedinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dinnermain=mysqli_fetch_all($cdm,MYSQLI_ASSOC);

				$cdo=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatedinner WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$dinnerother=mysqli_fetch_all($cdo,MYSQLI_ASSOC);
				
				echo '
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:10px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Event Date:</label>'.$edate['Edate'].'
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered"> 
									<caption>Breakfast</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$break['Guest'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$break['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Lunch</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$venue['Guest'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($lunchmain as $lmain) {
										echo '
											<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$lmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($lunchother as $lother) {
										$ltype=$lother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$ltype.'</label></td>
										</tr>
										';
										$s="SELECT Item FROM estimatelunch WHERE (Mtype='$ltype') AND (Bno='$bno') AND (Edate='$event')";
										$r=mysqli_query($db,$s);
										$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
										$i='0';
										foreach ($check as $ite) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$ite['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<caption>High Tea</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$hight['Guest'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$hight['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Dinner</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$dvenue['Guest'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($dinnermain as $dmain) {
										echo '
											<tr>
												<td>'.++$i.'</td>
												<td style="text-align:left;">'.$dmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($dinnerother as $dother) {
										$dtype=$dother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$dtype.'</label></td>
										</tr>
										';
										$w="SELECT Item FROM estimatedinner WHERE (Mtype='$dtype') AND (Bno='$bno') AND (Edate='$event')";
										$x=mysqli_query($db,$w);
										$checkd=mysqli_fetch_all($x,MYSQLI_ASSOC);
										$i='0';
										foreach ($checkd as $ited) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$ited['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
					</div>
				';
			}
			echo '			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:5px;">
				<div class="dc col-lg-12 col-md-12 col-sm-12 col-xs-12">				
					<table class="table table-bordered">
						<thead>
							<caption><label>Decoration</label></caption>
							<tr style="height:35px;">
								<th width="5%">#</th>
								<th>Service_Name</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>';
							$i='0';
							foreach ($Decor_data as $decor) {
								echo '
								<tr>
									<td>'.++$i.'</td>
									<td>'.$decor['Sname'].'</td>
									<td>'.$decor['Date'].'</td>
								</tr>								
								';
							}
							echo '							
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:15px 4px 4px 4px;padding-left:70%;">
				<label>Total Amount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Totalamt'].'
			</div>
			<div style="margin:4px;padding-left:73.5%;">
				<label>Discount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Discount'].'
			</div>
			<div style="margin:4px;padding-left:70.2%;">
				<label>New Amount:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$bill_data['Newamt'].'
			</div>
			<div style="margin:10px;text-align:left;">
				&nbsp;&nbsp;&nbsp;<label>Amount (in words.) :</label> .............................................................................................
			</div>
			<div style="margin-top:20px;;text-align:left;">
				<span style="margin-left:3%;"><label>Customer Signature</label></span><span style="margin-left:57%;"><label>Proprietor Signature</label></span>
			</div>
			<div style="border-top:1px solid gray;"></div>
			<div class="form-group" style="margin:4px;">
				<label>Terms &amp; Conditions&nbsp;:</label>
				<textarea class="form-control" rows="15" style="font-size:14px;width:100%;border:none;">'.$setting['Terms'].'</textarea>
			</div>
			<div style="border-top:1px solid gray;margin:10px;"></div>
			<div class="form-group" style="margin:4px;text-align:center;">
				<textarea class="form-control" rows="5" style="text-align:center;width:80%;font-size:16px;margin:0 auto;border:none;">'.$setting['Footer1'].'</textarea>
			</div>
			<div class="form-group" style="margin:4px;text-align:center;">'.$setting['Footer2'].'</div>	
		</div>
		<div style="text-align:center;">
			<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
			<button class="btn btn-danger" onclick="estimateprintbill()">Print</button>
		</div>
		';
	}

	public function viewestimatebilldt($bno){
		$db=static::getDB();

		$event_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM estimateeventtable WHERE Bno='$bno'"),MYSQLI_ASSOC);
		$Decor_data=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM estimatedecordetail WHERE Bno='$bno'"),MYSQLI_ASSOC);

		echo '
		<div id="estimatebilldetail" class="tab-pane fade in active">';
			foreach ($event_data as $edate) {
				$event=$edate['Edate'];
				$b=mysqli_query($db,"SELECT * FROM `estimatebreakfast` WHERE (Edate='$event') AND (Bno='$bno')");
				$break=mysqli_fetch_array($b);
				$h=mysqli_query($db,"SELECT * FROM `estimatehight` WHERE (Edate='$event') AND (Bno='$bno')");
				$hight=mysqli_fetch_array($h);
				$clv=mysqli_query($db,"SELECT * FROM `estimatelunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$venue=mysqli_fetch_array($clv);
				$clm=mysqli_query($db,"SELECT * FROM `estimatelunch` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$lunchmain=mysqli_fetch_all($clm,MYSQLI_ASSOC);

				$clo=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatelunch WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$lunchother=mysqli_fetch_all($clo,MYSQLI_ASSOC);

				$cdv=mysqli_query($db,"SELECT * FROM `estimatedinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dvenue=mysqli_fetch_array($cdv);
				$cdm=mysqli_query($db,"SELECT * FROM `estimatedinner` WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype='Main Course')");
				$dinnermain=mysqli_fetch_all($cdm,MYSQLI_ASSOC);

				$cdo=mysqli_query($db,"SELECT DISTINCT Mtype FROM estimatedinner WHERE (Bno='$bno') AND (Edate='$event') AND (Mtype!='Main Course')");
				$dinnerother=mysqli_fetch_all($cdo,MYSQLI_ASSOC);
				
				echo '
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:10px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Event Date:</label>'.$edate['Edate'].'
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered"> 
									<caption>Breakfast</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$break['Guest'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$break['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Lunch</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$venue['Guest'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($lunchmain as $lmain) {
										echo '
											<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$lmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($lunchother as $lother) {
										$ltype=$lother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$ltype.'</label></td>
										</tr>
										';
										$s="SELECT Item FROM estimatelunch WHERE (Mtype='$ltype') AND (Bno='$bno') AND (Edate='$event')";
										$r=mysqli_query($db,$s);
										$check=mysqli_fetch_all($r,MYSQLI_ASSOC);
										$i='0';
										foreach ($check as $ite) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$ite['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<caption>High Tea</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$hight['Guest'].'</td>
										</tr>
										<tr>
											<th colspan="4">Item Name</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="4" style="text-align:left;">'.$hight['Iname'].'</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" style="margin-bottom:-21px;">
								<table class="table table-bordered">
									<caption>Dinner</caption>
									<thead>
										<tr>
											<td colspan="4" style="text-align:left;"><label>Guests:</label>'.$dvenue['Guest'].'</td>
										</tr>
									</thead>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:left;">
								<table class="table table-bordered">
									<thead>
										<tr>
											<td colspan="2" style="text-align:center;"><label>Main Course</label></td>
										</tr>
									</thead>
									<tbody>';
									$i='0';
									foreach ($dinnermain as $dmain) {
										echo '
											<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$dmain['Item'].'</td>
											</tr>
										';
									}
									echo '	
									</tbody>
								</table>
							</div>
							<div class="table-responsive"style="width:50%;float:right;">
								<table class="table table-bordered">
									<tbody>';
									foreach ($dinnerother as $dother) {
										$dtype=$dother['Mtype'];
										echo'
										<tr>
											<td colspan="2" style="text-align:center;"><label>'.$dtype.'</label></td>
										</tr>
										';
										$w="SELECT Item FROM estimatedinner WHERE (Mtype='$dtype') AND (Bno='$bno') AND (Edate='$event')";
										$x=mysqli_query($db,$w);
										$checkd=mysqli_fetch_all($x,MYSQLI_ASSOC);
										$i='0';
										foreach ($checkd as $ited) {
											echo 
											'<tr>
												<td style="width:15px;">'.++$i.'</td>
												<td style="text-align:left;">'.$ited['Item'].'</td>
											</tr>';
										}
									}
									echo '
									</tbody>
								</table>
							</div>
						</div>
					</div>
				';
			}
			echo '			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid gray;padding:10px;margin-top:5px;">
				<div class="dc col-lg-12 col-md-12 col-sm-12 col-xs-12">				
					<table class="table table-bordered">
						<thead>
							<caption><label>Decoration</label></caption>
							<tr style="height:35px;">
								<th width="5%">#</th>
								<th>Service_Name</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>';
							$i='0';
							foreach ($Decor_data as $decor) {
								echo '
								<tr>
									<td>'.++$i.'</td>
									<td>'.$decor['Sname'].'</td>
									<td>'.$decor['Date'].'</td>
								</tr>								
								';
							}
							echo '							
						</tbody>
					</table>
				</div>
			</div>

		</div>
		<div style="text-align:center;">
		   	<a type="button" class="btn btn-success" href="/billing/index" style="margin-top:20px;">Close</a>
	 		<a type="button" class="btn btn-danger" onclick="printestimatebilldetail()" style="margin-top:20px;">Print</a>
		</div>
		';
	}

}
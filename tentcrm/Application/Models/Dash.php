<?php
namespace application\Models;
use PDO;
class Dash extends \Core\Model
{	
	public function viewallduesbooks(){
		$db=static::getDB();

		$today=date('20y-m-d');
		$preday=date('20y-m-d', strtotime('-30 days'));
		$nextday=date('20y-m-d', strtotime('+1 days'));

		$t=mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) AS tcount FROM tentbill WHERE Duedt='$today'"));
		$c=mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) AS ccount FROM caterbill WHERE Duedt='$today'"));
		$due_rows=$t['tcount']+$c['ccount'];

		$tearn=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Paid) AS earn FROM tentbill WHERE (Bdate<='$today' AND Bdate>='$preday')"));
		$cearn=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Paid) AS earn FROM caterbill WHERE (Bdate<='$today' AND Bdate>='$preday')"));
		$total_earn=$tearn['earn']+$cearn['earn'];

		$epay=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amount) AS pay FROM empsalarydetail WHERE (Paydate<='$today' AND Paydate>='$preday')"));
		$spay=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amt) AS pay FROM suppaydetail WHERE (Date<='$today' AND Date>='$preday')"));
		$rpay=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amt) AS pay FROM rentpaydetail WHERE (Date<='$today' AND Date>='$preday')"));
		$bexp=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amount) AS exp FROM billexpensedetail WHERE (Edate<='$today' AND Edate>='$preday')"));
		$pexp=mysqli_fetch_array(mysqli_query($db,"SELECT SUM(Amount) AS exp FROM persexpdetail WHERE (Edate<='$today' AND Edate>='$preday')"));
		$total_exp=$epay['pay']+$spay['pay']+$rpay['pay']+$bexp['exp']+$pexp['exp'];

		$total_income=$total_earn-$total_exp;

		$break_book=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cb.Time,cb.Venue from caterbill b join caterbreakfast cb on b.Bno = cb.Bno where cb.Edate ='$nextday' ORDER BY cb.Bno ASC"),MYSQLI_ASSOC);
		$lunch_book=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cl.Time,cl.Venue from caterbill b join caterlunch cl on b.Bno = cl.Bno where cl.Edate ='$nextday' GROUP BY cl.Bno ORDER BY cl.Bno ASC"),MYSQLI_ASSOC);
		$hight_book=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, ch.Time,ch.Venue from caterbill b join caterhight ch on b.Bno = ch.Bno where ch.Edate ='$nextday' ORDER BY ch.Bno ASC"),MYSQLI_ASSOC);
		$dinner_book=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cr.Time,cr.Venue from caterbill b join caterdinner cr on b.Bno = cr.Bno where cr.Edate ='$nextday' GROUP BY cr.Bno ORDER BY cr.Bno ASC"),MYSQLI_ASSOC);
		$decor_book=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cd.Sname,cd.Time,cd.Venue from caterbill b join caterdecordetail cd on b.Bno = cd.Bno where cd.Date ='$nextday' ORDER BY cd.Bno ASC"),MYSQLI_ASSOC);
		$tdecor_book=mysqli_fetch_all(mysqli_query($db,"select tb.Bno,tb.Cid,tb.Cname,tb.Contact, td.Sname,td.Time,td.Venue from tentbill tb join tentdecordetail td on tb.Bno = td.Bno where td.Date ='$nextday' ORDER BY tb.Bno ASC"),MYSQLI_ASSOC);

		//$et=mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) AS count FROM catereventtable WHERE Edate='$nextday'"));
		$cd=mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) AS count FROM caterdecordetail WHERE Date='$nextday'"));
		$td=mysqli_fetch_array(mysqli_query($db,"SELECT COUNT(*) AS count FROM tentdecordetail WHERE Date='$nextday'"));
		$cb=mysqli_num_rows(mysqli_query($db,"SELECT * FROM caterbreakfast WHERE EDate='$nextday' GROUP BY Bno"));
		$cl=mysqli_num_rows(mysqli_query($db,"SELECT * FROM caterlunch WHERE EDate='$nextday' GROUP BY Bno"));
		$ch=mysqli_num_rows(mysqli_query($db,"SELECT * FROM caterhight WHERE EDate='$nextday' GROUP BY Bno"));
		$cr=mysqli_num_rows(mysqli_query($db,"SELECT * FROM caterdinner WHERE EDate='$nextday' GROUP BY Bno"));

		$bookings=$cb+$cl+$ch+$cr+$cd['count']+$td['count'];

		$tentdue=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM tentbill WHERE Duedt='$today'"),MYSQLI_ASSOC);
		$caterdue=mysqli_fetch_all(mysqli_query($db,"SELECT * FROM caterbill WHERE Duedt='$today'"),MYSQLI_ASSOC);
		$data=[
		'due_rows'=>$due_rows,
		'bookings'=>$bookings,
		'total_earn'=>$total_earn,
		'total_exp'=>$total_exp,
		'total_income'=>$total_income,
		'break_book'=>$break_book,
		'lunch_book'=>$lunch_book,
		'hight_book'=>$hight_book,
		'dinner_book'=>$dinner_book,
		'decor_book'=>$decor_book,
		'tdecor_book'=>$tdecor_book,
		'tentdue'=>$tentdue,
		'caterdue'=>$caterdue
		];
		return $data;
	}
	public function getcbillbookrcd($bdt){
		$db=static::getDB();

		$break_data=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cb.Time,cb.Venue from caterbill b join caterbreakfast cb on b.Bno = cb.Bno where cb.Edate ='$bdt' ORDER BY cb.Bno ASC"),MYSQLI_ASSOC);
		$lunch_data=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cl.Time,cl.Venue from caterbill b join caterlunch cl on b.Bno = cl.Bno where cl.Edate ='$bdt' GROUP BY cl.Bno ORDER BY cl.Bno ASC"),MYSQLI_ASSOC);
		$hight_data=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, ch.Time,ch.Venue from caterbill b join caterhight ch on b.Bno = ch.Bno where ch.Edate ='$bdt' ORDER BY ch.Bno ASC"),MYSQLI_ASSOC);
		$dinner_data=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cr.Time,cr.Venue from caterbill b join caterdinner cr on b.Bno = cr.Bno where cr.Edate ='$bdt' GROUP BY cr.Bno ORDER BY cr.Bno ASC"),MYSQLI_ASSOC);
		$decor_data=mysqli_fetch_all(mysqli_query($db,"select b.Bno,b.Cid,b.Cname,b.Contact, cd.Sname,cd.Time,cd.Venue from caterbill b join caterdecordetail cd on b.Bno = cd.Bno where cd.Date ='$bdt' ORDER BY cd.Bno ASC"),MYSQLI_ASSOC);
		$data=[
		'break_data'=>$break_data,
		'lunch_data'=>$lunch_data,
		'hight_data'=>$hight_data,
		'dinner_data'=>$dinner_data,
		'decor_data'=>$decor_data
		];
		return $data;
	}

	public function gettbillbookrcd($bdt){
		$db=static::getDB();
		$q="select tb.Bno,tb.Cid,tb.Cname,tb.Contact, td.Sname,td.Time,td.Venue from tentbill tb join tentdecordetail td on tb.Bno = td.Bno where td.Date ='$bdt' ORDER BY tb.Bno ASC";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getcbillduercd($bdt){
		$db=static::getDB();
		$q="SELECT * FROM `caterbill` WHERE (Duedt='$bdt')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function gettbillduercd($bdt){
		$db=static::getDB();
		$q="SELECT * FROM `tentbill` WHERE (Duedt='$bdt')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getcaterbillpay($bno){
		$db=static::getDB();
		$q="SELECT * FROM `caterbill` WHERE (Bno='$bno')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_array($check);
		return $edata;
	}

	public function addcaterexpense($data){
		$db=static::getDB();
		$bno=$data['bno'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];
		$purpose=$data['purpose'];
		$p="INSERT INTO `billexpensedetail`(`Category`, `Bno`, `EDate`, `Amount`, `Purpose`, `Mode`) 
		VALUES ('Catering','$bno','$paydt','$payamt','$purpose','$mode')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `caterbill` WHERE (Bno='$bno')";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$exp=$row['Expense']+$payamt;
		$r="UPDATE `caterbill` SET `Expense`='$exp' WHERE (`Bno`='$bno')";
		$check=mysqli_query($db,$r);
		if($check & $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function gettentbillpay($bno){
		$db=static::getDB();
		$q="SELECT * FROM `tentbill` WHERE (Bno='$bno')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function addtentexpense($data){
		$db=static::getDB();
		$bno=$data['bno'];
		$paydt=$data['paydt'];
		$payamt=$data['payamt'];
		$mode=$data['mode'];
		$purpose=$data['purpose'];
		$p="INSERT INTO `billexpensedetail`(`Category`, `Bno`, `EDate`, `Amount`, `Purpose`, `Mode`) 
		VALUES ('Tent','$bno','$paydt','$payamt','$purpose','$mode')";
		$solve=mysqli_query($db,$p);
		$q="SELECT * FROM `tentbill` WHERE (Bno='$bno')";
		$query=mysqli_query($db,$q);
		$row=mysqli_fetch_array($query);
		$exp=$row['Expense']+$payamt;
		$r="UPDATE `tentbill` SET `Expense`='$exp' WHERE (`Bno`='$bno')";
		$check=mysqli_query($db,$r);
		if($check & $solve){
			$message="Successfully Updated";
		}
		else{
			$message="Updation Failed";
		}
		return $message;
	}

	public function addpersexpdetail($date,$amount,$reason,$mode){
		$db=static::getDB();
		$message="";
		$q="INSERT INTO `persexpdetail`(`Edate`, `Amount`, `Reason`, `Mode`) 
		VALUES ('$date','$amount','$reason','$mode')";		
		$check=mysqli_query($db,$q);
		if($check){
			$message="Expense Added Successfully";
		}
		else{
			$message="Adding expense Failed";
		}
		return $message;
	}

	public function getexpensebilldata($type,$bno){
		$db=static::getDB();
		$q="SELECT * FROM `billexpensedetail` WHERE (Bno='$bno') AND (Category='$type')";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getexpensepbilldata($date){
		$db=static::getDB();
		$q="SELECT * FROM `persexpdetail` WHERE Edate='$date'";
		$check=mysqli_query($db,$q);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}

	public function getempname($ename){
		$db=static::getDB();
		$q="SELECT * FROM empregister WHERE Fname LIKE '%".$ename."%'";
		$query=mysqli_query($db,$q);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		return $result;
	}

	public function empattdtable($date,$id,$attd){
		$db=static::getDB();
		$q="SELECT * FROM empregister WHERE Eid='$id'";
		$z=mysqli_fetch_array(mysqli_query($db,$q));
		$fname=$z['Fname'];
		$lname=$z['Lname'];
		$ename="$fname $lname";
		$u="INSERT INTO `empdailyattd`(`Adate`, `Eid`, `Ename`, `Attendance`) 
		VALUES ('$date','$id','$ename','$attd')";
		$r=mysqli_query($db,$u);
		$t="SELECT * FROM `empdailyattd` WHERE Adate='$date'";
		$check=mysqli_query($db,$t);
		$edata=mysqli_fetch_all($check,MYSQLI_ASSOC);
		return $edata;
	}
}
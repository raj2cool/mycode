<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Sett;
class Settings extends \Core\Controller
{
	public function indexAction()
	{
		$edata=Sett::viewbill();
		$tent=$edata['tent'];
		$cater=$edata['cater'];
		$estimate=$edata['estimate'];
		View::renderTemplate('settings.html',['tent'=>$tent,'cater'=>$cater,'estimate'=>$estimate]);
	}
	public function settent(){
		$btype=$_POST['btype'];
		$header1=$_POST['header1'];
		$header2=$_POST['header2'];
		$header3=$_POST['header3'];
		$terms=$_POST['terms'];
		$footer1=$_POST['footer1'];
		$footer2=$_POST['footer2'];

		$data=[
		'btype'=>$btype,
		'header1'=>$header1,
		'header2'=>$header2,
		'header3'=>$header3,
		'terms'=>$terms,
		'footer1'=>$footer1,
		'footer2'=>$footer2
		];
		$submitdata=Sett::settentbill($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/settings/index';
		</script>";
	}

	public function setcater(){
		$btype=$_POST['btype'];
		$header1=$_POST['header1'];
		$header2=$_POST['header2'];
		$header3=$_POST['header3'];
		$terms=$_POST['terms'];
		$footer1=$_POST['footer1'];
		$footer2=$_POST['footer2'];

		$data=[
		'btype'=>$btype,
		'header1'=>$header1,
		'header2'=>$header2,
		'header3'=>$header3,
		'terms'=>$terms,
		'footer1'=>$footer1,
		'footer2'=>$footer2
		];
		$submitdata=Sett::setcaterbill($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/settings/index';
		</script>";
	}

	public function setestimate(){
		$btype=$_POST['btype'];
		$header1=$_POST['header1'];
		$header2=$_POST['header2'];
		$header3=$_POST['header3'];
		$terms=$_POST['terms'];
		$footer1=$_POST['footer1'];
		$footer2=$_POST['footer2'];

		$data=[
		'btype'=>$btype,
		'header1'=>$header1,
		'header2'=>$header2,
		'header3'=>$header3,
		'terms'=>$terms,
		'footer1'=>$footer1,
		'footer2'=>$footer2
		];
		$submitdata=Sett::setestimatebill($data);
		echo "<script>
		alert('$submitdata');
		window.location.href='/settings/index';
		</script>";
	}

	public function changepwd(){
		$opwd=$_POST['opwd'];
		$npwd1=$_POST['npwd1'];
		$npwd2=$_POST['npwd2'];

		if($npwd1 === $npwd2){
			$data=[
			'opwd'=>$opwd,
			'npwd1'=>$npwd1
			];
			$submitdata=Sett::setpass($data);
		}
		else{
			$submitdata='New Password not matched';
		}
		echo "<script>
		alert('$submitdata');
		window.location.href='/settings/index';
		</script>";

	}
}	
<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Post;
class Home extends \Core\Controller
{	
	
	public function indexAction()
	{
		//echo 'Hello this is index from Home controller!!';
		/*View::render('Home/index.php',[
			'name'=>'Dharma',
			'colours'=>['red','green','blue']
			]);
			*/
		View::renderTemplate('login.html');
	}


	public function submitAction()
	{
		$uname=$_POST['uname'];
		$pass=md5($_POST['psw']);
		$data=[
		'uname'=>$uname,
		'pass'=>$pass,
		];
		$rety=Post::insertdata($data);
		View::renderTemplate('login.html',[
			'message'=>$retry
			]);
		
	}


	/*
	public function submitAction()
	{
		$email=$_POST['email'];
		$pass=md5($_POST['psw']);
		$passcofm=md5($_POST['psw_repeat']);
		$data=[
		'id'=>$email,
		'pass'=>$pass,
		'passcofm'=>$passcofm
		];
		$rety=Post::insertdata($data);
		View::renderTemplate('home.html',[
			'message'=>$rety
			]);
		
	}

	*/
	
}
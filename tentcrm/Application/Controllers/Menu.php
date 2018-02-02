<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Post;
class Menu extends \Core\Controller
{	
	
	public function indexAction()
	{
		View::renderTemplate('menu.html');
	}
	public function loginAction()
	{
		$uname=$_POST['uname'];
		$pass=$_POST['psw'];
		$data=[
		'uname'=>$uname,
		'pass'=>$pass,
		];
		$retry=Post::insertdata($data);
		$url=$retry['redirect'];
		$message=$retry['message'];
		View::renderTemplate($url);
	}

	public function dashboardAction()
	{
		$pass=$_POST['dpsw'];
		$retry=Post::checkdata($pass);
		View::renderTemplate('menu.html',['message'=>$retry]);
	}

	public function settingAction()
	{
		$pass=$_POST['spsw'];
		$retry=Post::checksetdata($pass);
		View::renderTemplate('menu.html',['message'=>$retry]);
	}

}
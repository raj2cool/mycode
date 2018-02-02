<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Post;
class Others extends \Core\Controller
{
	public function indexAction(){
		$edata=Post::viewdecorrecord();
		View::renderTemplate('others.html',['edata'=>$edata]);

	}	

	public function editAction(){
		$id=$_GET['id'];
		$edata=Post::getdecorrecord($id);
		View::renderTemplate('othersedit.html',['edata'=>$edata]);
	}

	public function deleteAction(){
		$id=$_GET['id'];
		print_r($id);
		$edata=Post::deletedecorrecord($id);
		header('location:/others/index');
	}	

	public function register(){
		$sname=$_POST['sname'];
		$costp=$_POST['costp'];
		$bookp=$_POST['bookp'];
		$markp=$_POST['markp'];
		$t=rand(1000,9999);
		$did="D-$t";
		$data=[
		'did'=>$did,
		'sname'=>$sname,
		'costp'=>$costp,
		'bookp'=>$bookp,
		'markp'=>$markp
		];

		$submitdata=Post::registerdecor($data);
		header('location:/others/index');
	}

	public function update(){
		$did=$_POST['did'];
		$sname=$_POST['sname'];
		$costp=$_POST['costp'];
		$bookp=$_POST['bookp'];
		$markp=$_POST['markp'];
		$data=[
		'did'=>$did,
		'sname'=>$sname,
		'costp'=>$costp,
		'bookp'=>$bookp,
		'markp'=>$markp
		];
		$submitdata=Post::updatedecor($data);
		header('location:/others/index');
	}

}
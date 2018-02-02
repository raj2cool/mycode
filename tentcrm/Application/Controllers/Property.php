<?php
namespace application\Controllers;
use \Core\View;
class Property extends \Core\Controller
{	
	
	public function indexAction()
	{
		//echo 'Hello this is index from Home controller!!';
		/*View::render('Home/index.php',[
			'name'=>'Dharma',
			'colours'=>['red','green','blue']
			]);
			*/
		View::renderTemplate('property.html');
	}
	public function detailsAction()
	{
		//echo 'Hello this is index from Home controller!!';
		/*View::render('Home/index.php',[
			'name'=>'Dharma',
			'colours'=>['red','green','blue']
			]);
			*/
		$id=$_GET['id'];
		View::renderTemplate('propertydetail.html',[
			'ida'=>$id
			]);
	}
	
}
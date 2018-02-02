<?php
namespace application\Controllers;
use \Core\View;
use \application\Models\Stok;
class Stock extends \Core\Controller
{	
	
	public function indexAction(){
		$edata=Stok::viewstockrecord();
		$tentdata=$edata['tent_stock'];
		$caterdata=$edata['cater_stock'];
		$otherdata=$edata['other_stock'];
		View::renderTemplate('stock.html',['tentdata'=>$tentdata,'caterdata'=>$caterdata,'otherdata'=>$otherdata]);
	}

}
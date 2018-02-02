<?php
namespace application\Models;
use PDO;
class Stok extends \Core\Model
{

/*  ------Stock Section------   */

	public function viewstockrecord(){
		$db=static::getDB();
		$tent_stock=mysqli_fetch_all(mysqli_query($db,"SELECT Pname, SUM(Qty) AS Qty FROM stocktent GROUP BY Pname"),MYSQLI_ASSOC);
		$cater_stock=mysqli_fetch_all(mysqli_query($db,"SELECT Pname, SUM(Qty) AS Qty FROM stockcatering GROUP BY Pname"),MYSQLI_ASSOC);
		$other_stock=mysqli_fetch_all(mysqli_query($db,"SELECT Pname, SUM(Qty) AS Qty FROM stockother GROUP BY Pname"),MYSQLI_ASSOC);		
		$data=[
		'tent_stock'=>$tent_stock,
		'cater_stock'=>$cater_stock,
		'other_stock'=>$other_stock
		];
		return $data;
	}


/*  ------End Stock Section------   */

}
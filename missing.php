<?PHP
	// Given a text file with one FastSpring order number per line,
	// this script finds any orders that were not successfully stored
	// in Shine.

	require 'includes/master.inc.php';

	$orders = file('orders.txt');
	
	$db = Database::getDatabase();
	
	foreach($orders as $o)
	{
		$o = trim($o);
		$count = $db->getValue("SELECT COUNT(*) FROM shine_orders WHERE `txn_id` = '$o'");
		if($count == 0)
		{
			echo "$o<br>\n";
		}
	}
	
	echo "Done";
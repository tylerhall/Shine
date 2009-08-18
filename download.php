<?PHP
	// This is just a helper script you can use on your website to track
	// downloads of each version of your app. Set the $app_id variable below,
	// and this will automatically redirect the user to download the most
	// recent version of your app. The downloads will be counted and reported
	// in Shine.

	require 'includes/master.inc.php';

	$app_id = 1; // Set this to the ID of the application to download
	
	$v = DBObject::glob('Version', 'SELECT * FROM versions WHERE app_id = $app_id ORDER BY dt DESC LIMIT 1');
	$v = array_pop($v);
	$v->downloads++;
	$v->update();

	Download::track();
	
	header('Location: ' . $v->url);

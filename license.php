<?PHP
	require 'includes/master.inc.php';

	$o = new Order($_GET['id']);
	if(!$o->ok()) exit;
	
	$computed_hash = md5($o->id . $_GET['x'] . Config::get('authSalt'));
	if($computed_hash !== $_GET['h']) exit;

	if((time() > $_GET['x']) && ($_GET['x'] > 0)) exit;

	$o->downloadLicense();

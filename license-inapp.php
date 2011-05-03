<?PHP
	require 'includes/master.inc.php';
	
	$post = trim(file_get_contents('php://input'));
	$post = base64_decode($post);
	$dict = json_decode($post);

	$a = new Activation();
	$a->app_id        = $dict->app_id;
	$a->name          = $dict->email;
	$a->serial_number = $dict->serial;
	$a->dt            = dater();
	$a->ip            = $_SERVER['REMOTE_ADDR'];
	$a->insert();

	$app = new Application($a->app_id);
	if(!$app->ok()) die('serial');

	$o = new Order();
	$o->select($a->serial_number, 'serial_number');
	if(!$o->ok()) die('serial');

	// Because we die before the activation is updated with the found order id,
	// this has the added benefit of highlighting the activation as "fraudulent"
	// in the activations list. It's not fraudulent obviously, but it does let
	// us quickly see if deactivated licenses are still being used.
	if($o->deactivated == 1) die('serial');

	$a->order_id = $o->id;
	$a->update();

	$o->downloadLicense();

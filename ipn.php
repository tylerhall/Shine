<?PHP
	require 'includes/master.inc.php';

	$pp = new PayPal();
	if($pp->process())
	{
		$app = new Application();
		$app->select($_POST['item_number']);
		if(!$app->ok()) error_log("Application {$_POST['item_name']} not found!");

		$o = new Order();
		$o->load($_POST);
		$o->app_id = $app->id;
		$o->dt = dater();
		$o->type = 'PayPal';		
		$o->insert();

		$o->generateLicense();
		$o->emailLicense();
	}

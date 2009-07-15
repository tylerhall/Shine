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

//https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&business=tylerh_1247547581_biz%40gmail%2ecom&item_name=Incoming&item_number=1&amount=24%2e00&no_shipping=1&no_note=1&currency_code=USD&lc=US&bn=PP%2dBuyNowBF&charset=UTF%2d8
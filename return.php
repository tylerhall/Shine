<?PHP
	require 'includes/master.inc.php';

	$o = new Order();
	$o->select($_GET['tx'], 'txn_id');

	if($o->ok())
	{
		$app = new Application($o->app_id);
		redirect($app->return_url . '?email=' . $o->payer_email . '&reg=' . $o->license);
	}
	else
	{
		die("Thank you for your order. Your registration information will be emailed to you shortly. If you have any questions, feel free to contact <a href='mailto:support@clickontyler.com'>support@clickontyler.com</a>");
	}
	

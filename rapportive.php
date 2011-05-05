<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	echo rapportive($_GET['email']);

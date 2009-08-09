<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	if(isset($_POST['btnCreateOrder']))
	{
		$Error->blank($_POST['app_id'], 'Application');
		$Error->blank($_POST['first_name'], 'First Name');
		$Error->blank($_POST['last_name'], 'Last Name');
		$Error->email($_POST['email']);
		
		if($Error->ok())
		{
			$o = new Order();
			$o->first_name  = $_POST['first_name'];
			$o->last_name   = $_POST['last_name'];
			$o->payer_email = $_POST['email'];
			$o->app_id      = $_POST['app_id'];
			$o->type        = 'Manual';
			$o->dt          = dater();
			$o->insert();

			$o->generateLicense();

			redirect('order.php?id=' . $o->id);
		}
		else
		{
			$first_name = $_POST['first_name'];
			$last_name  = $_POST['last_name'];
			$email      = $_POST['email'];
		}
	}
	else
	{
		$first_name = '';
		$last_name  = '';
		$email      = '';
	}
	
	$applications = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Shine</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="css/yuiapp.css" type="text/css">
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
</head>
<body class="rounded">
    <div id="doc3" class="yui-t6">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li class="active"><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Sparkle Stats</a></li>
                </ul>

                <ul id="user-navigation">
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<?PHP echo $Error; ?>
                    <div class="block">
                        <div class="hd">
                            <h2>Create Manual Order</h2>
                        </div>
                        <div class="bd">
							<form action="order-new.php" method="post">
								<p><label for="app_id">Application</label> <select name="app_id" id="app_id"><?PHP foreach($applications as $a) : ?><option value="<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></option><?PHP endforeach; ?></select></p>
								<p><label for="first_name">First Name</label> <input type="text" name="first_name" id="first_name" value="<?PHP echo $first_name; ?>" class="text"></p>
								<p><label for="last_name">Last Name</label> <input type="text" name="last_name" id="last_name" value="<?PHP echo $last_name; ?>" class="text"></p>
								<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?PHP echo $email; ?>" class="text"></p>
								<p><input type="submit" name="btnCreateOrder" value="Create Order" id="btnCreateOrder"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

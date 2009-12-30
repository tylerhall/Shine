<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	if(isset($_POST['btnPayPal']))
	{
		set_option('paypal_url', $_POST['ipn_url']);
		redirect('settings.php');
	}
	
	$ipn_url = get_option('paypal_url', DEFAULT_IPN_URL)
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Shine</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="css/yuiapp.css" type="text/css">
</head>
<body class="rounded">
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Sparkle Stats</a></li>
                </ul>

                <ul id="user-navigation">
                    <li><a href="users.php">Users</a></li>
                    <li class="active"><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<div class="block">
						<div class="hd">
							<h3>PayPal</h3>
						</div>
						<div class="bd">
							<form action="settings.php" method="post">
								<p>
									<label for="ipn_url">IPN URL</label> <input type="text" name="ipn_url" id="ipn_url" value="<?PHP echo $ipn_url;?>" class="text">
									<span class="info">This is where PayPal will post back to when it receives an <a href="https://www.paypal.com/ipn">instant payment notification</a>.
										<br>Default is: <a href="<?PHP echo DEFAULT_IPN_URL; ?>"><?PHP echo DEFAULT_IPN_URL; ?></a>
										<br>Testing is: <a href="<?PHP echo SANDBOX_IPN_URL; ?>"><?PHP echo SANDBOX_IPN_URL; ?></a></span>
								</p>
								<p><input type="submit" name="btnPayPal" value="Save PayPal Settings" id="btnPayPal"></p>
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

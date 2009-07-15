<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$orders = DBObject::glob('Order', 'SELECT * FROM orders ORDER BY dt DESC');

	if(isset($_GET['id']))
	{
		$app_id = intval($_GET['id']);
		$applications = DBObject::glob('Application', 'SELECT * FROM applications WHERE id = ' . $app_id . ' ORDER BY name');
	}
	else
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
</head>
<body class="rounded">
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li class="active"><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Stats</a></li>
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


                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Orders</h2>
							<ul>
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="orders.php">All Orders (<?PHP echo Order::totalOrders(); ?>)</a></li>
								<?PHP foreach($applications as $a) : ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="orders.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
								<li><a href="order-new.php">Create Manual Order</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
										<td>Application</td>
										<td>Buyer</td>
										<td>Email</td>
										<td>Type</td>
										<td>Order Date</td>
										<td>Amount</td>
										<td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($orders as $o) : ?>
									<tr>
										<td><?PHP echo $o->applicationName(); ?></td>
										<td><?PHP echo $o->first_name; ?> <?PHP echo $o->last_name ?></td>
										<td><a href="mailto:<?PHP echo $o->payer_email; ?>"><?PHP echo $o->payer_email; ?></a></td>
										<td><?PHP echo $o->type; ?></td>
										<td><?PHP echo dater($o->dt, 'm/d/Y g:ia') ?></td>
										<td>$<?PHP echo number_format($o->payment_gross, 2); ?></td>
										<td><a href="order.php?id=<?PHP echo $o->id; ?>">View</a></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
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

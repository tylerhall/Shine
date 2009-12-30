<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

    // Create a new application if needed
	if(isset($_POST['btnNewApp']) && strlen($_POST['name']))
	{
		$a = new Application();
		$a->name = $_POST['name'];
		$a->insert();
		redirect('application.php?id=' . $a->id);
	}
	
	// Get a list of our apps
	$apps   = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');
	
	// Get our recent orders
	$orders = DBObject::glob('Order', 'SELECT * FROM orders ORDER BY dt DESC LIMIT 10');

    $db = Database::getDatabase();

	// Downloads in last 24 hours
	$sel = "TIME_FORMAT(dt, '%Y%m%d%H')";
	$order_totals    = $db->getRows("SELECT $sel as dtstr, COUNT(*) FROM downloads WHERE  DATE_ADD(dt, INTERVAL 24 HOUR) > NOW() GROUP BY dtstr ORDER BY $sel ASC");
	$opw24           = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'bary');
	$opw24->showGrid   = 1;
	$opw24->dimensions = '280x100';
	$opw24->setLabelsMinMax(4,'left');
	$opw24_fb = clone $opw24;
	$opw24_fb->dimensions = '640x400';

	// Downloads in last 30 days
	$sel = "TO_DAYS(dt)";
	$order_totals    = $db->getRows("SELECT $sel as dtstr, COUNT(*) FROM downloads WHERE DATE_ADD(dt, INTERVAL 30 DAY) > NOW() GROUP BY $sel ORDER BY $sel ASC");
	$opw30           = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'bary');
	$opw30->showGrid   = 1;
	$opw30->dimensions = '280x100';
	$opw30->setLabelsMinMax(4,'left');
	$opw30_fb = clone $opw30;
	$opw30_fb->dimensions = '640x400';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Shine</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="css/yuiapp.css" type="text/css">
	<link rel="stylesheet" href="js/jquery.fancybox.css" type="text/css" media="screen">
</head>
<body class="rounded">
    <div id="doc3" class="yui-t6">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li class="active"><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Sparkle Stats</a></li>
                </ul>

                <ul id="user-navigation">
                    <li><a href="users.php">Users</a></li>
                    <li><a href="settings.php">Settings</a></li>
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
                            <h2>Your Applications</h2>
                        </div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Current Version</td>
										<td>Last Release Date</td>
										<td>Downloads / Updates / Pirates</td>
										<td>Support Questions</td>
										<td>Bug Reports</td>
										<td>Feature Requests</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($apps as $a) : ?>
									<tr>
	                                    <td><a href="application.php?id=<?PHP echo $a->id;?>"><?PHP echo $a->name; ?></a></td>
	                                    <td><?PHP echo $a->strCurrentVersion(); ?></td>
										<td><?PHP echo $a->strLastReleaseDate(); ?></td>
										<td><a href="versions.php?id=<?PHP echo $a->id; ?>"><?PHP echo number_format($a->totalDownloads()); ?></a> / <a href="versions.php?id=<?PHP echo $a->id; ?>"><?PHP echo number_format($a->totalUpdates()); ?></a> / <a href="pirates.php?id=<?PHP echo $a->id; ?>"><?PHP echo number_format($a->totalPirates()); ?></a></td>
										<td><?PHP echo $a->numSupportQuestions(); ?></td>
										<td><?PHP echo $a->numBugReports(); ?></td>
										<td><?PHP echo $a->numFeatureRequests(); ?></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
					
					<div class="block">
    					<div class="hd">
    						<h2>Recent Orders (<?PHP echo number_format(Order::totalOrders()); ?> total)</h2>
    					</div>
    					<div class="bd">
    					    <table>
    					        <thead>
    					            <tr>
    					                <td>Date</td>
    					                <td>Name</td>
    					                <td>Email</td>
    					                <td>Item Name</td>
    					            </tr>
    					        </thead>
    					        <tbody>
        							<?PHP foreach($orders as $o) : ?>
        							<tr>
        							    <td><?PHP echo dater($o->dt, 'D n/j'); ?></td>
        							    <td><a href="order.php?id=<?PHP echo $o->id; ?>"><?PHP echo utf8_encode($o->first_name); ?> <?PHP echo utf8_encode($o->last_name); ?></a></td>
        							    <td><a href="mailto:<?PHP echo $o->payer_email; ?>"><?PHP echo $o->payer_email; ?></a></td>
        							    <td><?PHP echo $o->item_name; ?></td>
        							</tr>
        							<?PHP endforeach; ?>
    					        </tbody>
    					    </table>
    					</div>
    				</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

				<div class="block">
					<div class="hd">
						<h2>Downloads 24 Hours</h2>
					</div>
					<div class="bd">
						<a href="<?PHP echo $opw24_fb->draw(false); ?>" class="fb"><?PHP $opw24->draw(); ?></a>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Downloads 30 Days</h2>
					</div>
					<div class="bd">
						<a href="<?PHP echo $opw30_fb->draw(false); ?>" class="fb"><?PHP $opw30->draw(); ?></a>
					</div>
				</div>				
				
				<div class="block">
					<div class="hd">
						<h2>Create an Application</h2>
					</div>
					<div class="bd">
						<form action="index.php" method="post">
		                    <p>
								<label for="test1">Application Name</label>
		                        <input type="text" class="text" name="name" id="appname" value="">
		                    </p>
							<p><input type="submit" name="btnNewApp" value="Create Application" id="btnNewApp"></p>
						</form>	
					</div>
				</div>				
				
            </div>
        </div>

        <div id="ft"></div>
    </div>
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.pack.js"></script>
	<script type="text/javascript" charset="utf-8">
 		$(".fb").fancybox({ 'zoomSpeedIn': 300, 'zoomSpeedOut': 300, 'overlayShow': false }); 
	</script>
</body>
</html>

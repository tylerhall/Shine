<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	if(isset($_POST['btnNewApp']) && strlen($_POST['name']))
	{
		$a = new Application();
		$a->name = $_POST['name'];
		$a->insert();
		redirect('application.php?id=' . $a->id);
	}
	
	$apps   = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');	
	$orders = DBObject::glob('Order', 'SELECT * FROM orders ORDER BY dt DESC LIMIT 5');
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
										<td>Downloads / Updates</td>
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
										<td><a href="versions.php?id=<?PHP echo $a->id; ?>"><?PHP echo number_format($a->totalDownloads()); ?></a> / <a href="versions.php?id=<?PHP echo $a->id; ?>"><?PHP echo number_format($a->totalUpdates()); ?></a></td>
										<td><?PHP echo $a->numSupportQuestions(); ?></td>
										<td><?PHP echo $a->numBugReports(); ?></td>
										<td><?PHP echo $a->numFeatureRequests(); ?></td>
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
						<h2>Recent Orderes (<?PHP echo Order::totalOrders(); ?> total)</h2>
					</div>
					<div class="bd">
						<ul class="biglist">
							<?PHP foreach($orders as $o) : ?>
							<li><a href="order.php?id=<?PHP echo $o->id; ?>"><?PHP echo $o->payer_email; ?></a></li>
							<?PHP endforeach; ?>
						</ul>
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
</body>
</html>

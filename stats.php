<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	if(isset($_GET['id']))
	{
		$app_id = intval($_GET['id']);
		$applications = DBObject::glob('Application', 'SELECT * FROM applications WHERE id = ' . $app_id . ' ORDER BY name');
	}
	else
		$applications = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');

	$db = Database::getDatabase();
	$keys = $db->getValues("SELECT DISTINCT(`key`) FROM sparkle_data");

	$reports = $db->getRows("SELECT * FROM sparkle_reports ORDER BY dt DESC");
	foreach($reports as $k => $r)
	{
		$rows = $db->getRows("SELECT * FROM sparkle_data WHERE sparkle_id = '{$r['id']}'");
		foreach($rows as $row)
		{
			$reports[$k][$row['key']] = $row['data'];
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Shimmer</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="css/yuiapp.css" type="text/css">
</head>
<body class="rounded">
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shimmer</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li class="active"><a href="stats.php">Stats</a></li>
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
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="orders.php">All Apps (<?PHP echo Order::totalOrders(); ?>)</a></li>
								<?PHP foreach($applications as $a) : ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="orders.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
										<td>Date</td>
										<?PHP foreach($keys as $k) : ?>
										<td><?PHP echo $k; ?></td>
										<?PHP endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($reports as $r) : ?>
									<tr>
										<td><?PHP echo dater($r['dt'], 'm/d/Y g:ia'); ?></td>
										<?PHP foreach($keys as $k) : ?>
										<td><?PHP echo $r[$k]; ?></td>
										<?PHP endforeach; ?>
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

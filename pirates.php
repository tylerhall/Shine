<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');

    $db = Database::getDatabase();
    $pirates = $db->getRows("SELECT * FROM pirates WHERE app_id = '{$app->id}' ORDER BY dt DESC");
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

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Applications</h2>
							<ul>
								<li><a href="application.php?id=<?PHP echo $app->id; ?>"><?PHP echo $app->name; ?></a></li>
								<li><a href="versions.php?id=<?PHP echo $app->id; ?>">Versions</a></li>
								<li class="active"><a href="pirates.php?id=<?PHP echo $app->id; ?>">Pirates</a></li>
								<li><a href="version-new.php?id=<?PHP echo $app->id; ?>">Release New Version</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<table>
								<thead>
									<tr>
										<th>IP Address</th>
										<th>GUID</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<?PHP foreach($pirates as $p) : ?>
									<tr>
									    <td><a href="http://www.geobytes.com/IpLocator.htm?GetLocation&amp;ipaddress=<?PHP echo $p['ip']; ?>"><?PHP echo $p['ip']; ?></a></td>
									    <td><?PHP echo $p['guid']; ?></td>
									    <td><?PHP echo $p['dt']; ?></td>
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

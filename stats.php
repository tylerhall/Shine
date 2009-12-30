<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$applications = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');

	$db = Database::getDatabase();
	$keys = $db->getValues("SELECT DISTINCT(`key`) FROM sparkle_data");

	$charts = array();
	foreach($keys as $k)
	{
		$data = array();
		$rows = $db->getRows("SELECT COUNT(*) as num, `data` FROM sparkle_data WHERE `key` = '$k' GROUP BY `data` ORDER BY num DESC");
		
		$count = 0;
		$total = 0;
		foreach($rows as $row)
		{
			if($count++ < 5) // Limit the pie chart to the top 5 values
			{
				$data[$row['data']] = $row['num'];
				$total += $row['num'];
			}
		}
		
		$charts[$k] = $data;
	}
	
	unset($charts['id']);
	unset($charts['appName']);
	unset($charts['appVersion']);
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
                    <li class="active"><a href="stats.php">Sparkle Stats</a></li>
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
                            <h2>Sparkle Stats</h2>
							<ul>
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="stats.php">All Apps</a></li>
								<?PHP foreach($applications as $a) : ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="stats.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
							</ul>
							<div class="clear"></div>
                        </div>
					</div>
					
					<?PHP foreach($charts as $title => $data) : ?>
					<div class="block" style="float:left;margin-right:2em;">
						<div class="hd">
							<h2><?PHP echo $title; ?></h2>
						</div>
						<div class="bd">
							<?PHP
								$gc = new googleChart(implode(',', $data), 'pie');
								$gc->setLabels(implode('|', array_keys($data)));
								$gc->draw(true);
							?>
						</div>
					</div>
					<?PHP endforeach; ?>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

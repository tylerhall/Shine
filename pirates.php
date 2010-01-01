<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');
	
	if(isset($_POST['btnSerial']))
	{
	    if(strlen($_POST['serial']) > 0)
	    {
	        $s = new Serial();
	        $s->app_id = $app->id;
	        $s->dt = dater();
	        $s->guid = $_POST['guid'];
	        $s->serial = $_POST['serial'];
	        $s->insert();
	        redirect('pirates.php?id=' . $app->id);
        }
    }

    $db = Database::getDatabase();
    $pirates = $db->getRows("SELECT * FROM pirates WHERE app_id = '{$app->id}' ORDER BY dt DESC");
    
    $serial_count = $db->getValue("SELECT COUNT(*) from pirated_serials WHERE app_id = '{$app->id}'");
    $serial_date = $db->getValue("SELECT dt FROM pirated_serials WHERE app_id = '{$app->id}' ORDER BY dt DESC LIMIT 1");
    $serial_date = $serial_date ? time2str($serial_date) : 'never';
    
    if(isset($_GET['feed']) && $_GET['feed'] == 'json')
    {
        $serials = DBObject::glob('Serial', "SELECT * from pirated_serials WHERE app_id = '{$app->id}'");
        $arr = array();
        foreach($serials as $s)
            $arr[] = array('dt' => $s->dt, 'guid' => $s->guid, 'serial' => $s->serial);
        die(json_encode($arr));
    }
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
                            <h3>Recent Pirates</h3>
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
									    <td><?PHP echo time2str($p['dt']); ?></td>
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
                        <h3>Pirate Links</h3>
                    </div>
                    <div class="bd">
                        <p><a href="http://www.mac-bb.org/search.php?do=process&amp;query=<?PHP echo $app->name; ?>">Search Mac-BB</a></p>
                    </div>
                </div>

                <div class="block">
                    <div class="hd">
                        <h3>Pirated Serials (<?PHP echo $serial_count; ?>)</h3>
                    </div>
                    <div class="bd">
                        <p>Last reported serial was <?PHP echo $serial_date; ?>.</p>
                        <p>Download <a href="pirates.php?id=<?PHP echo $app->id;?>&amp;feed=json">JSON feed</a> of serials.</p>
                    </div>
                </div>

                <div class="block">
                    <div class="hd">
                        <h3>Add New Pirated Serial</h3>
                    </div>
                    <div class="bd">
                        <form action="pirates.php?id=<?PHP echo $app->id; ?>" method="post">
                            <p><label for="guid">Name/Email/Whatever:</label><br><textarea name="guid" id="guid" style="width:100%; height:75px;"></textarea></p>
                            <p><label for="serial">Serial:</label><br><textarea name="serial" id="serial" style="width:100%; height:75px;"></textarea></p>
                            <p><input type="submit" name="btnSerial" value="Add Serial" id="btnSerial"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

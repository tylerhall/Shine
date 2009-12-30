<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	if(isset($_GET['type']))
	{
		$db = Database::getDatabase();
		$type = mysql_real_escape_string($_GET['type'], $db->db);
		$feedback = DBObject::glob('Feedback', "SELECT * FROM feedback WHERE type = '$type' ORDER BY dt DESC");
	}
	else
	{
		$feedback = DBObject::glob('Feedback', "SELECT * FROM feedback ORDER BY dt DESC");
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
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li class="active"><a href="feedback.php">Feedback</a></li>
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
                            <h2>Feedback</h2>
							<ul>
								<li <?PHP if(@$_GET['type']==''){?> class="active"<? } ?>><a href="feedback.php">All Feedback</a></li>
								<li <?PHP if(@$_GET['type']=='support'){?> class="active"<? } ?>><a href="feedback.php?type=support">Support Questions</a></li>
								<li <?PHP if(@$_GET['type']=='bug'){?> class="active"<? } ?>><a href="feedback.php?type=bug">Bug Reports</a></li>
								<li <?PHP if(@$_GET['type']=='feature'){?> class="active"<? } ?>><a href="feedback.php?type=feature">Feature Requests</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
										<td>ID</td>
										<td>Application</td>
										<td>Type</td>
										<td>Email</td>
										<td>Wants Reply?</td>
										<td>Date</td>
										<td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($feedback as $f) : ?>
									<tr class="<?PHP if($f->new == 1) echo "new"; ?>">
										<td><?PHP echo $f->id; ?></td>
										<td><?PHP echo $f->appname; ?> <?PHP echo $f->appversion; ?></td>
										<td><?PHP echo $f->type; ?></td>
										<td><?PHP echo $f->email; ?></td>
										<td><?PHP echo ($f->reply == 1) ? '<strong>Yes</strong>' : 'No'; ?></td>
										<td><?PHP echo time2str($f->dt); ?></td>
										<td><a href="feedback-view.php?id=<?PHP echo $f->id; ?>">View</a></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
					<p>Use <a href="http://github.com/tylerhall/OpenFeedback/">OpenFeedback</a> to collect feedback from your users.</p>
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				
            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

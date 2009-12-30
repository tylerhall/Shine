<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$db = Database::getDatabase();
	
	if(isset($_GET['q']))
	{
		$q = $_GET['q'];
		$_q = $db->escape($q);
		$search_sql = " AND (username LIKE '%$_q%' OR email LIKE '%$_q%') ";
	}
	else
	{
		$q = '';
		$search_sql = '';
	}

        /**
         * Add pager information
	 * $total_num_orders = $db->getValue("SELECT COUNT(*) FROM users WHERE 1 = 1 $search_sql ");
	 * $pager = new Pager(@$_GET['page'], 50, $total_num_orders);
         */
	$users = DBObject::glob('User', "SELECT * FROM users WHERE 1 = 1 $search_sql ORDER BY username"); // LIMIT {$pager->firstRecord}, {$pager->perPage}");
	$where = '';
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
                    <li><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Sparkle Stats</a></li>
                </ul>

                <ul id="user-navigation">
                    <li class="active"><a href="users.php">Users</a></li>
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
                           <h2>Users</h2>
<ul>
<li class="active"><a href="users.php">Users</a></li>
<li><a href="user-new.php">Create new user</a></li>
</ul>
<div class="clear"></div>
</div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
										<td>Username</td>
										<td>Level</td>
										<td>Email</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($users as $u) : ?>
									<tr>
										<td><?PHP echo $u->username; ?></td>
										<td><?PHP echo $u->level; ?></td>
										<td><?PHP echo $u->email; ?></td>
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
						Search Users
					</div>
					<div class="bd">
						<form action="users.php" method="get">
							<p><input type="text" name="q" value="<?PHP echo @$q; ?>" id="q" class="text">
							<span class="info">Searches Username and Email address.</span></p>
							<p><input type="submit" name="btnSearch" value="Search" id="btnSearch"></p>
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

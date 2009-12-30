<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$o = new Order(@$_GET['id']);
	if(!$o->ok()) redirect('orders.php');

	if(isset($_GET['act']) && $_GET['act'] == 'email')
		$o->emailLicense();
	
	if(isset($_GET['act']) && $_GET['act'] == 'download')
		$o->downloadLicense();

	if(isset($_GET['act']) && $_GET['act'] == 'delete')
	{
		$o->delete();
		redirect('orders.php');
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
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
</head>
<body class="rounded">
    <div id="doc3" class="yui-t6">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li class="active"><a href="orders.php">Orders</a></li>
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
                            <h2>Order #<?PHP echo $o->id; ?></h2>
                        </div>
                        <div class="bd">
							<table>
								<?PHP foreach($o->columns as $k => $v) : ?>
								<tr>
									<th><?PHP echo $k; ?></th>
									<td><?PHP echo $v; ?></td>
								</tr>
								<?PHP endforeach; ?>
							</table>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
                <div class="block">
                    <div class="hd">
                        <h3>Retrieve License</h3>
                    </div>
                    <div class="bd">
						<ul class="biglist">
							<li><a href="order.php?id=<?PHP echo $o->id; ?>&amp;act=download">Download</a></li>
							<li><a href="order.php?id=<?PHP echo $o->id; ?>&amp;act=email" id="email">Email to User</a></li>
						</ul>
					</div>
				</div>
				
				<div class="block">
					<div class="hd">
						<h3>Order Options</h3>
					</div>
					<div class="bd">
						<ul class="biglist">
							<li><a href="order.php?id=<?PHP echo $o->id; ?>&amp;act=delete" id="delete">Delete Order</a></li>
						</ul>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h3>Cut &amp; Paste License</h3>
					</div>
					<div class="bd">
						<textarea style="width:100%;"><?PHP echo "Email: {$o->payer_email}\nReg Key: {$o->license}"; ?></textarea>
					</div>
				</div>
				
            </div>
        </div>

        <div id="ft"></div>
    </div>
	<script type="text/javascript" charset="utf-8">
		google.load("jquery", "1");
		google.setOnLoadCallback(function(){
			$('#email').click(function(){return confirm('Are you sure you want to email the user their license?');});
			$('#delete').click(function(){return confirm('Are you sure you want to delete this order?');});
		});
	</script>
</body>
</html>

<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$applications = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');

	$db = Database::getDatabase();

	if(isset($_GET['id']))
	{
		$app_id = intval($_GET['id']);
		$total_num_orders = $db->getValue("SELECT COUNT(*) FROM orders WHERE app_id = $app_id ORDER BY dt DESC");
		$pager = new Pager(@$_GET['page'], 50, $total_num_orders);
		$orders = DBObject::glob('Order', "SELECT * FROM orders WHERE app_id = $app_id ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
	}
	else
	{
		$total_num_orders = $db->getValue("SELECT COUNT(*) FROM orders");
		$pager = new Pager(@$_GET['page'], 50, $total_num_orders);
		$orders = DBObject::glob('Order', "SELECT * FROM orders ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
	}

	// Orders Per Month
	$order_totals    = $db->getRows("SELECT DATE_FORMAT(dt, '%b') as dtstr, COUNT(*) FROM orders WHERE type = 'PayPal' GROUP BY CONCAT(YEAR(dt), '-', MONTH(dt)) ORDER BY YEAR(dt) ASC, MONTH(dt) ASC");
	$opm             = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'line');
	$opm->showGrid   = 1;
	$opm->dimensions = '280x100';
	$opm->setLabelsMinMax(4,'left');

	// Orders Per Week
	$order_totals    = $db->getRows("SELECT WEEK(dt) as dtstr, COUNT(*) FROM orders WHERE type = 'PayPal' GROUP BY CONCAT(YEAR(dt), WEEK(dt)) ORDER BY YEAR(dt) ASC, WEEK(dt) ASC");
	$opw             = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'line');
	$opw->showGrid   = 1;
	$opw->dimensions = '280x100';
	$opw->setLabelsMinMax(4,'left');

	// Orders Per Month Per Application
	$data = array();
	foreach($applications as $app)
		$data[$app->name] = $app->ordersPerMonth();
	$opma = new googleChart();
	$opma->smartDataLabel($data);
	$opma->showGrid   = 1;
	$opma->dimensions = '280x100';
	$opma->setLabelsMinMax(4,'left');
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
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="orders.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?> (<?PHP echo Order::totalOrders($a->id); ?>)</a></li>
								<?PHP endforeach; ?>
								<li><a href="order-new.php">Create Manual Order</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
	                        <ul class="pager">
                                <li><a href="orders.php?page=<?PHP echo $pager->prevPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">&#171; Prev</a></li>
								<?PHP for($i = 1; $i <= $pager->numPages; $i++) : ?>
								<?PHP if($i == $pager->page) : ?>
                                <li class="active"><a href="orders.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP else : ?>
                                <li><a href="orders.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP endif; ?>
								<?PHP endfor; ?>
                                <li><a href="orders.php?page=<?PHP echo $pager->nextPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">Next &#187;</a></li>
                            </ul>

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
									<tr class="<?PHP if($o->type == 'Manual') echo 'dim'; ?>">
										<td><?PHP echo $o->applicationName(); ?></td>
										<td><?PHP echo utf8_encode($o->first_name); ?> <?PHP echo utf8_encode($o->last_name); ?></td>
										<td><a href="mailto:<?PHP echo utf8_encode($o->payer_email); ?>"><?PHP echo utf8_encode($o->payer_email); ?></a></td>
										<td><?PHP echo $o->type; ?></td>
										<td><?PHP echo dater($o->dt, 'm/d/Y g:ia') ?></td>
										<td>$<?PHP echo number_format($o->payment_gross, 2); ?></td>
										<td><a href="order.php?id=<?PHP echo $o->id; ?>">View</a></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>

	                        <ul class="pager">
                                <li><a href="orders.php?page=<?PHP echo $pager->prevPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">&#171; Prev</a></li>
								<?PHP for($i = 1; $i <= $pager->numPages; $i++) : ?>
								<?PHP if($i == $pager->page) : ?>
                                <li class="active"><a href="orders.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP else : ?>
                                <li><a href="orders.php?page=<?PHP echo $i; ?>&amp;id=<?PHP echo @$app_id; ?>"><?PHP echo $i; ?></a></li>
								<?PHP endif; ?>
								<?PHP endfor; ?>
                                <li><a href="orders.php?page=<?PHP echo $pager->nextPage(); ?>&amp;id=<?PHP echo @$app_id; ?>">Next &#187;</a></li>
                            </ul>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				<div class="block">
					<div class="hd">
						<h2>Total Orders Per Month</h2>
					</div>
					<div class="bd">
						<?PHP $opm->draw(); ?>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Orders Per Week</h2>
					</div>
					<div class="bd">
						<?PHP $opw->draw(); ?>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Orders Per Month</h2>
					</div>
					<div class="bd">
						<?PHP $opma->draw(); ?>
					</div>
				</div>
            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

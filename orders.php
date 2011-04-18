<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'orders';

	$applications = DBObject::glob('Application', 'SELECT * FROM shine_applications ORDER BY name');

	$db = Database::getDatabase();
	
	if(isset($_GET['q']))
	{
		$q = $_GET['q'];
		$_q = $db->escape($q);
		$search_sql = " AND (first_name LIKE '%$_q%' OR last_name LIKE '%$_q%' OR payer_email LIKE '%$_q%') ";
	}
	else
	{
		$q = '';
		$search_sql = '';
	}

	if(isset($_GET['id']))
	{
		$app_id = intval($_GET['id']);
		$total_num_orders = $db->getValue("SELECT COUNT(*) FROM shine_orders WHERE app_id = $app_id $search_sql ORDER BY dt DESC");
		$pager = new Pager(@$_GET['page'], 100, $total_num_orders);
		$orders = DBObject::glob('Order', "SELECT * FROM shine_orders WHERE app_id = $app_id $search_sql ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
		$where = " AND app_id = $app_id ";
		$app_name = $applications[$app_id]->name;
	}
	else
	{
		$total_num_orders = $db->getValue("SELECT COUNT(*) FROM shine_orders WHERE 1 = 1 $search_sql ");
		$pager = new Pager(@$_GET['page'], 100, $total_num_orders);
		$orders = DBObject::glob('Order', "SELECT * FROM shine_orders WHERE 1 = 1 $search_sql ORDER BY dt DESC LIMIT {$pager->firstRecord}, {$pager->perPage}");
		$where = '';
		$app_name = 'All';
	}

	$available_apps = $db->getValues("SELECT app_id FROM shine_orders GROUP BY app_id");

	// Orders Per Month
	$order_totals    = $db->getRows("SELECT DATE_FORMAT(dt, '%b') as dtstr, COUNT(*) FROM shine_orders WHERE type = 'PayPal' $where GROUP BY CONCAT(YEAR(dt), '-', MONTH(dt)) ORDER BY YEAR(dt) ASC, MONTH(dt) ASC");
	$opm             = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'bary');
	$opm->showGrid   = 1;
	$opm->dimensions = '280x100';
	$opm->setLabelsMinMax(4,'left');
	$opm_fb = clone $opm;
	$opm_fb->dimensions = '640x400';

	// Orders Per Week
	$order_totals    = $db->getRows("SELECT WEEK(dt) as dtstr, COUNT(*) FROM shine_orders WHERE type = 'PayPal' $where GROUP BY CONCAT(YEAR(dt), WEEK(dt)) ORDER BY YEAR(dt) ASC, WEEK(dt) ASC");
	$opw             = new googleChart(implode(',', gimme($order_totals, 'COUNT(*)')), 'bary');
	$opw->showGrid   = 1;
	$opw->dimensions = '280x100';
	$opw->setLabelsMinMax(4,'left');
	$opw_fb = clone $opw;
	$opw_fb->dimensions = '640x400';

	// Orders Per Month Per Application
	$data = array();
	foreach($applications as $app)
		$data[$app->name] = $app->ordersPerMonth();
	$opma = new googleChart();
	$opma->smartDataLabel($data);
	$opma->showGrid   = 1;
	$opma->dimensions = '280x100';
	$opma->setLabelsMinMax(4,'left');
	$opma_fb = clone $opma;
	$opma_fb->dimensions = '640x400';
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">


                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Orders</h2>
							<ul>
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="orders.php">All Orders</a></li>
								<?PHP foreach($applications as $a) : if(!in_array($a->id, $available_apps)) continue; ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="orders.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
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
							<div class="clear"></div>

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
										<td><?PHP echo $o->first_name; ?> <?PHP echo $o->last_name; ?></td>
										<td><a href="mailto:<?PHP echo utf8_encode($o->payer_email); ?>"><?PHP echo utf8_encode($o->payer_email); ?></a></td>
										<td><?PHP echo $o->type; ?></td>
										<td><?PHP echo dater($o->dt, 'm/d/Y g:ia') ?></td>
										<td><?PHP echo $o->intlAmount(); ?></td>
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
							<div class="clear"></div>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				<div class="block">
					<div class="hd">
						Search Orders
					</div>
					<div class="bd">
						<form action="orders.php?id=<?PHP echo @$app_id; ?>" method="get">
							<p><input type="text" name="q" value="<?PHP echo @$q; ?>" id="q" class="text">
							<span class="info">Searches Buyer's Name and Email address.</span></p>
							<p><input type="submit" name="btnSearch" value="Search" id="btnSearch"> | <a href="order-new.php">Create Manual Order</a></p>
						</form>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Orders Per Month (<?PHP echo $app_name; ?>)</h2>
					</div>
					<div class="bd">
						<a href="<?PHP echo $opm_fb->draw(false); ?>" class="fb"><?PHP $opm->draw(); ?></a>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Orders Per Week (<?PHP echo $app_name; ?>)</h2>
					</div>
					<div class="bd">
						<a href="<?PHP echo $opw_fb->draw(false); ?>" class="fb"><?PHP $opw->draw(); ?></a>
					</div>
				</div>

				<div class="block">
					<div class="hd">
						<h2>Orders Per Month (All)</h2>
					</div>
					<div class="bd">
						<a href="<?PHP echo $opma_fb->draw(false); ?>" class="fb"><?PHP $opma->draw(); ?></a>
					</div>
				</div>
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

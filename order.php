<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'orders';

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
<?PHP include('inc/header.inc.php'); ?>

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
							<li><a href="order.php?id=<?PHP echo $o->id; ?>&amp;act=email" id="email">Email to User</a></li>
							<li><a href="<?PHP echo $o->getDownloadLink(); ?>">Download Link (does not expire)</a></li>
							<li><a href="<?PHP echo $o->getDownloadLink(86400); ?>">Download Link (1 day)</a></li>
							<li><a href="<?PHP echo $o->getDownloadLink(86400 * 3); ?>">Download Link (3 days)</a></li>
							<li><a href="<?PHP echo $o->getDownloadLink(86400 * 7); ?>">Download Link (1 week)</a></li>
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

<?PHP include('inc/footer.inc.php'); ?>

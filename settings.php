<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	if(isset($_POST['btnPayPal']))
	{
		set_option('paypal_url', $_POST['ipn_url']);
		redirect('settings.php');
	}
	
	$ipn_url = get_option('paypal_url', DEFAULT_IPN_URL)
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<div class="block">
						<div class="hd">
							<h3>PayPal</h3>
						</div>
						<div class="bd">
							<form action="settings.php" method="post">
								<p>
									<label for="ipn_url">IPN URL</label> <input type="text" name="ipn_url" id="ipn_url" value="<?PHP echo $ipn_url;?>" class="text">
									<span class="info">This is where PayPal will post back to when it receives an <a href="https://www.paypal.com/ipn">instant payment notification</a>.
										<br>Default is: <a href="<?PHP echo DEFAULT_IPN_URL; ?>"><?PHP echo DEFAULT_IPN_URL; ?></a>
										<br>Testing is: <a href="<?PHP echo SANDBOX_IPN_URL; ?>"><?PHP echo SANDBOX_IPN_URL; ?></a></span>
								</p>
								<p><input type="submit" name="btnPayPal" value="Save PayPal Settings" id="btnPayPal"></p>
							</form>
						</div>
					</div>
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

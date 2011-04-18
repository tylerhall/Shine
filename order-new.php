<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'orders';

	if(isset($_POST['btnCreateOrder']))
	{
		$Error->blank($_POST['app_id'], 'Application');
		$Error->blank($_POST['first_name'], 'First Name');
		$Error->blank($_POST['last_name'], 'Last Name');
		$Error->email($_POST['email']);
		
		if($Error->ok())
		{
		    $app = new Application($_POST['app_id']);
		    
			$o = new Order();
			$o->first_name  = $_POST['first_name'];
			$o->last_name   = $_POST['last_name'];
			$o->payer_email = $_POST['email'];
			$o->app_id      = $_POST['app_id'];
			$o->notes       = $_POST['notes'];
			$o->type        = 'Manual';
			$o->dt          = dater();
			$o->item_name   = $app->name;
			$o->insert();

			$o->generateLicense();

			redirect('order.php?id=' . $o->id);
		}
		else
		{
			$first_name = $_POST['first_name'];
			$last_name  = $_POST['last_name'];
			$email      = $_POST['email'];
			$notes      = $_POST['notes'];
		}
	}
	else
	{
		$first_name = '';
		$last_name  = '';
		$email      = '';
		$notes      = '';
	}
	
	$applications = DBObject::glob('Application', 'SELECT * FROM shine_applications ORDER BY name');
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<?PHP echo $Error; ?>
                    <div class="block">
                        <div class="hd">
                            <h2>Create Manual Order</h2>
                        </div>
                        <div class="bd">
							<form action="order-new.php" method="post">
								<p><label for="app_id">Application</label> <select name="app_id" id="app_id"><?PHP foreach($applications as $a) : ?><option value="<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></option><?PHP endforeach; ?></select></p>
								<p><label for="first_name">First Name</label> <input type="text" name="first_name" id="first_name" value="<?PHP echo $first_name; ?>" class="text"></p>
								<p><label for="last_name">Last Name</label> <input type="text" name="last_name" id="last_name" value="<?PHP echo $last_name; ?>" class="text"></p>
								<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?PHP echo $email; ?>" class="text"></p>
								<p><p><label for="notes">Notes</label> <textarea name="notes" id="notes" class="text"><?PHP echo $notes; ?></textarea></p>
								<p><input type="submit" name="btnCreateOrder" value="Create Order" id="btnCreateOrder"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

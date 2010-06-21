<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	if(isset($_POST['btnCreateAccount']))
	{
		$Error->blank($_POST['username'], 'Username');
		$Error->blank($_POST['password'], 'Password');
		$Error->blank($_POST['level'], 'Level');
        $Error->email($_POST['email']);
		
		if($Error->ok())
		{
			$u = new User();
			$u->username   = $_POST['username'];
			$u->email      = $_POST['email'];
			$u->level      = $_POST['level'];
			$u->setPassword($_POST['password']);
			$u->insert();

            redirect('users.php');
		}
		else
		{
			$username = $_POST['username'];
			$email    = $_POST['email'];
			$level    = $_POST['level'];
		}
	}
	else
	{
		$username  = '';
		$email     = '';
		$level     = 'user';
	}
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<?PHP echo $Error; ?>
                    <div class="block">
                        <div class="hd">
                            <h2>Create new user</h2>
                        </div>
                        <div class="bd">
							<form action="user-new.php" method="post">
								<p><label for="username">Username</label> <input type="text" name="username" id="username" value="<?PHP echo $username; ?>" class="text"></p>
								<p><label for="password">Password</label> <input type="password" name="password" id="password" value="" class="text"></p>
								<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?PHP echo $email; ?>" class="text"></p>
								<p><label for="level">Level</label>
								    <select name="level" id="level">
                                        <option <?PHP if($level == 'user') echo 'selected="selected"'; ?> value="user">User</option>
                                        <option <?PHP if($level == 'admin') echo 'selected="selected"'; ?> value="admin">Admin</option>
                                    </select>
                                </p>
								<p><input type="submit" name="btnCreateAccount" value="Create Account" id="btnCreateAccount"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

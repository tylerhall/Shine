<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

    $u = new User($_GET['id']);
    if(!$u->ok()) redirect('users.php');

    if(isset($_GET['action']) && $_GET['action'] == 'delete')
    {
        $u->delete();
        redirect('users.php');
    }

	if(isset($_POST['btnEditAccount']))
	{
		$Error->blank($_POST['username'], 'Username');
		$Error->blank($_POST['level'], 'Level');
        $Error->email($_POST['email']);
		
		if($Error->ok())
		{
			$u->username   = $_POST['username'];
			$u->email      = $_POST['email'];
			$u->level      = $_POST['level'];

            // Leave the password alone if it's not set
            if(!empty($_POST['password']))
                $u->setPassword($_POST['password']);

			$u->update();
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
		$username  = $u->username;
		$email     = $u->email;
		$level     = $u->level;
	}
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
					<?PHP echo $Error; ?>
                    <div class="block tabs spaces">
                        <div class="hd">
                           <ul>
                               <li><a href="users.php">Users</a></li>
                               <li><a href="user-new.php">Create new user</a></li>
                               <li class="active"><a href="user-edit.php?id=<?PHP echo $u->id; ?>">Edit User</a></li>
                           </ul>
                           <div class="clear"></div>
                        </div>
                        <div class="bd">
							<form action="user-edit.php?id=<?PHP echo $u->id; ?>" method="post">
								<p><label for="username">Username</label> <input type="text" name="username" id="username" value="<?PHP echo $username; ?>" class="text"></p>
								<p><label for="password">Password</label> <input type="password" name="password" id="password" value="" class="text"><span class="info">Leave the password blank if you do not wish to change it</span></p>
								<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?PHP echo $email; ?>" class="text"></p>
								<p><label for="level">Level</label>
								    <select name="level" id="level">
                                        <option <?PHP if($level == 'user') echo 'selected="selected"'; ?> value="user">User</option>
                                        <option <?PHP if($level == 'admin') echo 'selected="selected"'; ?> value="admin">Admin</option>
                                    </select>
                                </p>
								<p><input type="submit" name="btnEditAccount" value="Save" id="btnEditAccount"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

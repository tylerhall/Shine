<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');

	$u = new User($_GET['id']);
        if(!$u->ok()) redirect('users.php');

        if($_GET['action'] == 'delete')
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
                        if(empty($_POST['password']))
                        {
			    $u->setPassword($_POST['password']);
                        }

			$u->update();

                        redirect('users.php');
		}
		else
		{
			$username  = $_POST['username'];
			$email  = $_POST['email'];
			$level  = $_POST['level'];
		}
	}
	else
	{
		$username  = $u->username;
		$email     = $u->email;
		$level     = $u->level;
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
                    <li><a href="orders.php">Orders</a></li>
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
					<?PHP echo $Error; ?>
                    <div class="block tabs spaces">
                        <div class="hd">
                           <h2>Users</h2>
<ul>
<li class="active"><a href="users.php">Users</a></li>
<li><a href="user-new.php">Create new user</a></li>
</ul>
<div class="clear"></div>
                            <h2>Create new user</h2>
                        </div>
                        <div class="bd">
							<form action="user-edit.php?id=<?PHP echo $u->id; ?>" method="post">
								<p><label for="username">Username</label> <input type="text" name="username" id="username" value="<?PHP echo $username; ?>" class="text"></p>
								<p><label for="password">Password</label> <input type="password" name="password" id="password" value="" class="text">
<span class="info">Leave the password blank if you do not wish to change it</span></p>
								<p><label for="email">Email</label> <input type="text" name="email" id="email" value="<?PHP echo $email; ?>" class="text"></p>
								<p><label for="level">Level</label> <select name="level" id="level">
<option <?PHP if($level == 'user') echo 'selected="selected"'; ?> value="user">User</option>
<option <?PHP if($level == 'admin') echo 'selected="selected"'; ?> value="admin">Admin</option>
</select></p>
								<p><input type="submit" name="btnEditAccount" value="Save" id="btnEditAccount"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

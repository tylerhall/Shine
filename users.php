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

	$users = DBObject::glob('User', "SELECT * FROM users WHERE 1 = 1 $search_sql ORDER BY username");
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
            <?PHP include('inc/header.inc.php'); ?>
        </div>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">


                    <div class="block tabs spaces">
                        <div class="hd">
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
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($users as $u) : ?>
									<tr>
										<td><?PHP echo $u->username; ?></td>
										<td><?PHP echo $u->level; ?></td>
										<td><?PHP echo $u->email; ?></td>
                                        <td>
                                            <a href="user-edit.php?id=<?PHP echo $u->id; ?>">Edit</a>
                                            <a href="user-edit.php?id=<?PHP echo $u->id; ?>&amp;action=delete" onclick="return confirm('Are you sure?');">Delete</a>
                                        </td>
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
</body>
</html>

<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	$f = new Feedback($_GET['id']);
	if(!$f->ok()) redirect('feedback.php');

	if(isset($_POST['btnNew']))
	{
		$f->new = 1;
		$f->update();
		redirect('feedback.php');
	}
	elseif(isset($_POST['btnDelete']))
	{
		$f->delete();
		redirect('feedback.php');
	}
	else
	{
		$f->new = 0;
		$f->update();
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
	<style type="text/css" media="screen">
		th { text-align:right; font-weight:bold; }
	</style>
</head>
<body class="rounded">
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li class="active"><a href="feedback.php">Feedback</a></li>
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
								<li><a href="feedback.php">All Feedback</a></li>
								<li><a href="feedback.php?type=support">Support Questions</a></li>
								<li><a href="feedback.php?type=bug">Bug Reports</a></li>
								<li><a href="feedback.php?type=feature">Feature Requests</a></li>
								<li class="active"><a href="feedback-view.php?id=<?PHP echo $f->id; ?>">Ticket #<?PHP echo $f->id; ?></a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">

							<table>
								<tr>
									<th class="r">App Name</th>
									<td><?PHP echo $f->appname . ' ' . $f->appversion;?></td>
								</tr>
								<tr>
									<th class="r">System</th>
									<td><?PHP echo $f->systemversion;?></td>
								</tr>
								<tr>
									<th class="r">Email</th>
									<td>
										<a href="mailto:<?PHP echo $f->email;?>"><?PHP echo $f->email;?></a>
										<?PHP echo ($f->reply == 1) ? "(Wants a reply)" : "(Does not want a reply)"; ?>
									</td>
								</tr>
								<tr>
									<th class="r">Type</th>
									<td><?PHP echo ucwords($f->type);?></td>
								</tr>
								<tr>
									<th class="r">Message</th>
									<td><?PHP echo nl2br($f->__message);?></td>
								</tr>
								<?PHP if($f->type == "feature") : ?>
								<tr>
									<th class="r">Importance</th>
									<td><?PHP echo $f->importance;?></td>
								</tr>
								<?PHP endif; ?>
								<?PHP if($f->type == "bug") : ?>
								<tr>
									<th class="r">Critical</th>
									<td><?PHP echo ($f->critical == 0) ? "No" : "Yes!"; ?></td>
								</tr>
								<?PHP endif; ?>
								<tr>
									<th class="r">Date Submitted</th>
									<td><?PHP echo dater('n/j/Y g:ia', $f->dt); ?></td>
								</tr>
								<tr>
									<th class="r">IP</th>
									<td><?PHP echo $f->ip;?></td>
								</tr>
								<tr>
									<th class="r">Registration</th>
									<td><?PHP echo $f->reguser;?> - <?PHP echo $f->regmail;?></td>
								</tr>
							</table>

							<form action="feedback-view.php?id=<?PHP echo $f->id;?>" method="post">
								<p>
									<input type="submit" name="btnNew" value="Mark as New" id="btnnew"/>
									<input type="submit" name="btnDelete" value="Delete" id="btndelete"/>
								</p>
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

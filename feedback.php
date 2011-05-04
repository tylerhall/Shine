<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'feedback';

	if(isset($_GET['type']))
	{
		$db = Database::getDatabase();
		$type = mysql_real_escape_string($_GET['type'], $db->db);
		$feedback = DBObject::glob('Feedback', "SELECT * FROM shine_feedback WHERE type = '$type' ORDER BY dt DESC");
	}
	else
	{
		$feedback = DBObject::glob('Feedback', "SELECT * FROM shine_feedback ORDER BY dt DESC");
	}
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">
                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Feedback</h2>
							<ul>
								<li <?PHP if(@$_GET['type']==''){?> class="active"<? } ?>><a href="feedback.php">All Feedback</a></li>
								<li <?PHP if(@$_GET['type']=='support'){?> class="active"<? } ?>><a href="feedback.php?type=support">Support Questions</a></li>
								<li <?PHP if(@$_GET['type']=='bug'){?> class="active"<? } ?>><a href="feedback.php?type=bug">Bug Reports</a></li>
								<li <?PHP if(@$_GET['type']=='feature'){?> class="active"<? } ?>><a href="feedback.php?type=feature">Feature Requests</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
                            <table class="lines">
                                <thead>
                                    <tr>
										<td>ID</td>
										<td>Application</td>
										<td>Type</td>
										<td>Email</td>
										<td>Wants Reply?</td>
										<td>Date</td>
										<td>&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($feedback as $f) : ?>
									<tr class="<?PHP if($f->new == 1) echo "new"; ?>">
										<td><?PHP echo $f->id; ?></td>
										<td><?PHP echo $f->appname; ?> <?PHP echo $f->appversion; ?></td>
										<td><?PHP echo $f->type; ?></td>
										<td><a href="mailto:<?PHP echo $f->email; ?>"><?PHP echo $f->email; ?></a></td>
										<td><?PHP echo ($f->reply == 1) ? '<strong>Yes</strong>' : 'No'; ?></td>
										<td><?PHP echo time2str($f->dt); ?></td>
										<td><a href="feedback-view.php?id=<?PHP echo $f->id; ?>">View</a></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
					<p>Use <a href="http://github.com/tylerhall/OpenFeedback/">OpenFeedback</a> to collect feedback from your users.</p>
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

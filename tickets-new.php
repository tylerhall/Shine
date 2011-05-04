<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin();
    $db = Database::getDatabase();
	$Nav = 'tickets';

	$app = new Application($_GET['app_id']);
	if(!$app->ok()) redirect('/tickets/');

	if(isset($_POST['btnNew']))
	{
		if($Error->ok())
		{
			$t = new Ticket();
			$t->app_id        = $app->id;
			$t->title         = trim($_POST['title']);
			$t->description   = $_POST['description'];
			$t->created_by    = $Auth->id;
			$t->assigned_to   = $_POST['assigned_to'];
			$t->milestone_id  = $_POST['milestone_id'];
			$t->status        = $_POST['status'];
			$t->dt_created    = dater();
			$t->dt_last_state = dater();
			
			if(strlen($t->title) == 0)
				$t->title = 'Untitled Ticket';
			
			$t->insert();
			redirect('/tickets/app/' . $app->id . '/list/');
		}
		else
		{
			
		}
	}
	else
	{
		$title        = '';
		$description  = '';
		$assigned_to  = '';
		$milestone_id = '';
		$tags         = '';
	}
	
	$fakeTicket = new Ticket();
	$fakeTicket->app_id = $app->id;
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2><?PHP echo $a->name; ?> Ticket Summary</h2>
							<ul>
								<li><a href="/tickets/app/<?PHP echo $app->id; ?>/"><?PHP echo $app->name; ?> Summary</a></li>
								<li class="active"><a href="/tickets/app/<?PHP echo $app->id; ?>/list/">Tickets</a></li>
								<li><a href="/milestones/app/?app_id=<?PHP echo $app->id; ?>/">Milestones</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<form action="/tickets/app/<?PHP echo $app->id;?>/new/" method="post">
								<p><label for="title">Title</label> <input type="text" name="title" id="title" value="<?PHP echo $title;?>" class="text"></p>
								<p><label for="description">Description</label><br><textarea name="description" id="description" class="text"><?PHP echo $description ?></textarea><span class="info">Markdown is allowed</span></p>
								<p><label for="tags">Tags</label> <input type="text" name="tags" id="tags" value="<?PHP echo $tags;?>" class="text"></p>
								<table class="nohover">
									<tr>
										<td>
											<p><label for="assigned_to">Assign To</label><br><select name="assigned_to" id="assigned_to">
												<option value="-1">-- None --</option>
												<?PHP echo ddAssignedTo(); ?>
											</select></p>
										</td>
										<td>
											<p><label for="milestone_id">Milestone</label><br><select name="milestone_id" id="milestone_id">
												<option value="-1">-- None --</option>
												<?PHP echo ddMilestone($fakeTicket); ?>
											</select></p>
										</td>
										<td>
											<p><label for="status">Ticket Status</label><br><select name="status" id="status">
												<option value="new">New</option>
												<option value="open">Open</option>
												<option value="resolved">Resolved</option>
												<option value="hold">On Hold</option>
												<option value="invalid">Invalid</option>
											</select></p>
										</td>
									</tr>
								</table>
								<p><input type="submit" name="btnNew" value="Create Ticket" id="btnNew"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				<div class="block">
					<div class="hd"><h3>Create a New Item</h3></div>
					<div class="bd">
						<p class="text-center"><a href="/tickets/app/<?PHP echo $app->id; ?>/new/" class="big-button">New Ticket</a></p>
						<p class="text-center"><a href="/milestones/app/<?PHP echo $app->id; ?>/new/" class="big-button">New Milestone</a></p>
					</div>
				</div>
            </div>
        </div>
		<script type="text/javascript" charset="utf-8">
			window.onload = function() {
				document.getElementById('title').focus();
			}
		</script>
<?PHP include('inc/footer.inc.php'); ?>

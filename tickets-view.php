<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin();
    $db = Database::getDatabase();
	$Nav = 'tickets';
	
	$ticket = new Ticket($_GET['id']);
	if(!$ticket->ok()) redirect('/tickets/');
	$app = new Application($ticket->app_id);
	$user = new User($ticket->created_by);
	$milestone = new Milestone($ticket->milestone_id);
	
	if(isset($_POST['btnUpdate']))
	{
		$th = new TicketHistory();
		$th->dt                = dater();
		$th->ticket_id         = $ticket->id;
		$th->app_id            = $ticket->app_id;
		$th->user_id           = $Auth->id;
		$th->user_from         = $ticket->assigned_to;
		$th->user_to           = $_POST['assigned_to'];
		$th->status_from       = $ticket->status;
		$th->status_to         = $_POST['status'];
		$th->milestone_from_id = $ticket->milestone_id;
		$th->milestone_to_id   = $_POST['milestone_id'];
		$th->comment           = trim($_POST['comment']);

		$changed = false;
		if($th->user_from != $th->user_to) $changed = true;
		if($th->status_from != $th->status_to) $changed = true;
		if($th->milestone_from_id != $th->milestone_to_id) $changed = true;
		if(strlen($th->comment) > 0) $changed = true;
		
		if($changed)
		{
			$ticket->assigned_to = $th->user_to;
			$ticket->milestone_id = $th->milestone_to_id;
			$ticket->status = $th->status_to;
			$ticket->dt_last_state = dater();
			
			$th->insert();
			$ticket->update();
			redirect('/ticket/' . $ticket->id . '/');
		}
	}
	else
	{
		$tags = '';
	}
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2><?PHP echo $app->name; ?> Ticket Summary</h2>
							<ul>
								<li><a href="/tickets/app/<?PHP echo $app->id; ?>/"><?PHP echo $app->name; ?> Summary</a></li>
								<li class="active"><a href="/tickets/app/<?PHP echo $app->id; ?>/list/">Tickets</a></li>
								<li><a href="/milestones/app/<?PHP echo $app->id; ?>/">Milestones</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<div class="ticket">
								<img src="<?PHP echo $user->avatar(); ?>">
								<p class="float-box">#<?PHP echo $ticket->id; ?><br><span><?PHP echo $ticket->status; ?></span></p>
								<h3><?PHP echo $ticket->title; ?></h3>
								<p class="meta">Created by <?PHP echo $user->username; ?> | <?PHP echo dater($ticket->dt_created, 'F j, Y \a\t g:ia'); ?>
									<?PHP if($milestone->ok()) : ?>
									 | in <a href="tickets-milestone.php?mid=<?PHP echo $milestone->id; ?>"><?PHP echo $milestone->title; ?></a>
									<?PHP endif; ?>
								</p>
								<div class="markdown">
									<?PHP echo premarkdown($ticket->description); ?>
								</div>
							</div>
							<div class="comments">
								<?PHP foreach($ticket->histories() as $th) : $thu = new User($th->user_id); ?>
								<div class="comment">
									<img src="<?PHP echo $thu->avatar(); ?>">
									<p class="meta"><?PHP echo $thu->username; ?> | <?PHP echo dater($th->dt, 'F j, Y \a\t g:ia'); ?></p>
									<?PHP foreach($th->changes() as $c) : ?>
									<p class="changes"><?PHP echo $c; ?></p>
									<?PHP endforeach; ?>
									<div class="markdown">
										<?PHP echo premarkdown($th->comment); ?>
									</div>
								</div>
								<?PHP endforeach; ?>
							</div>
								
							<form action="/ticket/<?PHP echo $ticket->id; ?>/" method="post">
								<p><label for="comment">Add a comment</label><textarea name="comment" id="comment" class="text"></textarea><span class="info">Markdown is allowed</span></p>
								<p><label for="tags">Tags</label> <input type="text" name="tags" id="tags" value="<?PHP echo $tags;?>" class="text"></p>
								<table class="nohover">
									<tr>
										<td>
											<p><label for="assigned_to">Assign To</label><br><select name="assigned_to" id="assigned_to">
												<option value="-1">-- None --</option>
												<?PHP echo ddAssignedTo($ticket); ?>
											</select></p>
										</td>
										<td>
											<p><label for="milestone_id">Milestone</label><br><select name="milestone_id" id="milestone_id">
												<option value="-1">-- None --</option>
												<?PHP echo ddMilestone($ticket); ?>
											</select></p>
										</td>
										<td>
											<p><label for="status">Ticket Status</label><br><select name="status" id="status">
												<option <?PHP if($ticket->status == "new") echo 'selected="selected"'; ?> value="new">New</option>
												<option <?PHP if($ticket->status == "open") echo 'selected="selected"'; ?> value="open">Open</option>
												<option <?PHP if($ticket->status == "resolved") echo 'selected="selected"'; ?> value="resolved">Resolved</option>
												<option <?PHP if($ticket->status == "hold") echo 'selected="selected"'; ?> value="hold">On Hold</option>
												<option <?PHP if($ticket->status == "invalid") echo 'selected="selected"'; ?> value="invalid">Invalid</option>
											</select></p>
										</td>
									</tr>
								</table>
								<p><input type="submit" name="btnUpdate" value="Update Ticket" id="btnUpdate"></p>
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

<?PHP include('inc/footer.inc.php'); ?>

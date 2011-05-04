<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'tickets';

	$app = new Application($_GET['app_id']);
	if(!$app->ok()) redirect('/tickets/');

	$users = DBObject::glob('user', 'SELECT * FROM shine_users');
	$users[0] = new User();
	
	$milestones = DBObject::glob('milestone', "SELECT * FROM shine_milestones WHERE app_id = '{$app->id}'");
	$milestones[0] = new Milestone();
	
	$tickets = DBObject::glob('ticket', "SELECT * FROM shine_tickets WHERE app_id = '{$app->id}' ORDER BY dt_created DESC");
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
								<li><a href="/milestones/app/<?PHP echo $app->id; ?>/">Milestones</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<table class="tickets">
                                <thead>
                                    <tr>
                                        <td>#</td>
										<td>Status</td>
										<td>Title</td>
										<td>Milestone</td>
										<td>Assigned To</td>
										<td>Reported</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($tickets as $t): ?>
									<tr class="ticket-<?PHP echo $t->status; ?>">
										<td class="id"><?PHP echo $t->id; ?></td>
										<td class="status"><a href="/tickets/app/<?PHP echo $app->id; ?>/list/?status=<?PHP echo $t->status; ?>"><?PHP echo ucwords($t->status); ?></a></td>
										<td class="title"><a href="/ticket/<?PHP echo $t->id; ?>/"><?PHP echo $t->title; ?></a></td>
										<td class="milestone"><a href="tickets-milestone.php?id=<?PHP echo $t->milestone_id; ?>"><?PHP echo $milestones[$t->milestone_id]->title; ?></a></td>
										<td class="assigned-to"><a href="tickets-user.php?id=<?PHP echo $t->assigned_to; ?>"><?PHP echo $users[$t->assigned_to]->username; ?></a></td>
										<td class="age"><?PHP echo time2str($t->dt_created); ?></td>
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
					<div class="hd"><h3>Create a New Item</h3></div>
					<div class="bd">
						<p class="text-center"><a href="/tickets/app/<?PHP echo $app->id; ?>/new/" class="big-button">New Ticket</a></p>
						<p class="text-center"><a href="/milestones/app/<?PHP echo $app->id; ?>/new/" class="big-button">New Milestone</a></p>
					</div>
				</div>
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

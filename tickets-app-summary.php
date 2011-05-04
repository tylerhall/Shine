<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'tickets';

	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('tickets.php');
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2><?PHP echo $a->name; ?> Ticket Summary</h2>
							<ul>
								<li class="active"><a href="tickets-app-summary.php?id=<?PHP echo $app->id; ?>"><?PHP echo $app->name; ?> Summary</a></li>
								<li><a href="tickets-tickets.php?app_id=<?PHP echo $app->id; ?>">Tickets</a></li>
								<li><a href="tickets-milestones.php?app_id=<?PHP echo $app->id; ?>">Milestones</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
				<div class="block">
					<div class="hd"><h3>Create a New Item</h3></div>
					<div class="bd">
						<p class="text-center"><a href="tickets-new.php?app_id=<?PHP echo $app->id; ?>" class="big-button">New Ticket</a></p>
						<p class="text-center"><a href="tickets-milestone-new.php?app_id=<?PHP echo $app->id; ?>" class="big-button">New Milestone</a></p>
					</div>
				</div>
            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

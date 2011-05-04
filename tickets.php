<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'tickets';

	// Get a list of our apps
	$apps   = DBObject::glob('Application', 'SELECT * FROM shine_applications WHERE hidden = 0 ORDER BY name');	
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block">
                        <div class="hd">
                            <h2>Your Applications</h2>
                        </div>
                        <div class="bd">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>New Tickets</td>
                                        <td>Open Tickets</td>
										<td>Next Milestone</td>
										<td>Progress</td>
                                    </tr>
                                </thead>
                                <tbody>
									<?PHP foreach($apps as $a) : ?>
									<tr>
	                                    <td><a href="tickets-app-summary.php?id=<?PHP echo $a->id;?>"><?PHP echo $a->name; ?></a></td>
										<td><?PHP echo $a->numNewTickets(); ?></td>
										<td><?PHP echo $a->numOpenTickets(); ?></td>
										<td><?PHP echo $a->strNextMilestone(); ?></td>
										<td></td>
									</tr>
									<?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
					
					<div class="block">
    					<div class="hd">
    						<h2>Recent Activity</h2>
    					</div>
    					<div class="bd">
    					    <table>
    					        <tbody>

    					        </tbody>
    					    </table>
    					</div>
    				</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'applications';
	
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');
	$versions = $app->versions();
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Applications</h2>
							<ul>
								<li><a href="application.php?id=<?PHP echo $app->id; ?>"><?PHP echo $app->name; ?></a></li>
								<li class="active"><a href="versions.php?id=<?PHP echo $app->id; ?>">Versions</a></li>
								<li><a href="version-new.php?id=<?PHP echo $app->id; ?>">Release New Version</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<table>
								<thead>
									<tr>
										<th>Human Readable Version</th>
										<th>Sparkle Version Number</th>
										<th>Release Date</th>
										<th>Downloads</th>
										<th>Updates</th>
									</tr>
								</thead>
								<tbody>
									<?PHP foreach($versions as $v) : ?>
									<tr>
										<td><a href="version-edit.php?id=<?PHP echo $v->id; ?>"><?PHP echo $v->human_version; ?></a></td>
										<td><?PHP echo $v->version_number; ?></td>
										<td><?PHP echo dater($v->dt, 'n/d/Y g:ia'); ?></td>
										<td><?PHP echo number_format($v->downloads); ?></td>
										<td><?PHP echo number_format($v->updates); ?></td>
									</tr>
									<?PHP endforeach; ?>
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

<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'applications';
	
	$v = new Version($_GET['id']);
	if(!$v->ok()) redirect('index.php');
	
	$app = new Application($v->app_id);
	if(!$app->ok()) redirect('index.php');
	
	if(isset($_POST['btnDelete']))
	{
		$v->delete();
		redirect('versions.php?id=' . $app->id);
	}

	$version_number = $v->version_number;
	$human_version  = $v->human_version;
	$release_notes  = $v->release_notes;
	$url            = $v->url;
	$signature      = $v->signature;
	$filesize       = $v->filesize;	
?>
<?PHP include('inc/header.inc.php'); ?>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">

                    <div class="block tabs spaces">
						<?PHP echo $Error; ?>
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
							<form action="version-edit.php?id=<?PHP echo $v->id; ?>" method="post">
								<p><label for="version_number">Version Number</label> <input type="text" name="version_number" id="version_number" value="<?PHP echo $version_number;?>" class="text"></p>
								<p><label for="human_version">Human Readable Version Number</label> <input type="text" name="human_version" id="human_version" value="<?PHP echo $human_version;?>" class="text"></p>
								<p><label for="url">Download URL</label> <input type="text" name="url" id="url" value="<?PHP echo $url;?>" class="text"></p>
								<p><label for="release_notes">Release Notes</label> <textarea class="text" name="release_notes" id="release_notes"><?PHP echo $release_notes; ?></textarea></p>
								<p><label for="filesize">Filesize</label> <input type="text" name="filesize" id="filesize" value="<?PHP echo $filesize; ?>" class="text"></p>
								<p><label for="signature">Sparkle Signature</label> <input type="text" name="signature" id="signature" value="<?PHP echo $signature; ?>" class="text"></p>
								<p><input type="submit" name="btnDelete" value="Delete Version" id="btnDelete" onclick="return confirm('Are you sure?');"></p>
							</form>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">

            </div>
        </div>

<?PHP include('inc/footer.inc.php'); ?>

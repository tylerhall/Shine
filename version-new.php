<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	
	$app = new Application($_GET['id']);
	if(!$app->ok()) redirect('index.php');

	if(isset($_POST['btnCreateVersion']))
	{
		$Error->blank($_POST['version_number'], 'Version Number');
		$Error->blank($_POST['human_version'], 'Human Readable Version Number');
		$Error->upload($_FILES['file'], 'file');
		
		if($Error->ok())
		{
			$v = new Version();
			$v->app_id         = $app->id;
			$v->version_number = $_POST['version_number'];
			$v->human_version  = $_POST['human_version'];
			$v->release_notes  = $_POST['release_notes'];
			$v->dt             = dater();
			$v->downloads      = 0;
			$v->filesize       = filesize($_FILES['file']['tmp_name']);
			$v->signature      = sign_file($_FILES['file']['tmp_name'], $app->sparkle_pkey);
			
			$object = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $app->name)) . "_" . $v->version_number . "." . substr($_FILES['file']['name'], -3);
			$v->url = slash($app->s3path) . $object;
			$info   = parse_url($app->s3path);
			$object = slash($info['path']) . $object;
			chmod($_FILES['file']['tmp_name'], 0755);
			$s3 = new S3($app->s3key, $app->s3pkey);
			$s3->putObject($app->s3bucket, $object, $_FILES['file']['tmp_name'], true);
			$v->insert();

			redirect('versions.php?id=' . $app->id);
		}
		else
		{
			$version_number = $_POST['version_number'];
			$human_version  = $_POST['human_version'];
			$release_notes  = $_POST['release_notes'];
		}
	}
	else
	{
		$version_number = '';
		$human_version  = '';
		$release_notes  = '';
	}
	
	function sign_file($filename, $keydata)
    {
		$binary = shell_exec('openssl dgst -sha1 -binary < ' . $filename);
		$stdin = tempnam('/tmp', 'foo');
		file_put_contents($stdin, $binary);

		$keyin = tempnam('/tmp', 'bar');
		file_put_contents($keyin, "-----BEGIN DSA PRIVATE KEY-----\n" . $keydata . "\n-----END DSA PRIVATE KEY-----\n");

		$signed = shell_exec("openssl dgst -dss1 -sign $keyin < $stdin");

		return base64_encode($signed);		
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
</head>
<body class="rounded">
    <div id="doc3" class="yui-t0">

        <div id="hd">
            <h1>Shine</h1>
            <div id="navigation">
                <ul id="primary-navigation">
                    <li class="active"><a href="index.php">Applications</a></li>
                    <li><a href="orders.php">Orders</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="stats.php">Sparkle Stats</a></li>
                </ul>

                <ul id="user-navigation">
                    <li><a href="users.php">Users</a></li>
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
						<?PHP echo $Error; ?>
                        <div class="hd">
                            <h2>Applications</h2>
							<ul>
								<li><a href="application.php?id=<?PHP echo $app->id; ?>"><?PHP echo $app->name; ?></a></li>
								<li><a href="versions.php?id=<?PHP echo $app->id; ?>">Versions</a></li>
								<li><a href="pirates.php?id=<?PHP echo $app->id; ?>">Pirates</a></li>
								<li class="active"><a href="version-new.php?id=<?PHP echo $app->id; ?>">Release New Version</a></li>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
							<form action="version-new.php?id=<?PHP echo $app->id; ?>" method="post" enctype="multipart/form-data">
								<p><label for="version_number">Sparkle Version Number</label> <input type="text" name="version_number" id="version_number" value="<?PHP echo $version_number;?>" class="text"></p>
								<p><label for="human_version">Human Readable Version Number</label> <input type="text" name="human_version" id="human_version" value="<?PHP echo $human_version;?>" class="text"></p>
								<p><label for="release_notes">Release Notes</label> <textarea class="text" name="release_notes" id="release_notes"><?PHP echo $release_notes; ?></textarea></p>
								<p><label for="file">Application Archive</label> <input type="file" name="file" id="file"></p>
								<p><input type="submit" name="btnCreateVersion" value="Create Version" id="btnCreateVersion"></p>
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

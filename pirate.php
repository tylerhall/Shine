<?PHP
    // This is just a simple script to help you keep track of how often
    // your app is being pirated.
    //
    // How you detect piracy is up to you, but when you do, have your app
    // ping this script. In my case, if the user enters a serial number I
    // know to be pirated, I simply do...
    //
    // NSString *urlStr = [NSString stringWithFormat:@"http://shine.your-domain.com/pirate.php?app_id=1&guid=%@", @"some unique identifier"];
    // NSURL *url = [NSURL URLWithString:urlStr];
    // NSURLRequest *request = [NSURLRequest requestWithURL:url];
    // [NSURLConnection sendSynchronousRequest:request returningResponse:nil error:nil];
    //
    // It's not particularly elegent, but it gets the job done.

	require 'includes/master.inc.php';

    $app_id = $_GET['app_id'];
    $ip     = $_SERVER['REMOTE_ADDR'];
    $guid   = $_GET['guid'];
    $dt     = dater();
    
    $db = Database::getDatabase();

    $app_id = mysql_real_escape_string($app_id, $db->db);
    $guid = mysql_real_escape_string($guid, $db->db);

    $db->query("INSERT INTO pirates (`app_id`, `ip`, `guid`, `dt`) VALUES ('$app_id', '$ip', '$guid', '$dt')");

	$v = DBObject::glob('Version', "SELECT * FROM versions WHERE app_id = $app_id ORDER BY dt DESC LIMIT 1");
	$v = array_pop($v);
	$v->pirate_count++;
	$v->update();

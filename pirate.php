<?PHP
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

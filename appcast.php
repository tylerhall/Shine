<?PHP
    // This is your basic, run of the mill appcast feed

	require 'includes/master.inc.php';

	$app = new Application($_GET['id']);
	if(!$app->ok()) die('Application not found');
	
	$db = Database::getDatabase();

	// This table format is crap, but it future proofs us against Sparkle format changes
	$ip = $_SERVER['REMOTE_ADDR'];
	$dt = date("Y-m-d H:i:s");
	$db->query("INSERT INTO shine_sparkle_reports (ip, dt) VALUES (:ip, :dt)", array('ip' => $ip, 'dt' => $dt));
	$id = $db->insertId();
	foreach($_GET as $k => $v)
		$db->query("INSERT INTO shine_sparkle_data (sparkle_id, `key`, data) VALUES (:id, :k, :v)", array('id' => $id, 'k' => $k, 'v' => $v));

	$versions = DBObject::glob('Version', "SELECT * FROM shine_versions WHERE app_id = '{$app->id}' ORDER BY dt DESC LIMIT 10");

	$db->query("UPDATE shine_versions SET updates = updates + 1 WHERE app_id = '{$app->id}' ORDER BY dt DESC LIMIT 1");
	
	$pirate = false;
	if(isset($_GET['serialNumber'])) {
		$sn = $db->quote(trim($_GET['serialNumber']));
		$count = $db->getValue("SELECT COUNT(*) FROM shine_orders WHERE license = $sn");
		if($count == 0) {
			$pirate = true;
		}
	}

	header("Content-type: application/xml");
?>
<?PHP echo '<'; ?>?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:sparkle="http://www.andymatuschak.org/xml-namespaces/sparkle"  xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title><?PHP echo $app->name; ?> Changelog</title>
		<link><?PHP echo $app->link; ?></link>
		<description>Most recent changes with links to updates.</description>
		<language>en</language>
		<?PHP foreach($versions as $v) : ?>
		<item>
			<title><?PHP echo $app->name; ?> <?PHP echo $v->human_version; ?></title>
			<description><![CDATA[ <?PHP echo $v->release_notes; ?> ]]></description>
			<pubDate><?PHP echo dater('D, d M Y H:i:s O', $v->dt); ?></pubDate>
			<enclosure url="<?PHP echo $v->url; ?>" sparkle:shortVersionString="<?PHP echo $v->human_version; ?>" sparkle:version="<?PHP echo $v->version_number; ?>" length="<?PHP echo $v->filesize; ?>" type="application/octet-stream" sparkle:dsaSignature="<?PHP echo $v->signature; ?>" />
		</item>
		<?PHP endforeach; ?>
		<?PHP if($pirate === true) : ?>
		<item>
			<title>sparkle</title>
			<description></description>
			<pubDate></pubDate>
			<enclosure url="http://clickontyler.com" sparkle:shortVersionString="1.0" sparkle:version="1.0" length="3000000" type="application/octet-stream" sparkle:dsaSignature="abc123" />
		</item>
		<?PHP endif; ?>
	</channel>
</rss>
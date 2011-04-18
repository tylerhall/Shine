<?PHP
    require 'includes/master.inc.php';

    error_log(print_r($_POST, true));

    $db = Database::getDatabase();

    foreach($_POST as $key => $val)
        $_POST[$key] = mysql_real_escape_string($val, $db->db);

    $dt = date('Y-m-d H:i:s');

    $query = "INSERT INTO shine_feedback (appname, appversion, systemversion, email, reply, `type`, message, importance, critical, dt, ip, `new`, reguser, regmail) VALUES
                  ('{$_POST['appname']}',
                   '{$_POST['appversion']}',
                   '{$_POST['systemversion']}',
                   '{$_POST['email']}',
                   '{$_POST['reply']}',
                   '{$_POST['type']}',
                   '{$_POST['message']}',
                   '{$_POST['importance']}',
                   '{$_POST['critical']}',
                   '$dt',
                   '{$_SERVER['REMOTE_ADDR']}',
                   '1',
                   '{$_POST['reguser']}',
                   '{$_POST['regmail']}')";

    mysql_query($query, $db->db) or die('error');

	$link = 'http://shine.clickontyler.com/feedback-view.php?id=' . $db->insertId();

    $message  = "$link\n\n";
	$message .= "From: {$_POST['email']}\n";
    $message .= "Version: {$_POST['appversion']}\n";
    $message .= "System Version: {$_POST['systemversion']}\n";
    $message .= "Importance: {$_POST['importance']}\n";
    $message .= "Criticality: {$_POST['critical']}\n\n";
    $message .= "Message: " . str_replace("\\n", "\n", $_POST['message']) . "\n\n";

	// Send mail via http://postmarkapp.com
    // Mail_Postmark::compose()
    //     ->addTo('support@clickontyler.com')
    //     ->subject($_POST['appname'] . ' ' . ucwords($_POST['type']))
    //     ->messagePlain($message)
    //     ->send();

    echo "ok";

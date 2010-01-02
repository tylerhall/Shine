<?PHP
    $db = Database::getDatabase();
    $feedback_count = $db->getValue("SELECT COUNT(*) FROM feedback WHERE new = 1");
?>
<h1>Shine</h1>
<div id="navigation">
    <ul id="primary-navigation">
        <li class="active"><a href="index.php">Applications</a></li>
        <li><a href="orders.php">Orders</a></li>
        <?PHP if($feedback_count == 0) : ?>
        <li><a href="feedback.php">Feedback</a></li>
        <?PHP else : ?>
        <li class="highlight"><a href="feedback.php">Feedback</a></li>
        <?PHP endif; ?>
        <li><a href="stats.php">Sparkle Stats</a></li>
    </ul>

    <ul id="user-navigation">
        <li><a href="users.php">Users</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="clear"></div>
</div>

<?PHP
    if(rand(1,30) == 1)
        include 'tweet-cron.php';

    $db = Database::getDatabase();
    $feedback_count = $db->getValue("SELECT COUNT(*) FROM shine_feedback WHERE new = 1");
    $tweet_count = $db->getValue("SELECT COUNT(*) FROM shine_tweets WHERE new = 1");
?>
<h1>Shine</h1>
<div id="navigation">
    <ul id="primary-navigation">
        <li<?PHP if($nav == 'applications') : ?> class="active"<?PHP endif; ?>><a href="index.php">Applications</a></li>
        <li<?PHP if($nav == 'orders') : ?> class="active"<?PHP endif; ?>><a href="orders.php">Orders</a></li>
        <li<?PHP if($nav == 'feedback') : ?> class="active"<?PHP endif; ?>><a href="feedback.php">Feedback (<?PHP echo $feedback_count; ?>)</a></li>
        <li<?PHP if($nav == 'tweets') : ?> class="active"<?PHP endif; ?>><a href="tweets.php">Tweets (<?PHP echo $tweet_count; ?>)</a></li>
        <li<?PHP if($nav == 'stats') : ?> class="active"<?PHP endif; ?>><a href="stats.php">Sparkle Stats</a></li>
    </ul>

    <ul id="user-navigation">
        <li><a href="users.php">Users</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="clear"></div>
</div>

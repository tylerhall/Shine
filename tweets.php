<?PHP
	require 'includes/master.inc.php';
	$Auth->requireAdmin('login.php');
	$nav = 'tweets';

	$applications = DBObject::glob('Application', 'SELECT * FROM applications ORDER BY name');
	
	if(isset($_GET['refresh']))
	    include 'tweet-cron.php';
	
	if(isset($_GET['delete']))
	{
	    $t = new Tweet($_GET['delete']);
	    $t->deleted = 1;
		$t->new = 0;
	    $t->update();
    }
    
    if(isset($_GET['reply']))
    {
        $t = new Tweet($_GET['reply']);
        $t->replied_to = 1;
        $t->reply_date = dater();
        $t->new = 0;
        $t->update();
        redirect("http://twitter.com/home?status=@{$t->username}%20&in_reply_to={$t->tweet_id}");
    }

    $sql = ''; $app_id = '';
    if(isset($_GET['id']))
    {
        $sql = 'AND app_id = ' . intval($_GET['id']);
        $app_id = intval($_GET['id']);
    }
    
    if(isset($_GET['read']))
    {
        $db = Database::getDatabase();
        $db->query("UPDATE tweets SET new = 0 WHERE 1 = 1 $sql");
        redirect("tweets.php?id=$app_id");
    }

	$tweets = DBObject::glob('Tweet', "SELECT * FROM tweets WHERE deleted = 0 $sql ORDER BY dt DESC");
	
	function twitterfy($str)
	{
	    // Via http://www.snipe.net/2009/09/php-twitter-clickable-links/
        $str = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str);
        $str = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str);
        $str = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $str);
        $str = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $str);
        return $str;
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
	<link rel="stylesheet" href="js/jquery.fancybox.css" type="text/css" media="screen">
</head>
<body class="rounded">
    <div id="doc3" class="yui-t6">

        <div id="hd">
            <?PHP include('inc/header.inc.php'); ?>
        </div>

        <div id="bd">
            <div id="yui-main">
                <div class="yui-b"><div class="yui-g">


                    <div class="block tabs spaces">
                        <div class="hd">
                            <h2>Orders</h2>
							<ul>
								<li class="<?PHP if(!isset($_GET['id'])) echo 'active'; ?>"><a href="tweets.php">All Apps</a></li>
								<?PHP foreach($applications as $a) : ?>
								<li class="<?PHP if(@$_GET['id'] == $a->id) echo 'active'; ?>"><a href="tweets.php?id=<?PHP echo $a->id; ?>"><?PHP echo $a->name; ?></a></li>
								<?PHP endforeach; ?>
							</ul>
							<div class="clear"></div>
                        </div>
                        <div class="bd">
                            <table>
                                <tbody>
                                    <?PHP foreach($tweets as $t) : ?>
                                    <?PHP if($t->new) : ?>
                                    <tr class="highlight">
                                    <?PHP else : ?>
                                    <tr>
                                    <?PHP endif; ?>
                                        <td><img src="<?PHP echo $t->profile_img; ?>" style="width:48px;height:48px;"></td>
                                        <td>
                                            <strong><a href="http://twitter.com/<?PHP echo $t->username; ?>"><?PHP echo $t->username; ?></a></strong>
                                            <br>
                                            <a style="font-size:80%;" href="http://twitter.com/<?PHP echo $t->username; ?>/status/<?PHP echo $t->tweet_id; ?>"><?PHP echo time2str($t->dt); ?></a>
                                        </td>
                                        <td>
                                            <?PHP echo twitterfy($t->body); ?><br>
                                            <span style="font-size:80%;">
                                            <?PHP if($t->replied_to) : ?>
                                            Replied to <?PHP echo time2str($t->reply_date); ?>
                                            <?PHP else : ?>
                                            <a href="tweets.php?id=<?PHP echo $app_id; ?>&amp;reply=<?PHP echo $t->id; ?>">Reply</a>
                                            <?PHP endif; ?>
                                            </span>
                                        </td>
                                        <td><a href="tweets.php?id=<?PHP echo $app_id; ?>&amp;delete=<?PHP echo $t->id; ?>">Delete</a></td>
                                    </tr>
                                    <?PHP endforeach; ?>
                                </tbody>
                            </table>
						</div>
					</div>
              
                </div></div>
            </div>
            <div id="sidebar" class="yui-b">
                <div class="block">
                    <div class="hd">
                        <h3>Summary</h3>
                    </div>
                    <div class="bd">
                        <p><?PHP echo count($tweets); ?> tweets</p>
                        <p><a href="tweets.php?id=<?PHP echo $app_id; ?>&amp;read=1">Mark all as read</a></p>
                        <p><a href="tweets.php?id=<?PHP echo $app_id; ?>&amp;refresh=1">Refresh All</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="ft"></div>
    </div>
</body>
</html>

<?PHP
    require_once('includes/master.inc.php');

    $db = Database::getDatabase();
    $tweet_apps = $db->getRows('SELECT id, tweet_terms FROM applications');

    foreach($tweet_apps as $tweet_app)
    {
        $terms = explode(',', $tweet_app['tweet_terms']);
        foreach($terms as $term)
        {
            $term = trim($term);
            if(strlen($term) > 0)
            {
                $json = geturl("http://search.twitter.com/search.json?q=" . urlencode($term));
                $data = json_decode($json);
				if(!is_object($data)) continue;

                foreach($data->results as $result)
                {
                    $t = new Tweet();
                    $t->tweet_id    = $result->id;
                    $t->username    = $result->from_user;
                    $t->app_id      = $tweet_app['id'];
                    $t->dt          = dater($result->created_at);
                    $t->body        = $result->text;
                    $t->profile_img = $result->profile_image_url;
                    $t->new         = 1;
                    $t->replied_to  = 0;
                    $t->insert();
                }
            }
        }
    }

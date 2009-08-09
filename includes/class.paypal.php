<?PHP
	class PayPal
	{
		public function __construct()
		{
			
		}
		
		public function process($post = null)
		{
			error_log(print_r($_POST, true));
			if($_POST['payment_status'] != 'Completed')
				return false;

			$post_vars = is_array($post) ? $post : $_POST;
			$post_vars['cmd'] = '_notify-validate';
			$response = $this->curl(get_option('paypal_url', DEFAULT_IPN_URL), null, http_build_query($post_vars));
			return (strpos($response, 'VERIFIED') !== false) ? $post_vars : false;
		}
		
		private function curl($url, $referer = null, $post = null)
	    {
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	        // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1) Gecko/20061024 BonEcho/2.0");
	        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        // curl_setopt($ch, CURLOPT_VERBOSE, 1);

	        if($referer) curl_setopt($ch, CURLOPT_REFERER, $referer);
	        if(!is_null($post))
	        {
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	        }

	        $html = curl_exec($ch);

	        // $last_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	        return $html;
	    }
	}

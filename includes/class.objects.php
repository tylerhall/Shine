<?PHP
    // Stick your DBOjbect subclasses in here (to help keep things tidy).

    class User extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('users', array('username', 'password', 'level', 'email'), $id);
        }
    }

    class Application extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('applications', array('name', 'link', 'bundle_name', 's3key', 's3pkey', 's3bucket', 's3path', 'sparkle_key', 'sparkle_pkey', 'ap_key', 'ap_pkey', 'from_email', 'email_subject', 'email_body', 'license_filename'), $id);
        }

		public function versions()
		{
			return DBObject::glob('Version', "SELECT * FROM versions WHERE app_id = '{$this->id}' ORDER BY dt DESC");
		}

		public function strCurrentVersion()
		{
			$db = Database::getDatabase();
			return $db->getValue("SELECT version_number FROM versions WHERE app_id = '{$this->id}' ORDER BY dt DESC LIMIT 1");
		}
		
		public function strLastReleaseDate()
		{
			$db = Database::getDatabase();
			$dt = $db->getValue("SELECT dt FROM versions WHERE app_id = '{$this->id}' ORDER BY dt DESC LIMIT 1");
			return dater('m/d/Y', $dt);
		}
		
		public function numSupportQuestions()
		{
			return '0';
		}
		
		public function numBugReports()
		{
			return '0';
		}
		
		public function numFeatureRequests()
		{
			return '0';
		}

		function getBody($order)
		{
			return str_replace(array('{first_name}', '{last_name}'), array($order->first_name, $order->last_name), $this->email_body);
		}
    }

    class Order extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('orders', array('app_id', 'dt', 'txn_type', 'first_name', 'last_name', 'residence_country', 'item_name', 'payment_gross', 'mc_currency', 'business', 'payment_type', 'verify_sign', 'payer_status', 'tax', 'payer_email', 'txn_id', 'quantity', 'receiver_email', 'payer_id', 'receiver_id', 'item_number', 'payment_status', 'payment_fee', 'mc_fee', 'shipping', 'mc_gross', 'custom', 'license', 'type', 'deleted', 'hash', 'claimed'), $id);
        }

		public function applicationName()
		{
			static $cache;
			if(!is_array($cache)) $cache = array();

			if(!isset($cache[$this->app_id]))
			{
				$app = new Application($this->app_id);
				$cache[$this->app_id] = $app->name;
			}
			
			return $cache[$this->app_id];
		}
		
		function generateLicense()
		{
			// Much of the following code is adapted/copied from AquaticPrime's PHP library...

			// Create our license dictionary to be signed
			$dict = array("Product"       => $this->item_name,
						  "Name"          => $this->first_name . ' ' . $this->last_name,
						  "Email"         => $this->payer_email,
						  "Licenses"      => $this->quantity,
						  "Timestamp"     => date('r', strtotime($this->dt)),
						  "TransactionID" => $this->txn_id);

			$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
			$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");

			foreach($dict as $k => $v)
				$dict[$k] = str_replace($search, $replace, $v);

			$app = new Application($this->app_id);
		    $sig = chunk_split(getSignature($dict, $app->ap_key, $app->ap_pkey));

		    $plist = "<?xml version=\"1.0\" encoding=\"UTF-8\"?".">\n";
		    $plist .= "<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">\n";
		    $plist .= "<plist version=\"1.0\">\n<dict>\n";
		    foreach($dict as $key => $value)
			{
		        $plist .= "\t<key>" . htmlspecialchars($key, ENT_NOQUOTES) . "</key>\n";
		        $plist .= "\t<string>" . htmlspecialchars($value, ENT_NOQUOTES) . "</string>\n";
		    }
		    $plist .= "\t<key>Signature</key>\n";
		    $plist .= "\t<data>$sig</data>\n";
		    $plist .= "</dict>\n";
		    $plist .= "</plist>\n";

			$this->license = $plist;
			$this->update();
		}
		
		public function emailLicense()
		{
			$app = new Application($this->app_id);
			send_mail_with_attachment($this->payer_email, $app->from_email, $app->email_subject, $app->getBody($this), $this->license, $app->license_filename);
		}

		public function emailLicenseGmail()
		{
			$app = new Application($this->app_id);
			send_mail_with_attachmentGmail($this->payer_email, $app->from_email, $app->email_subject, $app->getBody($this), $this->license, $app->license_filename);
		}
		
		public function downloadLicense()
		{
			$app = new Application($this->app_id);
			header("Cache-Control: public");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Content-Type: application/octet-stream");
			header("Content-Length: " . strlen($this->license));
			header("Content-Disposition: attachment; filename={$app->license_filename}");
			header("Content-Transfer-Encoding: binary");
			echo $this->license;
			exit;
		}
		
		public static function totalOrders()
		{
			$db = Database::getDatabase();
			return $db->getValue("SELECT COUNT(*) FROM orders WHERE type = 'paypal'");
		}
    }

    class Version extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('versions', array('app_id', 'human_version', 'version_number', 'dt', 'release_notes', 'filesize', 'url', 'downloads', 'signature'), $id);
        }
    }

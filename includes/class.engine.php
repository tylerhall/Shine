<?PHP
	abstract class Engine
	{
		public $order;
		public $application;

		// Should do whatever steps are required to generate a license and store
		// into the database - typically by updating the $order property.
		abstract public function generateLicense();
		
		// Should force a download of the user's license file or do nothing if
		// the license is not downloadable i.e., it's simply a serial number.
		abstract public function downloadLicense();

		public function emailLicense()
		{
			Mail_Postmark::compose()
			    ->addTo($this->order->payer_email)
			    ->subject($this->application->email_subject)
			    ->messagePlain($this->application->getBody($this->order))
			    ->send();
		}

		public function upgradeLicense()
		{
			$upgrade_app = new Application($this->application->upgrade_app_id);
			if($upgrade_app->ok())
			{
				$o = new Order();
				$o->app_id      = $upgrade_app->id;
				$o->dt          = dater();
				$o->first_name  = $this->order->first_name;
				$o->last_name   = $this->order->last_name;
				$o->payer_email = $this->order->payer_email;
				$o->notes       = "Upgrade via Shine";
				$o->type        = 'Upgrade';
				$o->insert();
				$o->generateLicense();
				return $o;
			}
			
			return null;
		}
	}

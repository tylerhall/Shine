<?PHP
	// This is really just a sample implementation of how to write your own
	// Engine file. I wouldn't use a simple md5 has as your app will be cracked
	// immediately.

	class EngineMD5 extends Engine
	{
		public function generateLicense()
		{
			$arr = array('email' => utf8_encode($this->order->payer_email));

			$str = '';
			ksort($arr);
			foreach($arr as $k => $v) $str .= $v;

			$this->order->license = strtoupper(md5($str . $this->application->custom_salt));
			$this->order->update();
		}

		public function downloadLicense()
		{
			// This function does nothing since you can't download this type of license
		}
	}

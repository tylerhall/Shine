<?PHP
	class License
	{
		private $secret = '';
		
		public function __construct()
		{
			
		}
		
		public function generateLiceseForArray($arr)
		{
			ksort($arr);
			$str = '';
			foreach($arr as $k => $v)
				$str .= $k . $v;
			$hash = sha1($str . $this->secret);

			$final_hash = '';
			for($i = 0; $i < strlen($hash); $i++)
			{
				if(ctype_digit($hash[$i]))
					$final_hash .= $hash[$i];
				else
					$final_hash .= ord($hash[$i]);
			}

			return $final_hash;
		}
		
		public function validLicenseForArray($license, $array)
		{
			return ($license === $this->generateLiceseForArray($array));
		}
	}

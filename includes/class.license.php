<?PHP
	class License
	{
		private $secret = '';
		
		public function __construct()
		{
			
		}
		
		public function generateLicenseForArray($arr)
		{
			ksort($arr);
			$str = '';
			foreach($arr as $k => $v)
				$str .= $v;
			return strtoupper(md5($str . $this->secret));
		}
		
		public function validLicenseForArray($license, $array)
		{
			return ($license === $this->generateLicenseForArray($array));
		}
	}

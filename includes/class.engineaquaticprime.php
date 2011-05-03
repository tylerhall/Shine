<?PHP
	class EngineAquaticPrime extends Engine
	{
		public function generateLicense()
		{
			// Much of the following code is adapted/copied from AquaticPrime's PHP library...

			// Create our license dictionary to be signed
			$dict = array("Product"       => $this->order->item_name,
						  "Name"          => utf8_encode($this->order->first_name . ' ' . $this->order->last_name),
						  "Email"         => utf8_encode($this->order->payer_email),
						  "Licenses"      => $this->order->quantity,
						  "Timestamp"     => date('r', strtotime($this->order->dt)),
						  "TransactionID" => $this->order->txn_id);

			// $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
			// $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");

			// foreach($dict as $k => $v)
			// 	$dict[$k] = str_replace($search, $replace, $v);

		    $sig = chunk_split($this->getSignature($dict, $this->application->ap_key, $this->application->ap_pkey));

		    $plist = "<?xml version=\"1.0\" encoding=\"UTF-8\"?".">\n";
		    $plist .= "<!DOCTYPE plist PUBLIC \"-//Apple Computer//DTD PLIST 1.0//EN\" \"http://www.apple.com/DTDs/PropertyList-1.0.dtd\">\n";
		    $plist .= "<plist version=\"1.0\">\n<dict>\n";
		    foreach($dict as $key => $value)
			{
				$value = utf8_encode($value);
		        $plist .= "\t<key>" . htmlspecialchars($key, ENT_NOQUOTES) . "</key>\n";
		        $plist .= "\t<string>" . htmlspecialchars($value, ENT_NOQUOTES) . "</string>\n";
		    }
		    $plist .= "\t<key>Signature</key>\n";
		    $plist .= "\t<data>$sig</data>\n";
		    $plist .= "</dict>\n";
		    $plist .= "</plist>\n";

			$this->order->license = $plist;
			$this->order->update();
		}
		
		public function emailLicense()
		{
			Mail_Postmark::compose()
			    ->addTo($this->order->payer_email)
			    ->subject($this->application->email_subject)
			    ->messagePlain($this->application->getBody($this->order))
				->addCustomAttachment($this->application->license_filename, $this->order->license, 'text/plain')
			    ->send();
		}

		public function downloadLicense()
		{
			header("Cache-Control: public");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Content-Type: application/x-download"); // Stupid fix for Safari not honoring content-disposition
			header("Content-Length: " . strlen($this->order->license));
			header("Content-Disposition: attachment; filename={$this->application->license_filename}");
			header("Content-Transfer-Encoding: binary");
			echo $this->order->license;
			exit;
		}

		public function hex2bin($hex)
		{
			if(strlen($hex) % 2)
				$hex = '0' . $hex;

			$bin = '';
			for($i = 0; $i < strlen($hex); $i += 2)
				$bin .= chr(hexdec(substr($hex, $i, 2))); 

			return $bin; 
		} 

		public function dec2hex($number)
		{
		    $hexvalues = array('0','1','2','3','4','5','6','7',
		                       '8','9','A','B','C','D','E','F');
		    $hexval = '';
		    while($number != '0')
		    {
		        $hexval = $hexvalues[bcmod($number,'16')] . $hexval;
		        $number = bcdiv($number, '16', 0);
		    }
		    return $hexval;
		}

		public function hex2dec($number)
		{
		    $decvalues = array('0' =>  '0', '1' =>  '1', '2' => '2',
		                       '3' =>  '3', '4' =>  '4', '5' => '5',
		                       '6' =>  '6', '7' =>  '7', '8' => '8',
		                       '9' =>  '9', 'A' => '10', 'B' => '11',
		                       'C' => '12', 'D' => '13', 'E' => '14',
		                       'F' => '15', 'a' => '10', 'b' => '11',
		                       'c' => '12', 'd' => '13', 'e' => '14',
		                       'f' => '15');
		    $decval = '0';

		    $number = array_pop(explode("0x", $number,  2));

		    $number = strrev($number);
		    for($i = 0; $i < strlen($number); $i++)
				$decval = bcadd(bcmul(bcpow('16', $i, 0), $decvalues[$number{$i}]), $decval);

		    return $decval;
		}

		public function powmod($num, $pow, $mod)
		{
			if(function_exists('bcpowmod'))
				return bcpowmod($num, $pow, $mod);

		    // Emulate bcpowmod
		    $result = '1';
		    do
			{
		        if(!bccomp(bcmod($pow, '2'), '1'))
		            $result = bcmod(bcmul($result, $num), $mod);

		        $num = bcmod(bcpow($num, '2'), $mod);
		        $pow = bcdiv($pow, '2');
		    }
			while(bccomp($pow, '0'));

		    return $result;
		}

		public function getSignature($dict, $key, $privKey)
		{
		    // Sort keys alphabetically
		    uksort($dict, "strcasecmp");

		    // Concatenate all values
		    $total = '';
		    foreach ($dict as $value)
		        $total .= $value;

		    // Get the hash
		    $hash = sha1(utf8_encode($total));

		    // OpenSSL-compatible PKCS1 Padding
		    // 128 bytes - 20 bytes hash - 3 bytes extra padding = 105 bytes '0xff'
		    $paddedHash = '0001';
		    for ($i = 0; $i < 105; $i++)
		    {
		        $paddedHash .= 'ff';
		    }
		    $paddedHash .= '00'.$hash;

		    $decryptedSig = $this->hex2dec($paddedHash);

		    // Encrypt into a signature
		    $sig = $this->powmod($decryptedSig, $this->hex2dec($privKey), $this->hex2dec($key));
		    $sig = base64_encode($this->hex2bin($this->dec2hex($sig)));

		    return $sig;
		}
	}

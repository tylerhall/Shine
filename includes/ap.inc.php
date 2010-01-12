<?PHP
/** 
  * AquaticPrime PHP implementation
  * Creates license file from associative arrays and a public-private keypair
  * This implementation requires bcmath, which is included with PHP 4.0.4+
  * @author Lucas Newman, Aquatic
  * @copyright Copyright &copy; 2005 Lucas Newman
  * @license http://www.opensource.org/licenses/bsd-license.php BSD License
  */
  
/**
  * hex2bin
  * Converts a hexadecimal string to binary
  * @param string Hex string
  * @return string Binary string
  */
function hex2bin($hex)
{
	if(strlen($hex) % 2)
		$hex = '0' . $hex;

	$bin = '';
	for($i = 0; $i < strlen($hex); $i += 2)
		$bin .= chr(hexdec(substr($hex, $i, 2))); 

	return $bin; 
} 

/**
  * dec2hex
  * Converts a decimal string to a hexadecimal string
  * @param string Decimal string
  * @return string Hex string
  */
function dec2hex($number)
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

/**
  * hex2dec
  * Converts a hexadecimal string to decimal string
  * @param string Hex string
  * @return string Decimal string
  */
function hex2dec($number)
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

/**
  * powmod
  * Raise a number to a power mod n
  * This could probably be made faster with some Montgomery trickery, but it's just fallback for now
  * @param string Decimal string to be raised
  * @param string Decimal string of the power to raise to
  * @param string Decimal string the modulus
  * @return string Decimal string
  */
function powmod($num, $pow, $mod)
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

/**
  * getSignature
  * Get the base64 signature of a dictionary
  * @param array Associative array (i.e. dictionary) of key-value pairs
  * @param string Hexadecimal string of public key
  * @param string Hexadecimal string the private key
  * @return string Base64 encoded signature
  */
function getSignature($dict, $key, $privKey)
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

    $decryptedSig = hex2dec($paddedHash);

    // Encrypt into a signature
    $sig = powmod($decryptedSig, hex2dec($privKey), hex2dec($key));
    $sig = base64_encode(hex2bin(dec2hex($sig)));

    return $sig;
}

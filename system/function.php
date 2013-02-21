<?
if (!defined('__CONTROL__')) die ("You Cannot Access This Script Directly");

function redirect($time, $topage) {
	echo "<meta http-equiv=\"refresh\" content=\"{$time}; url={$topage}\" /> ";
}

function encryption($string){
	$new = base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($string))))));
	return $new;
}

function decryption($string){
	$new = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($string))))));
	return $new;
}

function printr($data){
	echo "<pre>";
	print_r($data);
	echo "</pre><br />";
}

function base64encode ($filename = string) {
    if (file_exists($filename)) {
		$handle = fopen($filename, "rb");
		$img = fread($handle, filesize($filename));
		fclose($handle);
        $string = chunk_split(base64_encode($img));
		//$string = preg_replace('/(.{64})/', '$1\n', $string);
		return $string;
    }
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    
    for ($i=0; $i<8; $i++):
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
	endfor;
    return implode($pass); 
}

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function loading_page(){
	if (ob_get_level() == 0) {
		ob_start();
	}
	echo str_pad('Loading... ',4096)."<br />\n";
	
	for ($i = 0; $i < 25; $i++) {
		$d = $d + 11;
		$m=$d+10;
		//This div will show loading percents
		echo '<div class="percents">' . $i*4 . '%&nbsp;complete</div>';
		//This div will show progress bar
		echo '<div class="blocks" style="left: '.$d.'px">&nbsp;</div>';
		flush();
		ob_flush();
		sleep(1);
	}
	
	ob_end_flush();
}

function getRealIP(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])):   //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):   //to check ip is pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else:
      $ip = $_SERVER['REMOTE_ADDR'];
	endif;
	
	return $ip;
}
?>
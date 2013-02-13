<?
/**
 * 
 * GPFRemoteFile 클래스 : 원격 파일 읽어오기
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFRemoteFile
{
	public function getFile($url)
	{
		if (function_exists('curl_init')) return $this->_getFileCurl($url);
		else if (ini_get('allow_url_fopen') == '1') return $this->_getFileFopen($url);
		else return $this->_getFileSocket($url);
	}

	protected function _getFileCurl($url)
	{
		echo "curl";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 
		$content = curl_exec($ch); 
		curl_close($ch); 
		return $content;
	}

	protected function _getFileFopen($url)
	{
		echo "fopen";
		$content = file_get_contents($url); 
		if ($content !== false) return $content;
		
		return $this->_getFileSocket($url);
	}

	function _getFileSocket($url)
	{
		echo "socket";
		$parsedUrl = parse_url($url);
		$host = $parsedUrl['host'];
		if (isset($parsedUrl['path'])) {
			$path = $parsedUrl['path'];
		} else {
			$path = '/';
		}

		if (isset($parsedUrl['query'])) {
			$path .= '?' . $parsedUrl['query'];
		} 

		if (isset($parsedUrl['port'])) {
			$port = $parsedUrl['port'];
		} else {
			$port = '80';
		}

		$timeout = 10;
		$response = '';

		$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

		if( !$fp )  return "";

		fputs($fp, "GET $path HTTP/1.0\r\n" .
					"Host: $host\r\n" .
					"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
					"Accept: */*\r\n" .
					"Accept-Language: en-us,en;q=0.5\r\n" .
					"Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
					"Keep-Alive: 300\r\n" .
					"Connection: keep-alive\r\n" .
					"Referer: http://$host\r\n\r\n");

		while ( $line = fread( $fp, 4096 ) ) { 
			$response .= $line;
		}

		fclose( $fp );

		$pos      = strpos($response, "\r\n\r\n");
		$response = substr($response, $pos + 4);

		return $response;
	}
}
?>
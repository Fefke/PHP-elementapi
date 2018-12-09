<?php
	
	class element_iot {
		private $api_version = "v1";
		private $api_path = "iot.stadtwerke-karlsruhe.de";//ohne Zusatz
		private $api_key;
		private $api_options = "";
		private $data;
		
		/*cURL configuration*/
		private $proxy;
		private $user_agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)";
		private $headers = [
				"Accept: application/json",
				"Connection: Keep-Alive",
				"Content-type: application/json;charset=UTF-8"
			];
		
		
		
		public function __construct($api_key, $domain = NULL) {
			$this->api_key = $api_key;
			
			$this->api_path = (isset($domain)) ? $domain : $this->api_path;
		}//__construct($api_key, $domain = NULL)		
		
		
		
		
		
		/* Getter / Setter */
		public function set_api_key($api_key) {
			$this->api_key = $api_key;
		}//public function setAPI($api_key)
		
		public function get_api_key() {
			return "************************" . substr($this->api_key, 24);
			//Return last 8 Symbols of the API-KEY -> for security reasons
		}//public function getAPI()
		
		
		public function get($tp = [], $configuration = []) {
			$gu = $this->generateURL($tp, $configuration);
			if ($gu !== true )
				return $gu;
			//Start Request to ELEMENT Server
			$this->doRequest();
			return $this->data;//RETURN answered data
			
		}
		
		public function get_cached_data() {
			if (isset($data)) 
				return $this->data;
			else
				return "There is no cached data! Please use element_iot::get([], []) for getting data";
		}
		
		
		
		/* cURL */
		private function doRequest() {
			// cURL Start
				$cE = curl_init($this->api_path);
				curl_setopt($cE, CURLOPT_HTTPHEADER, $this->headers);
				curl_setopt($cE, CURLOPT_HEADER, 0);
				curl_setopt($cE, CURLOPT_USERAGENT, $this->user_agent);
				curl_setopt($cE,CURLOPT_ENCODING , "gzip");
				curl_setopt($cE, CURLOPT_TIMEOUT, 30);
				if ($this->proxy) curl_setopt($cE, CURLOPT_PROXY, $this->proxy);
				curl_setopt($cE, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($cE, CURLOPT_FOLLOWLOCATION, 1);
				$return = curl_exec($cE);
				curl_close($cE);
			// cURL Ende
			$return = json_decode($return);//convert from JSON to PHP Array
			$return = $this->O2A($return);//
			$this->data = $return;
			return $return;
		}//private function doRequest()
		
		
		
		
		
		/* Hilfsfunktionen */
		private function generateURL($tp, $configuration) {
			//Format time to ISO 8601 and UTC
			
			//Set GET Options
			foreach ($configuration as $key => $value) {
				if (strtolower($key) == "id")
					$device_id = $value;
				else if (isset($value) && $value != "")
					$this->api_options = $this->api_options . $key . "=" . $value . "&";
			}
			
			
			//Set GET Parameters
			if ($tp == "devices" || $tp[0] == "devices"){
				if (!isset($device_id))
					return "Invalid or not setted Device ID!";
				
				if (isset($tp[1]) && $tp[1] == "readings")
					$uri_string = "/devices/" . $device_id . "/readings";
				else if (isset($tp[1]) && $tp[1] == "packets")
					$uri_string = "/devices/" . $device_id . "/packets";
				else if (isset($tp[1]) && $tp[1] == "interfaces")
					$uri_string = "/devices";
				else
					$uri_string = "/devices";
				
			} else if ($tp == "tags" || $tp[0] == "tags") {
				$uri_string = "/tags";
				
			} else if ($tp == "parsers" || $tp[0] == "parsers") {
				$uri_string = "/parsers";
				
			} else if ($tp == "drivers" || $tp[0] == "drivers") {
				if (isset($tp[1]) && $tp[1] == "instances"):
					$uri_string = "/parsers";
				else:
					if (!isset($device_id))
						return "Invalid or not setted Device ID!";
					$uri_string = "/drivers/instances/" . $device_id;
				endif;
				
			} else if ($tp == "api_keys" || $tp[0] == "api_keys") {
				$uri_string = "/api_keys";
				
			} else if ($tp == "groups" || $tp[0] == "groups") {
				$uri_string = "/groups";
				
			} else if ($tp == "mandates" || $tp[0] == "mandates") {
				if (!isset($device_id))
					return "Invalid or not setted Device ID!";
				
				if (isset($tp[1]) && $tp[1] == "stats"):
					if (isset($tp[2]) && $tp[2] == "packets")
						$uri_string = "/mandates/" . $device_id . "/stats/packets";
					else if (isset($tp[2]) && $tp[2] == "created_devices")
						$uri_string = "/mandates/" . $device_id . "/stats/created_devices";
					else
						return '<b>only "stats" as type does not work!</b> Pick between "packets" and "created_devices" after "stats"';
				else:
					return 'Invalid "mandates" types -> use "stats"';
				endif;
			} else {
				return "Invalid Type!";
			}
			
			//Setup for SSL if not already done
			$tmp = explode("://", $this->api_path);
			$this->api_path = (isset($tmp[0]) && $tmp[0] == "https") ?  $this ->api_path : "https://" .  $tmp[1];
			
			//Build final URI
			$this->api_path = $this->api_path . "/api/" . $this->api_version . $uri_string . "?" . $this->api_options . "auth=" . $this->api_key;
						
			return true;
			
		}//private function generateURL()
		
		
		
		private function O2A($object, &$array = NULL) {//Object to Array
			$array = (isset($array)) ? $array : array();
			
			if(!is_object($object) && !is_array($object)) {
				$array = $object;
				return $array;
			}
			
			foreach ($object as $key => $value) {
				if (!empty($value)) {
					$array[$key] = array();
					$this->O2A($value, $array[$key]);
				} else {
					$array[$key] = $value;
				}
				
				
			}

			return $array;
		}//function O2A($object, &$array = NULL)
		
		
	}

?>

<?php
/**
 * This is for detecting information of device from User Agent 
 * and is particulary optimized to Android and iOS.
 * So it is not enough function for other devices, PC 
 * browsers, Japanese mobile devices t  
 *
 * @author aji7saba@gmail.com
 *
 */
class DeviceDetect {
	const INFO_TYPE = 'type';
	const INFO_NAME = 'name';
	const INFO_VERSION_MAJOR = 'v_major';
	const INFO_VERSION_MINOR = 'v_minor';
	const INFO_VERSION_ETC   = 'v_etc';

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	public function getUserAgent($userAgent = null) {
		if (!is_null($userAgent)) {
			return $userAgent;
		} elseif (isset($_SERVER['USER_AGENT'])) {
			return $_SERVER['USER_AGENT'];
		} else {
			return '';
		}
	}

	/**
	 * Return strings of device type from User Agent.
	 * Strings of the device type are all small chracters.
	 * e.g.  'ios', 'android', 'windows phone',
	 *       'docomo', 'kddi', 'softbank'
	 */
	public function getDeviceType($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$info = $this->getDeviceInfo($ua);
		if (!empty($info)) {
			if (isset($info[self::INFO_TYPE])) {
				return $info[self::INFO_TYPE];
			}
		}
		return '';
	}

	public function isIos($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (preg_match('/(iPhone|iPad|iPod)/i', $ua)) {
			return true;
		}
		return false;
	}

	public function isAndroid($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Android') !== false) {
			return true;
		}
		return false;
	}

	public function isWindowsPhone($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Windows Phone') !== false) {
			return true;
		}
		return false;
	}

	public function isIE($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'MSIE') !== false) {
			return true;
		}
		return false;
	}

	public function isChrome($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Chrome') !== false) {
			return true;
		}
		return false;
	}

	public function isFirefox($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Firefox') !== false) {
			return true;
		}
		return false;
	}

	public function isSafari($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Safari') !== false) {
			return true;
		}
		return false;
	}

	public function isOpera($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'Opera') !== false) {
			return true;
		}
		return false;
	}

	public function isDocomo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'DoCoMo') !== false) {
			return true;
		}
		return false;
	}

	public function isKddi($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (strpos($ua, 'KDDI') !== false) {
			return true;
		}
		return false;
	}

	public function isSoftbank($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (preg_match('/(Softbank|Vodafone)/i', $ua)) {
			return true;
		}
		return false;
	}

	public function isWillcom($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (preg_match('/(Willcom|DDIPOCKET)/i', $ua)) {
			return true;
		}
		return false;
	}

	public function isMobile($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isDocomo($ua)) {
			return true;
		} elseif ($this->isKddi($ua)) {
			return true;
		} elseif ($this->isSoftbank($ua)) {
			return true;
		}
		return false;
	}

	public function isSmartPhone($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isIos($ua)) {
			return true;
		} elseif ($this->isAndroid($ua)) {
			return true;
		} elseif ($this->isWindowsPhone($ua)) {
			return true;
		}
		return false;
	}

	/**
	 * If User Agent is for Android or iOS, this returns true.
	 * 
	 */
	public function isAndroidIos($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isIos($ua)) {
			return true;
		} elseif ($this->isAndroid($ua)) {
			return true;
		}
		return false;
	}

	public function getAndroidInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$type = 'android';
		$name = 'android';
		$major = '';
		$minor = '';
		$etc = '';
		if (preg_match('/Android (\d)\.(\d)(\.(\d))?/i', $ua, $match)) {
			$major = $match[1];
			$minor = $match[2];
			$etc = isset($match[4]) ? $match[4] : 0;
		} else if (strpos($ua, 'Android')) {
			//
		} else {
			$type = '';
			$name = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getIosInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$type = 'ios';
		if (preg_match('/(iPhone|iPad|iPod);( U;)? CPU( iPhone)? OS (\d)_(\d)( |_(\d) )/', $ua, $match)) {
			$name = strtolower($match[1]);
			$major = $match[4];
			$minor = $match[5];
			$etc = isset($match[7]) ? $match[7] : 0;
		} elseif (strpos($ua, 'iPhone; U; CPU like Mac')) {
			$name = 'iphone';
			$major = 1;
			$minor = 0;
			$etc = 0;
		} elseif (strpos($ua, 'iPhone')) {
			$name = 'iphone';
			$major = '';
			$minor = '';
			$etc = '';
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getWindowsPhoneInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$type = 'windows phone';
		$name = 'windows phone';
		if (preg_match('/Windows Phone( OS)? (\d)\.(\d)(\.(\d))?/i', $ua, $match)) {
			$major = $match[2];
			$minor = $match[3];
			$etc = isset($match[5]) ? $match[5] : 0;
		} elseif (strpos($ua, 'Windows Phone')) {
			$major = '';
			$minor = '';
			$etc = '';
			
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getDocomoInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (preg_match('/DoCoMo\/(\d)\.(\d)\/(\w+)\//', $ua, $match)) {
			$type = 'docomo';
			$name = strtolower($match[3]);
			$major = $match[1];
			$minor = $match[2];
			$etc = 0;
		} elseif (preg_match('/DoCoMo\/2.0 ([\w]+)/', $ua, $match)) {
			$type = 'docomo';
			$name = strtolower($match[1]); 
			$major = 2;
			$minor = 0;
			$etc = 0;
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getKddiInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if (preg_match('/KDDI-(\w+) (.*)\/(\d)\.(\d)\.(\d)/i', $ua, $match)) {
			$type = 'kddi';
			$name = strtolower($match[1]);
			$major = $match[3];
			$minor = $match[4];
			$etc = $match[5];
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getSoftbankInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$type = 'softbank';
		if (preg_match('/(SoftBank|Vodafone)\/(\d)\.(\d)\/(\w+)\//i', $ua, $match)) {
			$name = strtolower($match[4]);
			$major = $match[2];
			$minor = $match[3];
			$etc = 0;
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getWillcomInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		$type = 'willcom';
		if (preg_match('/(Willcom|DDIPOCKET)/i', $ua, $match)) {
			$name = strtolower($match[1]);
			$major = '';
			$minor = '';
			$etc = '';
		} else {
			$type = '';
			$name = '';
			$major = '';
			$minor = '';
			$etc = '';
		}
		return array(
			self::INFO_NAME => $name,
			self::INFO_TYPE => $type,
			self::INFO_VERSION_MAJOR => $major,
			self::INFO_VERSION_MINOR => $minor,
			self::INFO_VERSION_ETC => $etc,
		);
	}

	public function getSmartPhoneInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isAndroid($ua)) {
			return $this->getAndroidInfo($ua);
		} elseif ($this->isIos($ua)) {
			return $this->getIosInfo($ua);
		} elseif ($this->isWindowsPhone($ua)) {
			return $this->getWindowsPhoneInfo($ua);
		} else {
			return array();
		}
	}

	public function getMobileInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isDocomo($ua)) {
			return $this->getDocomoInfo($ua);
		} elseif ($this->isKddi($ua)) {
			return $this->getKddiInfo($ua);
		} elseif ($this->isSoftbank($ua)) {
			return $this->getSoftbank($ua);
		}
		return array();
	}

	public function getDeviceInfo($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);

		$info = $this->getSmartPhoneInfo($ua);
		if (!empty($info)) {
			return $info;
		}

		$info = $this->getMobileInfo($ua);
		if (!empty($info)) {
			return $info;
		}
		return array();
	}

	/**
	 * If the device is enable to upload files by form, this returns true.
	 * In the other case, this returns false.
	 */
	public function isEnableFileUpload($userAgent = null) {
		$ua = $this->getUserAgent($userAgent);
		if ($this->isMobile($ua)) {
			return false;
		}
		if ($this->isWillcom($ua)) {
			return false;
		}
		$info = $this->getSmartPhoneInfo($ua);
		if (empty($info)) {
			// Others except mobile and smart phone. 
			return false;
		}

		$type = $info[self::INFO_TYPE];
		$major = $info[self::INFO_VERSION_MAJOR];
		if ($type == 'ios') {
			if ($major >= 6) {
				return true;
			}
			return false;
		} elseif ($type == 'android') {
			if ($major >= 3) {
				return true;
			}
			return false;
		}
			
		return false;
	}
}
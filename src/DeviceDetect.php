<?php
/**
 * This is a simple php class for detecting information of device from user 
 * agent and is particulary optimized to Android and iOS.
 * So it is not enough function for other devices, PC 
 * browsers, Japanese mobile devices. 
 *
 * @author aji7saba@gmail.com
 *
 */
class DeviceDetect {
    /**
     * Hash keys of returned information.
     */
    const INFO_TYPE = 'type';
    const INFO_NAME = 'name';

    // Major version number
    const INFO_VERSION_MAJOR = 'v_major';

    // Minor version number
    const INFO_VERSION_MINOR = 'v_minor';

    // Other version information of majar and minor
    const INFO_VERSION_ETC   = 'v_etc';

    /**
     * Device type for outputing device information.
     * e.g.  ios 
     */
    private $type;

    /**
     * Device name for outputing device information.
     * e.g. iphone or ipad
     */
    private $name;

    /**
     * Array for version information for outputing device information.
     */ 
    private $version;

    /**
     * Constructor
     */
    public function __construct() {
    }

    /**
     * Returns a user ugent string.
     *
     * @param string $userAgent
     * @return a user agent string.
     */
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
     * Set a device type string for outputing device information.
     *
     * @param string $type  a device type string.  
     */
    public function setInfoType($type) {
        $this->type = $type;
    }

    /**
     * Set a device name string for outputing device information.
     *
     * @param string $name  a device type name.  e.g. iphone, ipad
     */
    public function setInfoName($name) {
        $this->name = $name;
    }

    /**
     * Set device version integer and string. for outputing device information.
     *
     * @param integer $major  a integer of major version.
     * @param integer $mino   a integer of minor version. 
     * @param string $tect    a other version string.
     */
    public function setVersion($major, $minor, $etc) {
        $this->version = array(
            self::INFO_VERSION_MAJOR => $major,
            self::INFO_VERSION_MINOR => $minor,
            self::INFO_VERSION_ETC => $etc,
        );
    }

    /**
     * Returns a array that has device type, name, and version information.
     *
     * @return array
     */
    public function getInfo() {
        if (is_null($this->type)) {
            return null;
        }
        if (is_null($this->name)) {
            return null;
        }
        if (is_null($this->version)) {
            return null;
        }
        $info = $this->version;
        return array_merge(
            array(
                self::INFO_TYPE => $this->type,
                self::INFO_NAME => $this->name,
            ),
            $info 
        );
    }

    /**
     * Clear class fields of outputing device information.
     */
    public function clearInfo() {
        $this->type = null;
        $this->name = null;
        $this->version = null;
    }

    /**
     * Returns a device type string.
     *
     * @param array $info  device information
     * @return string
     */
    public function getInfoType($info = null) {
        if (empty($info)) {
            return '';
        } else if (isset($info[self::INFO_TYPE])) {
            return $info[self::INFO_TYPE];
        }
        return '';
    }

    /**
     * Return a device type string. It consists of small characters.
     * e.g.  'ios', 'android', 'windows phone',
     *       'docomo', 'kddi', 'softbank'
     *
     * @param string $userAgent
     * @return string
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

    /**
     * Returns true if iOS.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isIos($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (preg_match('/(iPhone|iPad|iPod)/i', $ua)) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Android.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isAndroid($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'Android') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Windows Phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isWindowsPhone($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'Windows Phone') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if IE(Internet Explore).
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isIe($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isWindowsPhone($ua)) {
            return false;
        } elseif (strpos($ua, 'MSIE') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true If Google chrome.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isChrome($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isAndroid($ua)) {
            return false;
        } elseif (strpos($ua, 'Chrome') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Firefox.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isFirefox($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'Firefox') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Safari.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isSafari($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isIos($ua) || $this->isAndroid($ua) || $this->isChrome($ua)) {
            return false;
        } elseif (strpos($ua, 'Safari') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Opera.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isOpera($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'Opera') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Docomo phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isDocomo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'DoCoMo') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if KDDI phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isKddi($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (strpos($ua, 'KDDI') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Softbank phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isSoftbank($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (preg_match('/(Softbank|Vodafone)/i', $ua)) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Willcom phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
    public function isWillcom($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (preg_match('/(Willcom|DDIPOCKET)/i', $ua)) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if Japanese mobile phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
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

    /**
     * Returns true if Smart phone.
     * 
     * @param string $userAgent
     * @return boolean 
     */
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
     * Returns true if Android.
     * 
     * @param string $userAgent
     * @return boolean 
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

    /**
     * Returns the information of unknown device.
     *
     * @return null
     */
    public function getUnknownInfo() {
        return null;
    }

    /**
     * Returns the information of device type and version
     * of Android.
     *
     * @param string $userAgent
     * @return array
     */
    public function getAndroidInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isAndroid($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Android (\d)\.(\d)(\.(\d))?/i', $ua, $match)) {
            $major = $match[1];
            $minor = $match[2];
            $etc = isset($match[4]) ? $match[4] : 0;
        } else {
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('android');
        $this->setInfoName('android');
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of iOS.
     *
     * @param string $userAgent
     * @return array
     */
    public function getIosInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isIos($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/(iPhone|iPad|iPod)( touch)?;( U;)? CPU( iPhone)? OS (\d)_(\d)( |_(\d) )/', $ua, $match)) {
            $name = strtolower($match[1]);
            $major = $match[5];
            $minor = $match[6];
            $etc = isset($match[8]) ? $match[8] : 0;
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
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('ios');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Windows Phone.
     *
     * @param string $userAgent
     * @return array
     */
    public function getWindowsPhoneInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isWindowsPhone($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Windows Phone( OS)? (\d)\.(\d)(\.(\d))?/i', $ua, $match)) {
            $major = $match[2];
            $minor = $match[3];
            $etc = isset($match[5]) ? $match[5] : 0;
        } else {
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('windows phone');
        $this->setInfoName('windows phone');
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of DOCOMO mobile phone.
     *
     * @param string $userAgent
     * @return array
     */
    public function getDocomoInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isDocomo($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/DoCoMo\/(\d)\.(\d)\/(\w+)\//', $ua, $match)) {
            $name = strtolower($match[3]);
            $major = $match[1];
            $minor = $match[2];
            $etc = 0;
        } elseif (preg_match('/DoCoMo\/2.0 ([\w]+)/', $ua, $match)) {
            $name = strtolower($match[1]); 
            $major = 2;
            $minor = 0;
            $etc = 0;
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('docomo');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of KDDI mobile phone.
     *
     * @param string $userAgent
     * @return array
     */
    public function getKddiInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isKddi($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/KDDI-(\w+) (.*)\/(\d)\.(\d)\.(\d)/i', $ua, $match)) {
            $name = strtolower($match[1]);
            $major = $match[3];
            $minor = $match[4];
            $etc = $match[5];
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('kddi');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Softbank mobile phone.
     *
     * @param string $userAgent
     * @return array
     */
    public function getSoftbankInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isSoftbank($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/(SoftBank|Vodafone)\/(\d)\.(\d)\/(\w+)\//i', $ua, $match)) {
            $name = strtolower($match[4]);
            $major = $match[2];
            $minor = $match[3];
            $etc = 0;
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        }
        $this->setInfoType('softbank');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Willcom.
     *
     * @param string $userAgent
     * @return array
     */
    public function getWillcomInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isWillcom($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/(Willcom|DDIPOCKET)/i', $ua, $match)) {
            $name = strtolower($match[1]);
        } else {
            $name = '';
        }
        $this->setInfoType('willcom');
        $this->setInfoName($name);
        $this->setVersion('', '', '');
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of IE(Internet Explore).
     *
     * @param string $userAgent
     * @return array
     */
    public function getIeInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isIe($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/MSIE (\d+)\.(\d)/', $ua, $match)) {
            $name = 'ie';
            $major = $match[1];
            $minor = $match[2];
        } else {
            $name = '';
            $major = '';
            $minor = '';
        } 
        $etc = '';
        $this->setInfoType('ie');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Chrome.
     *
     * @param string $userAgent
     * @return array
     */
    public function getChromeInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isChrome($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Chrome\/(\d+)\.(\d+)\.(\d+(\.\d+)?)/', $ua, $match)) {
            $name = 'chrome';
            $major = $match[1];
            $minor = $match[2];
            $etc = $match[3];
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        } 
        $this->setInfoType('chrome');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Firefox.
     *
     * @param string $userAgent
     * @return array
     */
    public function getFirefoxInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isFirefox($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Firefox\/(\d+)\.(\d+)(\.(\d+))?/', $ua, $match)) {
            $name = 'firefox';
            $major = $match[1];
            $minor = $match[2];
            $etc = isset($match[4]) ? $match[4] : '';
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        } 
        $this->setInfoType('firefox');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Safari.
     *
     * @param string $userAgent
     * @return array
     */
    public function getSafariInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isSafari($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Safari\/(\d+)\.(\d+)(\.(\d+))?/', $ua, $match)) {
            $name = 'safari';
            $major = $match[1];
            $minor = $match[2];
            $etc = isset($match[4]) ? $match[4] : '';
        } else {
            $name = '';
            $major = '';
            $minor = '';
            $etc = '';
        } 
        $this->setInfoType('safari');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of Opera.
     *
     * @param string $userAgent
     * @return array
     */
    public function getOperaInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if (!$this->isOpera($ua)) {
            return $this->getUnknownInfo();
        } elseif (preg_match('/Version\/(\d+)\.(\d+)/', $ua, $match)) {
            $name = 'opera';
            $major = $match[1];
            $minor = $match[2];
        } elseif (preg_match('/Opera (\d+)\.(\d+)/', $ua, $match)) {
            $name = 'opera';
            $major = $match[1];
            $minor = $match[2];
        } else {
            $name = '';
            $major = '';
            $minor = '';
        } 
        $etc = '';
        $this->setInfoType('opera');
        $this->setInfoName($name);
        $this->setVersion($major, $minor, $etc);
        $info = $this->getInfo();
        $this->clearInfo();
        return $info;
    }

    /**
     * Returns the information of device type and version
     * of smart phones.
     *
     * @param string $userAgent
     * @return array
     */
    public function getSmartPhoneInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isAndroid($ua)) {
            return $this->getAndroidInfo($ua);
        } elseif ($this->isIos($ua)) {
            return $this->getIosInfo($ua);
        } elseif ($this->isWindowsPhone($ua)) {
            return $this->getWindowsPhoneInfo($ua);
        }
        return $this->getUnknownInfo(); 
    }

    /**
     * Returns the information of device type and version 
     * of Japanese mobile phones.
     *
     * @param string $userAgent
     * @return array
     */
    public function getMobileInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isDocomo($ua)) {
            return $this->getDocomoInfo($ua);
        } elseif ($this->isKddi($ua)) {
            return $this->getKddiInfo($ua);
        } elseif ($this->isSoftbank($ua)) {
            return $this->getSoftbank($ua);
        }
        return $this->getUnknownInfo(); 
    }

    /**
     * Returns the information of device type and version 
     * of PC browsers.
     *
     * @param string $userAgent
     * @return array
     */
    public function getPcBrowserInfo($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        if ($this->isIe($ua)) {
            return $this->getIeInfo($ua);
        } elseif ($this->isChrome($ua)) {
            return $this->getChromeInfo($ua);
        } elseif ($this->isFirefox($ua)) {
            return $this->getFirefoxInfo($ua);
        } elseif ($this->isSafari($ua)) {
            return $this->getSafariInfo($ua);
        } elseif ($this->isOpera($ua)) {
            return $this->getOperaInfo($ua);
        }
        return $this->getUnknownInfo(); 
    }

    /**
     * Returns a array that has the information of devie type, name and version information.
     *
     * @param string $userAgent
     * @return array
     */
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

        $info = $this->getPcBrowserInfo($ua);
        if (!empty($info)) {
            return $info;
        }
        return null;
    }

    /**
     * If the device is enable to upload files by form, this returns true.
     * In the other case, this returns false.
     *
     * @param string $userAgent
     * @return boolean
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

    /**
     * Returns true if a device is enable to use FileAPI.
     *
     * @param string $userAgent
     * @return boolean
     */
    public function isEnableFileApi($userAgent = null) {
        $ua = $this->getUserAgent($userAgent);
        $info = $this->getSmartPhoneInfo($ua);
        if (!empty($info)) {
            $type = $info[self::INFO_TYPE];
            $major = $info[self::INFO_VERSION_MAJOR];
            if ($type == 'ios') {
                if ($major >= 6) {
                    return true;
                }
                return false;
            } elseif ($type == 'android') {
                if ($major >= 4) {
                    return true;
                }
                return false;
            }
            return false;
        }

        $info = $this->getPcBrowserInfo($ua);
        if (!empty($info)) {
            $type = $info[self::INFO_TYPE];
            $major = $info[self::INFO_VERSION_MAJOR];
            if (empty($major)) {
                return false;
            }
            if ($type == 'ie') {
                if ($major >= 10) {
                    return true;
                }
            } elseif ($type == 'chrome') {
                if ($major >= 6) {
                    return true;
                }
            } elseif ($type == 'firefox') {
                if ($major >= 4) {
                    return true;
                } elseif ($major == 3) {
                    $minor = $info[self::INFO_VERSION_MINOR];
                    if (!empty($minor) && $minor >= 6) {
                        return true;
                    }
                }  
            }
            return false;
        }
        return false;
    }
}

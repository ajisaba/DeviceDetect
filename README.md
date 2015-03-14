DeviceDetect
====

## Description
This is a simple php class for detecting information of device from User Agent and is particulary optimized to Android and iOS.
Supported device is  PC browsers, smart phones, Japanese mobile devices(Docomo, Kddi, Softbank). 


## Usage
Include DeviceDetect.php and write as the followings.

``` php

<?php
require_once('DeviceDetect.php');

$detect = new DeviceDetect();
if ($detect->isAndroid()) {
   // Something for Android
} elseif ($detect->isIos()) {
   // Something for iOS
} elseif ($detect->isIe()) {
   ... 
} elseif ($detect->isFirefox()) {
   ... 
} elseif ($detect->isDoComo()) {
   ...
} elseif ($detect->isKddi()) {
   ...
}

if ($detect->isEnableFileUpload()) {
  // file upload of form
} 

if ($detect->isSmartPhone()) {
   ...
}

if ($detect->isAndroidIos()) {
   // something for Android or iOS
}

$info = $detect->getSmartPhoneInfo();
$type = $info[DeviceDetect::INFO_TYPE];
if ($type == 'ios' || $type == 'android' || $type == 'windows phone') {
    ...
}

$majar = $info[DeviceDetect::INFO_VERSION_MAJOR];
$minor = $info[DeviceDetect::INFO_VERSION_MINOR];

if ($major > 6) {
    ...
}

```

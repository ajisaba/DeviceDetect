DeviceDetect
====

## Description
This is a simple php class for detecting information of device from User Agent and is particulary optimized to Android and iOS.
So test is not enough for other devices (PC browsers, Japanese mobile devices). 


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
} elseif ($detect->isIE()) {
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

if ($detect->isAndroidIos()) {
   // something for Android or iOS
}
```

# Font-Awesome-Captcha
[![License](https://img.shields.io/badge/Version-1.0-green?style=for-the-badge)](https://opensource.org/licenses/MIT)
[![App Version](https://img.shields.io/badge/License-MIT-lightgreen?style=for-the-badge)](https://github.com/VMWRITE/Font-Awesome-Captcha/)


A simple captcha which using a font-awesome to render.

## Showcase

![banner](https://raw.githubusercontent.com/VMWRITE/Font-Awesome-Captcha/refs/heads/main/showcase.jpg)

## Features
- Easy to customize
- Unusual method
- All data stored in session and can't be extracted

## How to use

```php
<?php
require_once "Captcha.php";

$captcha = new Captcha(400, 100, 6,
    $GLOBALS['ROOT'] . "/assets/fonts/fa-solid-900.ttf",
    $GLOBALS['ROOT'] . "/assets/fonts/MONTSERRAT-EXTRABOLD.TTF"
);

$captcha->PrepareCaptcha();
$captcha->GenerateCaptcha();

$server_ip = $_SERVER['SERVER_ADDR'];
$client_ip = $_SERVER['REMOTE_ADDR'];

if ($captcha->IsVerified() === false && /*Ignoring internal requests*/ $server_ip != $client_ip) {
    require_once "modules/Forum/Forum.Captcha.php";
    exit;
}

?>
```

# Credits
- Beer
  * Helped me create this
- VMWRITE (me)
  

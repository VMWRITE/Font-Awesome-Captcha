# Font-Awesome-Captcha
[![License](https://img.shields.io/badge/Version-1.1-green?style=for-the-badge)](https://opensource.org/licenses/MIT)
[![App Version](https://img.shields.io/badge/License-MIT-lightgreen?style=for-the-badge)](https://github.com/VMWRITE/Font-Awesome-Captcha/)


A simple captcha which using a font-awesome to render.

## Showcase

![banner](https://raw.githubusercontent.com/VMWRITE/Font-Awesome-Captcha/refs/heads/main/showcase.jpg)

## Features
- Easy to customize
- Unusual method
- All data stored in session and can't be extracted

## How to use

Initialization file. For example: "Captcha.File.php"
```php
<?php
require_once "Captcha.php";

$rootPath = $GLOBALS['ROOT'];

$captchaWidth = 400; // output image size in X
$captchaHeight = 100; // output image size in Y
$elementsCount = 6; // how much symbols should be generated
$pathToIcons = "$rootPath/YourIconFont.ttf"; // replace it to your path
$pathToFont = "$rootPath/YourTextFont.ttf"; // replace it to your path

$captcha = new Captcha($captchaWidth, $captchaHeight, $elementsCount, $pathToIcons, $pathToFont);

$captcha->GenerateCaptcha();
?>
```

Usage
```php
<?php
require_once "Captcha.File.php";

$captchaImage = $captcha->GetCaptchaImage();

echo "<img src='data:image/png;base64," . base64_encode($captchaImage) . "' />";

$captchaText = $captcha->GetCaptchaText();

echo "<pre>";
print_r($captchaText);
echo "</pre>";
?>
```

# Credits
- Beer
  * Helped me create this
- VMWRITE (me)
  * Created the captcha



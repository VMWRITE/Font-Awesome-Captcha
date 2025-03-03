<?php

class Captcha
{
    private $width;
    private $height;
    private $iconFont;
    private $font;
    private $elements;

    private $image;
    private $icons = [];
    private $captchaData = [];

    private const BACKGROUND_COLOR = [240, 240, 240];
    private const TEXT_COLOR = [50, 50, 50];
    private const TEXT_3D_COLOR = [100, 100, 100];
    private const SHADOW_COLOR = [180, 180, 180];

    // $iconFont -> font awesome
    // $font -> font for drawing text
    public function __construct($width, $height, $elements, $iconFont, $font)
    {
        $this->width = $width;
        $this->height = $height;
        $this->font = $font;
        $this->iconFont = $iconFont;
        $this->elements = $elements;

        $this->icons = [
            [hexdec("f102"), "fa-angles-up"],
            [hexdec("f121"), "fa-code"],
            [hexdec("f017"), "fa-clock"],
            [hexdec("f240"), "fa-battery"],
            [hexdec("f0f3"), "fa-bell"],
            [hexdec("f0e0"), "fa-envelope"],
            [hexdec("f0c0"), "fa-users"],
            [hexdec("f0c1"), "fa-link"],
            [hexdec("f0c2"), "fa-cloud"],
            [hexdec("f0c3"), "fa-flask"],
            [hexdec("f0c4"), "fa-scissors"],
            [hexdec("f7d9"), "fa-screwdriver"],
            [hexdec("f0c5"), "fa-copy"],
            [hexdec("f0c6"), "fa-paperclip"],
            [hexdec("f0c7"), "fa-save"],
        ];
    }

    public function GenerateCaptcha()
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $backgroundColor = imagecolorallocate($image, ...self::BACKGROUND_COLOR);
        $textColor = imagecolorallocate($image, ...self::TEXT_COLOR);
        $text3DColor = imagecolorallocate($image, ...self::TEXT_3D_COLOR);
        $shadowColor = imagecolorallocate($image, ...self::SHADOW_COLOR);

        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $backgroundColor);

        $fontSize = 32;
        $x = $this->width / 2 - $fontSize * $this->elements;
        $y = $this->height / 2;

        $stringWithSymbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&";

        for ($i = 0; $i < $this->elements; $i++) {
            $randomKey = array_rand($this->icons);
            [$icon, $iconText] = $this->icons[$randomKey];

            $iconEntity = html_entity_decode('&#' . $icon . ';');
            $randomSymbol = $stringWithSymbols[rand(0, strlen($stringWithSymbols) - 1)];

            $this->captchaData[] = [$iconText, $randomSymbol];

            $rotation = rand(-15, 15);
            $this->drawTextWithShadow($image, $fontSize, $rotation, $x + 4, $y + 4, $text3DColor, $this->iconFont, $iconEntity);
            $this->drawTextWithShadow($image, $fontSize, $rotation, $x + 2, $y + 2, $textColor, $this->iconFont, $iconEntity);

            $rotation = rand(-15, 15);
            $this->drawTextWithShadow($image, 24, $rotation, $x + 4, $y + 34, $textColor, $this->font, $randomSymbol);
            $this->drawTextWithShadow($image, 24, $rotation, $x + 2, $y + 32, $textColor, $this->font, $randomSymbol);

            $x += 64;
            $y = rand(40, 60);

            unset($this->icons[$randomKey]);
        }

        for ($i = 0; $i < 5; $i++) {
            if (rand(0, 1) == 0) {
                $this->captchaData[] = $this->captchaData[$i];
            }
        }

        shuffle($this->captchaData);

        $this->addNoise($image, $textColor);

        ob_start();
        imagepng($image);
        $this->image = ob_get_clean();
    }

    private function DrawTextWithShadow($image, $size, $angle, $x, $y, $color, $font, $text)
    {
        imagettftext($image, $size, $angle, $x + 2, $y + 2, $color, $font, $text);
        imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
    }

    private function AddNoise($image, $color)
    {
        for ($i = 0; $i < 2000; $i++) {
            imagesetpixel($image, rand(0, $this->width - 1), rand(0, $this->height - 1), $color);
        }

        for ($i = 0; $i < 80; $i++) {
            imageline($image, rand(0, $this->width), rand(0, $this->height), rand(0, $this->width), rand(0, $this->height), $color);
        }

        for ($i = 0; $i < 50; $i++) {
            imageellipse($image, rand(0, $this->width), rand(0, $this->height), rand(10, 40), rand(10, 40), $color);
        }
    }

    public function GetCaptchaText()
    {
        return $this->captchaData;
    }

    public function GetCaptchaImage()
    {
        return $this->image;
    }
}

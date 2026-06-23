<?php
class Captcha {

    var $font = null;
    var $fontSize = 22;
    var $height = 35;
    var $image = null;
    var $length = null;
    var $sessionVariable = null;
    var $productPrefix = null;
    var $width = 79;

    /**
     *
     * Constructor
     */
    function __construct($fontPath, $productPrefix, $sessionVariable) {
        $this->font = $fontPath;
        $this->productPrefix = $productPrefix;
        $this->sessionVariable = $sessionVariable;
    }

    function create($rand_code = null) {
        if (!function_exists('gd_info')) {
            throw new Exception('Required GD library is missing');
        }

        $captcha_config = array(
            'code' => '',
            'min_length' => 5,
            'max_length' => 5,
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#fff',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
        );

        $background = $this->image;
        list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

        $image = imagecreatefrompng($this->image);

        $text_col = imagecolorallocate($image, 68, 68, 68);

        $angle = rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (rand(0, 1) == 1 ? -1 : 1);

        $box = imagettfbbox($this->fontSize, $angle, $this->font, $rand_code);
        $box_width = abs($box[6] - $box[2]);
        $box_height = abs($box[5] - $box[1]);
        $text_pos_x_min = 0;
        $text_pos_x_max = ($bg_width) - ($box_width);
        $text_pos_x = rand($text_pos_x_min, $text_pos_x_max);
        $text_pos_y_min = $box_height;
        $text_pos_y_max = ($bg_height) - ($box_height / 2);
        $text_pos_y = rand($text_pos_y_min, $text_pos_y_max);

        imagettftext($image, $this->fontSize, $angle, $text_pos_x, $text_pos_y, $text_col, $this->font, $rand_code);

        header("Content-type: image/png");
        imagepng($image);
        imagedestroy($image);
    }
    
    function setFileName($file){
        $this->image = $file;
    }

}


<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Convert hex color to HSL format
     *
     * @param string $hex
     * @return string
     */
    public static function hexToHsl($hex)
    {
        // Remove # if present
        $hex = ltrim($hex, '#');
        
        // Convert hex to RGB
        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;
        
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $diff = $max - $min;
        
        // Calculate lightness
        $l = ($max + $min) / 2;
        
        if ($diff == 0) {
            $h = $s = 0; // achromatic
        } else {
            // Calculate saturation
            $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);
            
            // Calculate hue
            switch ($max) {
                case $r:
                    $h = (($g - $b) / $diff + ($g < $b ? 6 : 0)) / 6;
                    break;
                case $g:
                    $h = (($b - $r) / $diff + 2) / 6;
                    break;
                case $b:
                    $h = (($r - $g) / $diff + 4) / 6;
                    break;
            }
        }
        
        // Convert to degrees and percentages
        $h = round($h * 360);
        $s = round($s * 100);
        $l = round($l * 100);
        
        return "$h $s% $l%";
    }
}
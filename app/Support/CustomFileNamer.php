<?php

namespace App\Support;

use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Support\FileNamer\FileNamer;

class CustomFileNamer extends FileNamer
{
    public function originalFileName(string $fileName): string
    {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }

    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);
        $conversionName = $conversion->getName();
        
        // Custom naming logic based on conversion name
        switch ($conversionName) {
            case 'banner':
                return 'banner';
            case 'struktur':
                return 'struktur_organisasi';
            case 'thumb':
                return 'thumb';
            case 'thumbnail':
                return 'thumbnail';
            default:
                return "{$strippedFileName}-{$conversionName}";
        }
    }

    public function responsiveFileName(string $fileName): string
    {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}
<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media) . '/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    protected function getBasePath(Media $media): string
    {
        // Log untuk debugging
        Log::info('CustomPathGenerator called', [
            'media_id' => $media->id,
            'model_type' => $media->model_type,
            'collection_name' => $media->collection_name,
            'disk' => $media->disk
        ]);
        
        $modelType = \Illuminate\Support\Str::singular($media->model->getTable());
        
        // Mapping untuk nama folder yang lebih deskriptif
        $folderMapping = [
            'desa' => 'village-media',
            'berita' => 'news-media', 
            'galeri' => 'gallery-media',
            'publikasi' => 'publication-media',
            'layanan_publik' => 'public-service-media',
            'pengaduan' => 'complaint-media',
            'profil_desa' => 'village-profile-media',
            'beranda' => 'homepage-media',
            'data_sektoral' => 'sectoral-data-media',
            'footer' => 'footer-media',
            'metadata' => 'metadata-media',
            'ppid' => 'ppid-media'
        ];
        
        $folderName = $folderMapping[$modelType] ?? $modelType;
        $path = "{$folderName}/{$media->collection_name}";
        
        Log::info('CustomPathGenerator path generated', [
            'path' => $path,
            'folder_name' => $folderName
        ]);
        
        return $path;
    }
}

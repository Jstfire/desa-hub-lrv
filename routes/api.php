<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\PublikasiController;
use App\Http\Controllers\Api\DataSektoralController;
use App\Http\Controllers\Api\MetadataController;
use App\Http\Controllers\Api\PpidController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::prefix('desa/{uri}')->group(function () {
    // Visitor statistics
    Route::get('/visitor-stats', [VisitorController::class, 'getStats']);
    Route::post('/visitor/track', [VisitorController::class, 'track']);

    // Download tracking
    Route::post('/publikasi/{publikasi}/download', [PublikasiController::class, 'trackDownload']);
    Route::post('/data-sektoral/{dataSektoral}/view', [DataSektoralController::class, 'trackView']);
    Route::post('/metadata/{metadata}/download', [MetadataController::class, 'trackDownload']);
    Route::post('/ppid/{ppid}/download', [PpidController::class, 'trackDownload']);
});

// Global routes (not desa-specific)
Route::post('/publikasi/{publikasi}/download', [PublikasiController::class, 'trackDownload']);
Route::post('/data-sektoral/{dataSektoral}/view', [DataSektoralController::class, 'trackView']);
Route::post('/metadata/{metadata}/download', [MetadataController::class, 'trackDownload']);
Route::post('/ppid/{ppid}/download', [PpidController::class, 'trackDownload']);

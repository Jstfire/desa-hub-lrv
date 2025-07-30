# Deployment Guide

## Asset URL Configuration for Subdirectory Deployment

This application is configured to handle deployment in subdirectories (e.g., `/desa-hub-lrv/public/`) which requires specific environment variable configuration to ensure assets load correctly.

### Problem

When deploying to a subdirectory, asset URLs may be incorrectly generated as:
```
https://domain.com/dashboard/desa-hub-lrv/public/build/assets/file.js
```

Instead of the correct:
```
https://domain.com/desa-hub-lrv/public/build/assets/file.js
```

### Solution

The application uses specific environment variables to configure asset URLs for both Filament and Livewire:

#### Environment Variables

1. **FILAMENT_BASE_URL** - Base URL for Filament assets
2. **LIVEWIRE_BASE_PATH** - Base path for Livewire assets
3. **APP_URL** - Application base URL

#### Local Development (.env)
```env
APP_URL=http://localhost
LIVEWIRE_BASE_PATH=http://localhost/desa-hub-lrv/public
FILAMENT_BASE_URL=http://localhost/desa-hub-lrv/public
```

#### Production Deployment (.env.production)
```env
APP_URL=https://desa.buseldata.com
LIVEWIRE_BASE_PATH=https://desa.buseldata.com/desa-hub-lrv/public
FILAMENT_BASE_URL=https://desa.buseldata.com/desa-hub-lrv/public
```

### Deployment Steps

1. **Copy environment file for production:**
   ```bash
   cp .env.production .env
   ```

2. **Update database and other production-specific settings in .env**

3. **Clear configuration cache:**
   ```bash
   php artisan config:clear
   ```

4. **Publish Livewire assets:**
   ```bash
   php artisan vendor:publish --force --tag=livewire:assets
   ```

5. **Publish Filament assets:**
   ```bash
   php artisan filament:assets
   ```

6. **Optimize for production:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Configuration Files Modified

- `config/filament.php` - Added `assets_base_url` configuration
- `config/livewire.php` - Uses `asset_url` configuration
- `.env` - Local development settings
- `.env.production` - Production deployment template

### Troubleshooting

If assets are still not loading correctly:

1. Verify environment variables are set correctly
2. Clear all caches: `php artisan optimize:clear`
3. Re-publish assets
4. Check web server configuration for subdirectory handling

### Notes

- The `assets_base_url` in Filament config may not be used by default in all Filament versions
- The primary solution relies on Livewire's `asset_url` configuration
- Always test asset loading after deployment changes
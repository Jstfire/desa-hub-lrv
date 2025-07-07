#!/bin/bash

# Este script configura la integración entre Jetstream y Filament

# Asegurarse de que las migraciones están aplicadas
php artisan migrate

# Ejecutar el seeder de roles y usuarios
php artisan db:seed --class=Auth\\RolesAndPermissionsSeeder

# Asignar roles a usuarios existentes si es necesario
php artisan users:assign-roles

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Mostrar mensaje de finalización
echo ""
echo "¡Integración completada!"
echo "Ahora puedes acceder a tu aplicación con los siguientes usuarios:"
echo ""
echo "SuperAdmin:"
echo "  - Email: superadmin@mail.com"
echo "  - Password: password"
echo ""
echo "Admin Desa:"
echo "  - Email: admin@mail.id"
echo "  - Password: password"
echo ""
echo "Operator Desa:"
echo "  - Email: operator@mail.id"
echo "  - Password: password"
echo ""
echo "Todos los usuarios utilizan http://127.0.0.1:8000/login para iniciar sesión"
echo "y serán redirigidos según su rol de manera automática"

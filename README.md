# Marketplace Backend

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

Sistema completo de gestión con:
- CRUD de Productos
- CRUD de Carrito de compra
- CRUD de Usuarios
- Sistema de Roles y Permisos

## 🚀 Configuración con Docker

### 📋 Prerrequisitos
- Docker Engine >= 20.10
- Docker Compose >= 1.29
- 4GB de RAM disponible
- Git (opcional)

### 🛠️ Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/claudiasaldivar/marketplace
cd marketplace
```

## .env

- APP_URL=http://localhost:8000
- APP_NAME=Marketplace
- APP_ENV=local
- APP_KEY=base64:/McRNf+LhT5hKbHpNfrmtZnHCbkmEc1Oa/X6ONA+DXE=
- APP_DEBUG=true

- DB_CONNECTION=mysql
- DB_HOST=mysql
- DB_PORT=3306
- DB_DATABASE=marketplace
- DB_USERNAME=root
- DB_PASSWORD=root

## Docker
- docker-compose up -d --build
- docker-compose exec app composer install
- docker-compose exec app php artisan key:generate (SE AGREGA EN APP_KEY=base64)
- docker-compose exec app php artisan storage:link
- docker-compose exec app php artisan migrate

## Problema: Permisos denegados
En dado caso que tengan problema de permisos
- docker-compose exec app chown -R www-data:www-data storage bootstrap/cache



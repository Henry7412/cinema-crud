# 🎬 Cinema CRUD – Backend

API REST desarrollada en **Laravel** para la gestión de películas y turnos, con autenticación mediante **Laravel Sanctum**.

---

## 🛠️ Requisitos

- PHP 8.1 o superior
- Composer
- MySQL / MariaDB

---

## 🚀 Levantar el backend

### 1️⃣ Crear el archivo de entorno y generar la clave

```bash
cp .env.example .env
php artisan key:generate
```

Configurar la base de datos en el archivo `.env`:

```env
DB_DATABASE=cine_crud
DB_USERNAME=root
DB_PASSWORD=
```

---

### 2️⃣ Crear las tablas de la base de datos

```bash
php artisan migrate
```

---

### 3️⃣ Crear enlace simbólico para imágenes

```bash
php artisan storage:link
```

---

### 4️⃣ Limpiar caché (opcional)

```bash
php artisan optimize:clear
```

---

### 5️⃣ Levantar el servidor

```bash
php artisan serve
```

Servidor disponible en:

```
http://127.0.0.1:8000
```

---

## 🔐 Autenticación

La API utiliza **Laravel Sanctum**.

Los endpoints protegidos requieren el siguiente header:

```
Authorization: Bearer {TOKEN}
Accept: application/json
```

El token se obtiene al **registrarse** o **iniciar sesión**.

---

## 📌 Endpoints

### Auth

- `POST /api/auth/register`
- `POST /api/auth/login`
- `GET /api/auth/me`
- `POST /api/auth/logout`

---

### Películas (protegido)

- `GET /api/peliculas`
- `POST /api/peliculas`
- `GET /api/peliculas/{id}`
- `PUT /api/peliculas/{id}`
- `DELETE /api/peliculas/{id}`

---

### Turnos (protegido)

- `GET /api/turnos`
- `POST /api/turnos`
- `GET /api/turnos/{id}`
- `PUT /api/turnos/{id}`
- `DELETE /api/turnos/{id}`

---

### Asignar turnos a película (protegido)

- `POST /api/peliculas/{pelicula}/turnos`

---

## 🧪 Pruebas de la API (Postman)

Se incluye una colección de **Postman** para probar todos los servicios internos
de la API REST (autenticación, películas, turnos y asignación de turnos).

📂 Ubicación del archivo:

### Uso rápido

1. Importar la colección en Postman
2. Ejecutar el endpoint **Login**
3. Copiar el token devuelto o usar la variable `token`
4. Probar los endpoints protegidos

Los endpoints protegidos utilizan autenticación **Bearer Token** mediante
Laravel Sanctum.

## 👤 Autor

**Henry Torres**  
Proyecto realizado como **prueba técnica Full Stack**

# 🎬 Cinema CRUD – Frontend

Frontend del sistema **Cinema CRUD**, desarrollado con **Vue 3 + Vite**, que permite gestionar películas, turnos y su asignación, con autenticación mediante **Laravel Sanctum**.

---

## 🚀 Tecnologías utilizadas

- ⚡ **Vue 3** (Composition API)
- ⚡ **Vite**
- 🧭 **Vue Router**
- 📦 **Pinia**
- 🌐 **Axios**
- 🎨 CSS puro (sin frameworks)

---

## 🔐 Funcionalidades

### Autenticación

- Registro de usuario
- Inicio de sesión
- Cierre de sesión
- Protección de rutas con token (Bearer)
- Persistencia de sesión con `localStorage`

### Películas

- Listar películas
- Crear película (con imagen)
- Editar película
- Eliminar película
- Asignar turnos a una película

### Turnos

- Listar turnos
- Crear turno
- Editar turno
- Eliminar turno

---

## ⚙️ Configuración del entorno

### 1️⃣ Variables de entorno

Crear un archivo `.env` en la raíz del frontend:

```env
VITE_API_URL=http://127.0.0.1:8000/api
```

---

## ▶️ Ejecutar el proyecto

```bash
npm install
npm run dev
```

La aplicación estará disponible en:

```
http://localhost:5173
```

---

## 🔗 Backend

Este frontend consume una API REST desarrollada en **Laravel**, con autenticación mediante **Sanctum**.

Rutas principales utilizadas:

- `POST /api/auth/register`
- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/auth/me`
- `GET /api/peliculas`
- `POST /api/peliculas`
- `PUT /api/peliculas/{id}`
- `DELETE /api/peliculas/{id}`
- `GET /api/turnos`
- `POST /api/turnos`
- `PUT /api/turnos/{id}`
- `DELETE /api/turnos/{id}`

---

## 🧠 Decisiones técnicas

- Separación de layout de autenticación y layout principal
- Uso de Pinia para manejo de sesión
- Manejo de validaciones en frontend y backend
- Normalización de formatos de hora

---

## 👤 Autor

**Henry Torres**  
Proyecto realizado como **prueba técnica Full Stack**

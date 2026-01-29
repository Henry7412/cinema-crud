<template>
  <div class="card">
    <div class="header">
      <h2>Películas</h2>
      <RouterLink class="btn" to="/movies/new">Nueva película</RouterLink>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>F. Publicación</th>
          <th>Estado</th>
          <th style="width: 160px;">Acciones</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="p in peliculas" :key="p.id">
          <td>{{ p.id }}</td>
          <td>
            <img v-if="p.imagen_url" :src="p.imagen_url" class="thumb" />
            <span v-else>-</span>
          </td>
          <td>{{ p.nombre }}</td>
          <td>{{ p.fecha_publicacion }}</td>
          <td>
            <span :class="p.estado ? 'pill on' : 'pill off'">
              {{ p.estado ? "Activo" : "Inactivo" }}
            </span>
          </td>
          <td class="actions">
            <RouterLink :to="`/movies/${p.id}/edit`" title="Editar">✏️</RouterLink>
            <RouterLink :to="`/movies/${p.id}/shifts`" title="Asignar turnos">🎟️</RouterLink>
            <button class="danger" @click="remove(p.id)" title="Eliminar">🗑️</button>
          </td>
        </tr>

        <tr v-if="!peliculas.length">
          <td colspan="6" class="empty">Sin películas registradas</td>
        </tr>
      </tbody>
    </table>

    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { getPeliculas, deletePelicula } from "../api/peliculas.api";

const peliculas = ref([]);
const error = ref("");

const load = async () => {
  error.value = "";
  try {
    peliculas.value = await getPeliculas();
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al cargar películas";
  }
};

const remove = async (id) => {
  if (!confirm("¿Eliminar película?")) return;
  error.value = "";
  try {
    await deletePelicula(id);
    await load();
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al eliminar";
  }
};

onMounted(load);
</script>

<style scoped>
.card{ 
  background:#fff; 
  border-radius:16px; 
  padding:20px; }

.header{ 
  display:flex; 
  justify-content:space-between; 
  align-items:center; 
}

.btn{ 
  background:#111; 
  color:#fff; 
  padding:8px 12px; 
  border-radius:8px; 
  text-decoration:none; 
}

.table{ 
  width:100%; 
  margin-top:14px; 
  border-collapse:collapse; 
}

th,td{ 
  padding:10px; 
  border-top:1px solid #eee; 
  text-align:left; 
}

.actions{ 
  display:flex; 
  gap:10px; 
  align-items:center; 
}

button{ border:none; background:transparent; cursor:pointer; }

.danger{ color:#c0392b; }

.thumb{ 
  width:44px; 
  height:44px; 
  object-fit:cover; 
  border-radius:8px; 
  border:1px solid #eee; 
}

.pill{ 
  padding:4px 10px; 
  border-radius:999px; 
  font-size:12px; 
}

.on{ 
  background:#e9fbef; 
  color:#0a7a2a; 
}

.off{ 
  background:#fdecec; 
  color:#b32525; 
}

.empty{ 
  text-align:center; 
  color:#777; 
  padding:18px; 
}

.error{
  margin-top:12px;
  background:#fdecec; color:#b32525;
  padding:10px 12px; border-radius:10px; border:1px solid #f5c2c2;
}
</style>

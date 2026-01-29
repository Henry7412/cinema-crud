<template>
  <div class="card">
    <div class="header">
      <h2>Asignar Turnos</h2>
      <RouterLink class="btn ghost" to="/movies">Volver</RouterLink>
    </div>

    <p class="subtitle" v-if="pelicula">
      Película: <b>{{ pelicula.nombre }}</b>
    </p>

    <p v-if="error" class="error">{{ error }}</p>

    <div v-if="loading">Cargando...</div>

    <div v-else class="grid">
      <div class="box">
        <h3>Turnos disponibles</h3>

        <div class="list">
          <label v-for="t in turnos" :key="t.id" class="item">
            <input type="checkbox" :value="t.id" v-model="selectedIds" />
            <span>{{ t.hora }}</span>
            <small :class="t.estado ? 'on' : 'off'">
              {{ t.estado ? "Activo" : "Inactivo" }}
            </small>
          </label>
        </div>

        <button class="btn" @click="save" :disabled="saving">
          {{ saving ? "Guardando..." : "Guardar" }}
        </button>
      </div>

      <div class="box">
        <h3>Asignados</h3>
        <ul class="ul">
          <li v-for="t in assigned" :key="t.id">
            {{ t.hora }} — {{ t.estado ? "Activo" : "Inactivo" }}
          </li>
          <li v-if="!assigned.length" class="muted">No hay turnos asignados</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { getPelicula } from "../api/peliculas.api";
import { getTurnos } from "../api/turnos.api";
import { assignTurnosToPelicula } from "../api/peliculaTurnos.api";

const route = useRoute();
const peliculaId = computed(() => Number(route.params.id));

const loading = ref(true);
const saving = ref(false);
const error = ref("");

const pelicula = ref(null);
const turnos = ref([]);
const selectedIds = ref([]);

const assigned = computed(() => {
  const set = new Set(selectedIds.value);
  return turnos.value.filter((t) => set.has(t.id));
});

const load = async () => {
  loading.value = true;
  error.value = "";
  try {
    const [p, ts] = await Promise.all([
      getPelicula(peliculaId.value),
      getTurnos(),
    ]);

    pelicula.value = p;
    turnos.value = ts;

    const already = Array.isArray(p?.turnos) ? p.turnos.map((t) => t.id) : [];
    selectedIds.value = already;
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al cargar datos";
  } finally {
    loading.value = false;
  }
};

const save = async () => {
  saving.value = true;
  error.value = "";
  try {
    await assignTurnosToPelicula(peliculaId.value, selectedIds.value);
    await load();
    alert("Turnos asignados ✅");
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al guardar asignación";
  } finally {
    saving.value = false;
  }
};

onMounted(load);
</script>

<style scoped>
.card{ 
  background:#fff; 
  border-radius:16px; 
  padding:20px; 
}

.header{ 
  display:flex; 
  justify-content:space-between; 
  align-items:center; 
}

.btn{ 
  background:#111; 
  color:#fff; 
  padding:10px 14px; 
  border-radius:8px; 
  border:none; 
  cursor:pointer; 
  text-decoration:none; 
}

.ghost{ 
  background:#fff; 
  color:#111; 
  border:1px solid #ddd; 
}

.subtitle{ 
  margin-top:10px; 
  color:#333; 
}

.grid{ 
  display:grid; 
  grid-template-columns: 1fr 1fr; gap:14px; 
  margin-top:12px; 
}

.box{ 
  border:1px solid #eee; 
  border-radius:12px; 
  padding:12px; 
}

.list{ 
  display:grid; 
  gap:10px; 
  margin:10px 0 14px; 
  max-height:360px; 
  overflow:auto; 
  padding-right:6px; 
}
.item{ 
  display:flex; 
  align-items:center; 
  gap:10px; 
  border:1px solid #f0f0f0; 
  padding:10px; 
  border-radius:10px; 
}

.item small{ 
  margin-left:auto; 
  padding:4px 8px; 
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

.ul{ 
  margin:10px 0 0; 
  padding-left:18px; 
}
.muted{ color:#777; }
.error{
  margin-top:12px;
  background:#fdecec; color:#b32525;
  padding:10px 12px; border-radius:10px; border:1px solid #f5c2c2;
}
</style>

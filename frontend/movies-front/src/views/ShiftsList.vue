<template>
  <div class="card">
    <div class="header">
      <h2>Turnos</h2>
      <RouterLink class="btn" to="/shifts/new">Nuevo turno</RouterLink>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Hora</th>
          <th>Estado</th>
          <th style="width: 140px;">Acciones</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="t in turnos" :key="t.id">
          <td>{{ t.id }}</td>
          <td>{{ t.hora }}</td>
          <td>
            <span :class="t.estado ? 'pill on' : 'pill off'">
              {{ t.estado ? "Activo" : "Inactivo" }}
            </span>
          </td>
          <td class="actions">
            <RouterLink :to="`/shifts/${t.id}/edit`">✏️</RouterLink>
            <button class="danger" @click="remove(t.id)">🗑️</button>
          </td>
        </tr>

        <tr v-if="!turnos.length">
          <td colspan="4" class="empty">Sin turnos registrados</td>
        </tr>
      </tbody>
    </table>

    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { getTurnos, deleteTurno } from "../api/turnos.api";

const turnos = ref([]);
const error = ref("");

const load = async () => {
  error.value = "";
  try {
    turnos.value = await getTurnos();
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al cargar turnos";
  }
};

const remove = async (id) => {
  if (!confirm("¿Eliminar turno?")) return;
  error.value = "";
  try {
    await deleteTurno(id);
    await load();
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al eliminar turno";
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

.header{ display:flex; 
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

button{ 
  border:none; 
  background:transparent; 
  cursor:pointer; 
}

.danger{ color:#c0392b; }

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
  color:#777; padding:18px; 
}

.error{
  margin-top:12px;
  background:#fdecec; color:#b32525;
  padding:10px 12px; border-radius:10px; border:1px solid #f5c2c2;
}
</style>

<template>
  <div class="card">
    <h2>{{ isEdit ? "Editar Turno" : "Formulario Turno" }}</h2>
    <p v-if="error" class="error">{{ error }}</p>

    <form class="form" @submit.prevent="submit">
      <label>
        Hora
        <input type="time" v-model="form.hora" required />
      </label>

      <label class="check">
        <input type="checkbox" v-model="form.estado" />
        Activo
      </label>

      <div class="actions">
        <RouterLink to="/shifts" class="btn ghost">Cancelar</RouterLink>
        <button class="btn" type="submit" :disabled="saving">
          {{ saving ? "Guardando..." : "Guardar" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { createTurno, getTurno, updateTurno } from "../api/turnos.api";

const router = useRouter();
const route = useRoute();

const id = computed(() => Number(route.params.id));
const isEdit = computed(() => Number.isFinite(id.value) && id.value > 0);

const saving = ref(false);
const error = ref("");

const toHHMM = (v) => (v ? String(v).slice(0, 5) : "");

const form = reactive({
  hora: "15:00",
  estado: true,
});

const load = async () => {
  if (!isEdit.value) return;
  error.value = "";
  try {
    const t = await getTurno(id.value);
    form.hora = toHHMM(t.hora) || "15:00";
    form.estado = !!t.estado;
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al cargar turno";
  }
};

const submit = async () => {
  saving.value = true;
  error.value = "";
  try {
    const payload = {
      hora: toHHMM(form.hora),
      estado: form.estado,
    };

    if (isEdit.value) await updateTurno(id.value, payload);
    else await createTurno(payload);

    router.push("/shifts");
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al guardar turno";
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
  max-width:600px; 
}

.form{ 
  display:grid; 
  gap:14px; margin-top:10px; 
}

input{ 
  padding:10px; 
  border-radius:8px; 
  border:1px solid #ddd; 
}

.check{ 
  display:flex; 
  align-items:center; 
  gap:8px; 
}

.actions{ 
  display:flex; 
  justify-content:flex-end; 
  gap:10px; 
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

.error{ 
  margin-top:12px; 
  background:#fdecec; 
  color:#b32525; 
  padding:10px 12px; 
  border-radius:10px; 
  border:1px solid #f5c2c2; 
  }
</style>

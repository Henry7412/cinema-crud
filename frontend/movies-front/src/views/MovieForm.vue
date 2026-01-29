<template>
  <div class="card">
    <h2>{{ isEdit ? "Editar Película" : "Formulario Película" }}</h2>

    <p v-if="error" class="error">{{ error }}</p>

    <form class="form" @submit.prevent="submit">
      <label>
        Nombre
        <input v-model="form.nombre" required />
      </label>

      <label>
        Fecha de publicación
        <input type="date" v-model="form.fecha_publicacion" required />
      </label>

      <label>
        Imagen
        <input type="file" accept="image/*" @change="onFile" />
      </label>

      <div v-if="previewUrl" class="preview">
        <img :src="previewUrl" class="img" />
      </div>

      <label class="check">
        <input type="checkbox" v-model="form.estado" />
        Activo
      </label>

      <div class="actions">
        <RouterLink to="/movies" class="btn ghost">Cancelar</RouterLink>
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
import { createPelicula, getPelicula, updatePelicula } from "../api/peliculas.api";

const router = useRouter();
const route = useRoute();

const id = computed(() => Number(route.params.id));
const isEdit = computed(() => Number.isFinite(id.value) && id.value > 0);

const saving = ref(false);
const error = ref("");

const previewUrl = ref(null);

const form = reactive({
  nombre: "",
  fecha_publicacion: "",
  estado: true,
  imagen: null,
});

const onFile = (e) => {
  const file = e.target.files?.[0] ?? null;
  form.imagen = file;
  previewUrl.value = file ? URL.createObjectURL(file) : null;
};

const load = async () => {
  if (!isEdit.value) return;
  error.value = "";
  try {
    const p = await getPelicula(id.value);
    form.nombre = p.nombre ?? "";
    form.fecha_publicacion = p.fecha_publicacion ?? "";
    form.estado = !!p.estado;
    previewUrl.value = p.imagen_url ?? null;
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al cargar película";
  }
};

const submit = async () => {
  saving.value = true;
  error.value = "";

  try {
    const data = new FormData();
    data.append("nombre", form.nombre);
    data.append("fecha_publicacion", form.fecha_publicacion);
    data.append("estado", form.estado ? "1" : "0");
    if (form.imagen) data.append("imagen", form.imagen);

    if (isEdit.value) await updatePelicula(id.value, data);
    else await createPelicula(data);

    router.push("/movies");
  } catch (e) {
    console.error(e);
    error.value =
      e?.response?.data?.message ||
      JSON.stringify(e?.response?.data || {}) ||
      e?.message ||
      "Error al guardar";
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
  gap:14px; 
  margin-top:10px; 
}

input{ 
  padding:10px; 
  border-radius:8px; 
  border:1px solid #ddd; 
}

.check{ 
  display:flex; 
  align-items:center; 
  gap:8px; }

.actions{ 
  display:flex; 
  justify-content:flex-end; 
  gap:10px; }

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

.preview{ margin-top:6px; }

.img{ 
  width:140px; 
  height:140px; 
  object-fit:cover; 
  border-radius:12px; 
  border:1px solid #eee; 
}
.error{
  margin-top:12px;
  background:#fdecec; color:#b32525;
  padding:10px 12px; border-radius:10px; border:1px solid #f5c2c2;
}
</style>

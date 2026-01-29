<template>
  <div class="auth-card">
    <h2 class="auth-title">Iniciar sesión</h2>

    <p v-if="error" class="auth-error">{{ error }}</p>

    <form class="auth-form" @submit.prevent="submit">
      <div class="form-row">
        <label>Email</label>
        <input type="email" v-model="email" required />
      </div>

      <div class="form-row">
        <label>Password</label>
        <input type="password" v-model="password" required />
      </div>

      <div class="auth-actions">
        <RouterLink to="/register" class="btn-ghost">
          Crear cuenta
        </RouterLink>
        <button class="btn-primary" type="submit">
          Ingresar
        </button>
      </div>
    </form>
  </div>
</template>


<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth.store";

const router = useRouter();
const auth = useAuthStore();

const email = ref("");
const password = ref("");

const submit = async () => {
  const ok = await auth.login({ email: email.value, password: password.value });
  if (ok) router.push("/movies");
};
</script>

<style scoped>
.card{
  background:#fff;
  border-radius:18px;
  padding:28px;
  width:100%;
  max-width:420px;
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
    border:none; cursor:pointer; 
    text-decoration:none; 
}

.ghost{ 
    background:#fff; 
    color:#111; 
    border:1px solid #ddd; 
}
.error{
  margin-top:12px;
  background:#fdecec; color:#b32525;
  padding:10px 12px; border-radius:10px; border:1px solid #f5c2c2;
}
</style>

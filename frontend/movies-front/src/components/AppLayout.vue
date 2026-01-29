<template>
  <div class="app">
    <header class="topbar">
      <div class="brand">🎬 Cine CRUD</div>

      <nav class="nav" v-if="auth.isLoggedIn">
        <RouterLink to="/movies">Películas</RouterLink>
        <RouterLink to="/shifts">Turnos</RouterLink>

        <span class="user" v-if="auth.user">👤 {{ auth.user.name }}</span>
        <button class="logout" @click="doLogout">Salir</button>
      </nav>

      <nav class="nav" v-else>
        <RouterLink to="/login">Login</RouterLink>
        <RouterLink to="/register">Registro</RouterLink>
      </nav>
    </header>

    <main :class="isAuthRoute ? 'auth-main' : 'container'">
      <slot ></slot>
    </main>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth.store";

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();

const isAuthRoute = computed(() => {
  return route.path === "/login" || route.path === "/register";
});

onMounted(() => auth.fetchMe());

const doLogout = async () => {
  await auth.logout();
  router.push("/login");
};
</script>

<style scoped>
.app {
  min-height: 100vh;
  background: #f6f7fb;
}

.topbar {
  height: 64px;
  background: #fff;
  border-bottom: 1px solid #eee;
  padding: 0 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.brand {
  font-weight: 800;
}

.nav a {
  margin-left: 12px;
  text-decoration: none;
  color: #333;
}
.nav a.router-link-active {
  font-weight: 700;
}

.user {
  margin-left: 14px;
  color: #333;
  font-size: 14px;
}

.logout {
  margin-left: 12px;
  border: 1px solid #ddd;
  background: #fff;
  border-radius: 8px;
  padding: 8px 10px;
  cursor: pointer;
}

.container {
  padding: 18px;
  max-width: 1100px;
  margin: 0 auto;
}

.auth-main {
  min-height: calc(100vh - 64px); 
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
}
</style>

import { createRouter, createWebHistory } from "vue-router";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";

import MoviesList from "../views/MoviesList.vue";
import MovieForm from "../views/MovieForm.vue";
import ShiftsList from "../views/ShiftsList.vue";
import ShiftForm from "../views/ShiftForm.vue";
import MovieShifts from "../views/MovieShifts.vue";

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", redirect: "/movies" },

    { path: "/login", component: Login },
    { path: "/register", component: Register },

    { path: "/movies", component: MoviesList, meta: { requiresAuth: true } },
    { path: "/movies/new", component: MovieForm, meta: { requiresAuth: true } },
    { path: "/movies/:id/edit", component: MovieForm, meta: { requiresAuth: true } },
    { path: "/movies/:id/shifts", component: MovieShifts, meta: { requiresAuth: true } },

    { path: "/shifts", component: ShiftsList, meta: { requiresAuth: true } },
    { path: "/shifts/new", component: ShiftForm, meta: { requiresAuth: true } },
    { path: "/shifts/:id/edit", component: ShiftForm, meta: { requiresAuth: true } },
  ],
});

router.beforeEach(async (to) => {
  const token = localStorage.getItem("cine_token");

  if (to.meta.requiresAuth && !token) return "/login";

  if ((to.path === "/login" || to.path === "/register") && token) return "/movies";

  return true;
});

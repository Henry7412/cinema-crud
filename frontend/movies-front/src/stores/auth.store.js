import { defineStore } from "pinia";
import { loginApi, logoutApi, meApi, registerApi } from "../api/auth.api";

const TOKEN_KEY = "cine_token";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem(TOKEN_KEY) || "",
    loading: false,
    error: "",
  }),

  getters: {
    isLoggedIn: (s) => !!s.token,
  },

  actions: {
    setToken(token) {
      this.token = token || "";
      if (this.token) localStorage.setItem(TOKEN_KEY, this.token);
      else localStorage.removeItem(TOKEN_KEY);
    },

    async register(payload) {
      this.loading = true;
      this.error = "";
      try {
        const { user, token } = await registerApi(payload);
        this.user = user;
        this.setToken(token);
        return true;
      } catch (e) {
        this.error =
          e?.response?.data?.message ||
          JSON.stringify(e?.response?.data || {}) ||
          e?.message ||
          "Error al registrarse";
        return false;
      } finally {
        this.loading = false;
      }
    },

    async login(payload) {
      this.loading = true;
      this.error = "";
      try {
        const { user, token } = await loginApi(payload);
        this.user = user;
        this.setToken(token);
        return true;
      } catch (e) {
        this.error =
          e?.response?.data?.message ||
          JSON.stringify(e?.response?.data || {}) ||
          e?.message ||
          "Error al iniciar sesión";
        return false;
      } finally {
        this.loading = false;
      }
    },

    async fetchMe() {
      if (!this.token) return null;
      try {
        this.user = await meApi();
        return this.user;
      } catch (_) {
        this.user = null;
        this.setToken("");
        return null;
      }
    },

    async logout() {
      try {
        if (this.token) await logoutApi();
      } catch (_) {
      } finally {
        this.user = null;
        this.setToken("");
      }
    },
  },
});

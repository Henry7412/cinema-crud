import { http } from "./http";

export const getTurnos = async () => {
  const { data } = await http.get("/turnos");
  return data;
};

export const getTurno = async (id) => {
  const { data } = await http.get(`/turnos/${id}`);
  return data;
};

export const createTurno = async (payload) => {
  const { data } = await http.post("/turnos", payload);
  return data;
};

export const updateTurno = async (id, payload) => {
  const { data } = await http.put(`/turnos/${id}`, payload);
  return data;
};

export const deleteTurno = async (id) => {
  const { data } = await http.delete(`/turnos/${id}`);
  return data;
};

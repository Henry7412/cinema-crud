import { http } from "./http";

export const getPeliculas = async () => {
  const { data } = await http.get("/peliculas");
  return data;
};

export const getPelicula = async (id) => {
  const { data } = await http.get(`/peliculas/${id}`);
  return data;
};

export const createPelicula = async (formData) => {
  const { data } = await http.post("/peliculas", formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });
  return data;
};

export const updatePelicula = async (id, formData) => {
  formData.append("_method", "PUT");

  const { data } = await http.post(`/peliculas/${id}`, formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });
  return data;
};

export const deletePelicula = async (id) => {
  const { data } = await http.delete(`/peliculas/${id}`);
  return data;
};

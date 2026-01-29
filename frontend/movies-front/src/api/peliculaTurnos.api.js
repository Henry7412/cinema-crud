import { http } from "./http";

export const assignTurnosToPelicula = async (peliculaId, turnoIds) => {
  const { data } = await http.post(`/peliculas/${peliculaId}/turnos`, {
    turno_ids: turnoIds,
  });
  return data;
};

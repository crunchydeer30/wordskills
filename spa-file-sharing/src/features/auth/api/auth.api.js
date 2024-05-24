import api from "../../../config/axios";

const login = async (credentials) => {
  const response = await api.post("/login", credentials);
  return response.data;
};

const register = async (credentials) => {
  const response = await api.post("/register", credentials);
  return response.data;
};

export default {
  login,
  register
}
import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost:8000/api",
  // baseURL: "http://172.20.7.46/",
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
    Authorization: `Bearer ${localStorage.getItem("token") || ""}`,
  },
  transformRequest: (data, headers) => {
    headers["Authorization"] = `Bearer ${localStorage.getItem("token") || ""}`;

    if (typeof data === "object") {
      return JSON.stringify(data);
    }
  },
});

export default api;

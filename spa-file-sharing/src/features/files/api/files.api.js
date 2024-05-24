import api from "../../../config/axios";

const disk = async () => {
  const response = await api.get("/files/disk");
  return response.data;
};

const remove = async (file_id) => {
  const response = await api.delete(`/files/${file_id}`);
  return response.data;
};

const update = async (file_id, data) => {
  const response = await api.patch(`/files/${file_id}`, data);
  return response.data;
};

const grantAccess = async (file_id, data) => {
  const response = await api.post(`/files/${file_id}/access`, data);
  return response.data;
};

const revokeAccess = async (file_id, data) => {
  const response = await api.delete(`/files/${file_id}/access`, {
    data,
  });
  return response.data;
};

const shared = async () => {
  const response = await api.get(`/files/shared`);
  return response.data;
};

const download = async (file_id) => {
  const response = await api.get(`/files/${file_id}`, {
    responseType: "blob",
  });
  return response.data;
};

const upload = async (data) => {
  console.log(data);
  const response = await api.post(`/files`, data, {
    headers: {
      "Content-Type": `multipart/form-data`,
    },
  });
  return response.data;
};

export default {
  disk,
  remove,
  update,
  grantAccess,
  revokeAccess,
  shared,
  download,
  upload,
};

import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useRevokeAccess = () => {
  const { dispatch } = useDisk();

  const revokeAccess = async (file_id, data) => {
    try {
      const accesses = await filesApi.revokeAccess(file_id, data);
      dispatch({
        type: "file/accesses/updated",
        payload: { file_id, accesses },
      });
      alert("Access revoked");
    } catch (e) {
      console.log(e);
      alert(e.message);
    }
  };

  return { revokeAccess };
};

export default useRevokeAccess;

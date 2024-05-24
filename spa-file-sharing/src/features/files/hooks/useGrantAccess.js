import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useGrantAccess = () => {
  const { dispatch } = useDisk();

  const grantAccess = async (file_id, data) => {
    try {
      const accesses = await filesApi.grantAccess(file_id, data);
      dispatch({
        type: "file/accesses/updated",
        payload: { file_id, accesses },
      });
      alert("Access granted");
    } catch (e) {
      console.log(e);
      alert(e.message);
    }
  };

  return { grantAccess };
};

export default useGrantAccess;

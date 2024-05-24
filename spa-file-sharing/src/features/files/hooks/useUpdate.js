import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useUpdate = () => {
  const { dispatch } = useDisk();

  const update = async (file_id, data) => {
    try {
      await filesApi.update(file_id, data);
      dispatch({ type: "file/updated", payload: file_id });
      alert("File updated");
    } catch (e) {
      console.log(e);
      alert(e.message);
    }
  };

  return { update };
};

export default useUpdate;

import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useRemove = () => {
  const { dispatch } = useDisk();

  const remove = async (file_id) => {
    try {
      await filesApi.remove(file_id);
      dispatch({ type: "file/removed", payload: file_id });
    } catch (e) {
      console.log(e);
      alert(e.message);
    }
  };

  return { remove };
};

export default useRemove;

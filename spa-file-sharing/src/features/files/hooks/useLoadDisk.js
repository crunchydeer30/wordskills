import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useLoadDisk = () => {
  const { dispatch } = useDisk();

  const load = async () => {
    try {
      const files = await filesApi.disk();
      dispatch({ type: "files/loaded", payload: files });
    } catch (e) {
      console.log(e);
    }
  };

  return { load };
};

export default useLoadDisk;

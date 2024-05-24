import { AxiosError } from "axios";
import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useLoadDisk = () => {
  const { dispatch } = useDisk();

  const load = async () => {
    try {
      const files = await filesApi.disk();
      dispatch({ type: "files/loaded", payload: files });
    } catch (e) {
      if (e instanceof AxiosError && e.status === 403) {
        dispatch({ type: "files/loaded", payload: [] });
      } else {
        console.log(e);
        alert(e.message);
      }
    }
  };

  return { load };
};

export default useLoadDisk;

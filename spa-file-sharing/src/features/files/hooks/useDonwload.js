import { AxiosError } from "axios";
import filesApi from "../api/files.api";
import { useDisk } from "../context/DiskContext";

const useDownload = () => {
  const { dispatch } = useDisk();

  const download = async (file_id) => {
    try {
      const file = await filesApi.download(file_id);
      const href = URL.createObjectURL(file);
      const link = document.createElement("a");
      link.href = href;
      link.setAttribute("donwload", "file");
      document.body.append(link);
      link.click();

      document.body.removeChild(link);
      URL.revokeObjectURL(href);
    } catch (e) {
      if (e instanceof AxiosError && e.status === 403) {
        dispatch({ type: "files/loaded", payload: [] });
      } else {
        console.log(e);
        alert(e.message);
      }
    }
  };

  return { download };
};

export default useDownload;

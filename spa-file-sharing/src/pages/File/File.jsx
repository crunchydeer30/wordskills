import "./File.css";
import FormEditFile from "../../features/files/components/FormEditFile";
import { useParams } from "react-router-dom";
import { useDisk } from "../../features/files/context/DiskContext";

const File = () => {
  const { file_id } = useParams();
  const { files } = useDisk();
  const file = files.find((file) => file.file_id == file_id);

  if (!file) {
    return <h1>File not found</h1>;
  }

  return (
    <div id="file">
      <FormEditFile file={file} />
    </div>
  );
};

export default File;

import "./Accesses.css";
import { useParams } from "react-router-dom";
import { useDisk } from "../../features/files/context/DiskContext";
import AccessItem from "../../features/files/components/AccessItem";
import FormGrantAccess from "../../features/files/components/FormGrantAccess";
import { Link } from "react-router-dom";

const Accesses = () => {
  const { file_id } = useParams();
  const { files } = useDisk();
  const file = files.find((file) => file.file_id == file_id);

  if (!file) {
    return <h1>File not found</h1>;
  }

  return (
    <div id="accesses">
      <section className="accessRight">
        <h2>Настройка доступа к файлам</h2>
        <FormGrantAccess file={file} />
        <section className="userList">
          {file.accesses.map((user) => (
            <AccessItem key={user.email} file_id={file.file_id} user={user} />
          ))}
        </section>
        <Link to="/files/disk" className="back">
          Назад
        </Link>
      </section>
    </div>
  );
};

export default Accesses;

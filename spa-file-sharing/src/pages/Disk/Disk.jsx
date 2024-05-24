import "./Disk.css";
import useLoadDisk from "../../features/files/hooks/useLoadDisk";
import { useEffect } from "react";
import { useDisk } from "../../features/files/context/DiskContext";
import DiskFile from "../../features/files/components/DiskFile";
import { useNavigate } from "react-router-dom";

const Disk = () => {
  const { files, isLoading } = useDisk();
  const { load } = useLoadDisk();
  const navigate = useNavigate();

  useEffect(() => {
    load();
  }, []);

  return (
    <div id="disk">
      <header>
        <nav>
          <button onClick={() => navigate("/files/disk")}>Мои файлы</button>
          <button onClick={() => navigate("/files/shared")}>
            Файлы доступные мне
          </button>
        </nav>
        <button onClick={() => navigate("/files/upload")}>
          Загрузить файл
        </button>
      </header>
      <main>
        <h1>Мои файлы</h1>
        <section className="folders">
          {isLoading && <span className="loader"></span>}
          {!files.length && !isLoading && <h1>Нет файлов</h1>}
          {files.map((file) => (
            <DiskFile key={file.file_id} file={file} />
          ))}
        </section>
      </main>
      <footer>
        <p>
          Макет создан для использование на чемпионате Молодые профессионалы
        </p>
      </footer>
    </div>
  );
};

export default Disk;

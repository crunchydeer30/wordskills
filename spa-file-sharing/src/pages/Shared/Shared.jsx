import "../Disk/Disk.css";
import { useNavigate } from "react-router-dom";
import { useShared } from "../../features/files/context/SharedContext";
import SharedFile from "../../features/files/components/SharedFile";

const Shared = () => {
  const navigate = useNavigate();
  const { files, isLoading } = useShared();

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
            <SharedFile key={file.file_id} file={file} />
          ))}
        </section>
      </main>
      <footer>
        <p>
          Макет создан для использование на чемпионате "Молодын профессионалы"
        </p>
      </footer>
    </div>
  );
};

export default Shared;

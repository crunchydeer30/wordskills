import "./Upload.css";
import { Link } from "react-router-dom";
import { useState } from "react";
import axios from "axios";
import UploadedFile from "../../features/files/components/UploadedFile";

const Upload = () => {
  const [uploadedFiles, setUploadedFiles] = useState([]);

  const submit = async (e) => {
    e.preventDefault();

    const formData = new FormData();
    for (let i = 0; i < e.target.files.length; i++) {
      formData.append(i, e.target.files[i]);
    }

    console.log(formData);

    try {
      const response = await axios.post(
        "http://localhost:8000/api/files",
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        }
      );
      setUploadedFiles(uploadedFiles.concat(response.data));
    } catch (e) {
      alert("Error while uploading files");
      console.log(e);
    }
  }


  return (
    <div id="upload">
      <section className="uploadFiles">
        <h2>Загрузка файлов</h2>
        <section className="formAdd" onSubmit={submit}>
          <form action="">
            <label htmlFor="uploadFile" className="uploadButton">
              Загрузить
            </label>
            <input
              type="file"
              multiple
              hidden=""
              id="uploadFile"
              // onChange={(e) => setFiles(e.target.files)}
              onChange={(e) => submit(e)}
            />
            <input type="submit" value="Добавить в список" />
          </form>
        </section>
        <section className="uploadedFiles">
          {uploadedFiles.map((file) => (
            <UploadedFile file={file} key={file.url} />
          ))}
        </section>
        <Link to="/" className="back">
          Назад
        </Link>
      </section>
    </div>
  );
};

export default Upload;

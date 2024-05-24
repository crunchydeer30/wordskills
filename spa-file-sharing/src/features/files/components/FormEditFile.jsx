/* eslint-disable react/prop-types */
import { useState } from "react";
import useUpdate from "../hooks/useUpdate";
import { Link } from "react-router-dom";

const FormEditFile = ({ file }) => {
  const [name, setName] = useState("");
  const { update } = useUpdate();

  const handleSubmit = (e) => {
    e.preventDefault();
    update(file.file_id, { name });
  };

  return (
    <form className="form signUp" onSubmit={handleSubmit}>
      <h3 className="title form">Изменение файла</h3>

      <label htmlFor="name">Название</label>
      <input
        type="text"
        id="name"
        placeholder="Название"
        required
        value={name}
        onChange={(e) => setName(e.target.value)}
      />

      <input type="submit" value="Изменить" />
      <Link to="/">X</Link>
    </form>
  );
};

export default FormEditFile;

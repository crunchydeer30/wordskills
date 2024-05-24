/* eslint-disable react/prop-types */
import { useState } from "react";
import useGrantAccess from "../hooks/useGrantAccess";

const FormGrantAccess = ({ file }) => {
  const [email, setEmail] = useState("");
  const { grantAccess } = useGrantAccess();

  const handleSubmit = (e) => {
    e.preventDefault();
    grantAccess(file.file_id, { email });
  };

  return (
    <section className="formAdd">
      <form onSubmit={handleSubmit}>
        <input
          type="email"
          placeholder="Эл. почта пользователя"
          required
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input type="submit" value="Добавить в список" />
      </form>
    </section>
  );
};

export default FormGrantAccess;

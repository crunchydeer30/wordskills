import { useState } from "react";
import useRegister from "../hooks/useRegister";
import { Link } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const RegisterForm = () => {
  const [creds, setCreds] = useState({
    first_name: "",
    last_name: "",
    email: "",
    password: "",
  });
  const { register } = useRegister();
  const { validation_errors } = useAuth();

  const handleSubmit = (e) => {
    e.preventDefault();
    register(creds);
  };

  return (
    <form className="form signUp" onSubmit={handleSubmit}>
      <h3 className="title form">Регистрация</h3>

      <label htmlFor="name">Имя</label>
      <input
        type="text"
        id="name"
        placeholder="Имя"
        required
        value={creds.first_name}
        onChange={(e) => setCreds({ ...creds, first_name: e.target.value })}
        className={validation_errors?.first_name ? "input-invalid" : null}
      />
      {validation_errors?.first_name && (
        <p className="failure">{validation_errors.first_name[0]}</p>
      )}

      <label htmlFor="surname">Фамилия</label>
      <input
        type="text"
        id="surname"
        placeholder="Фамилия"
        required
        value={creds.last_name}
        onChange={(e) => setCreds({ ...creds, last_name: e.target.value })}
        className={validation_errors?.last_name ? "input-invalid" : null}
      />
      {validation_errors?.last_name && (
        <p className="failure">{validation_errors.last_name[0]}</p>
      )}

      <label htmlFor="email">Эл. почта</label>
      <input
        type="email"
        id="email"
        placeholder="Эл. почта"
        required
        value={creds.email}
        onChange={(e) => setCreds({ ...creds, email: e.target.value })}
        className={validation_errors?.email ? "input-invalid" : null}
      />
      {validation_errors?.email && (
        <p className="failure">{validation_errors.email[0]}</p>
      )}

      <label htmlFor="password">Пароль</label>
      <input
        type="password"
        id="password"
        placeholder="Пароль"
        required
        value={creds.password}
        onChange={(e) => setCreds({ ...creds, password: e.target.value })}
        className={validation_errors?.password ? "input-invalid" : null}
      />
      {validation_errors?.password && (
        <p className="failure">{validation_errors.password[0]}</p>
      )}

      <div>
        <input type="checkbox" id="confirm" required />
        <label htmlFor="confirm">Согласие с правами потребителя</label>
      </div>
      <input type="submit" value="Регистрация" />
      <Link to="/login">У вас уже есть аккаунт?</Link>
    </form>
  );
};

export default RegisterForm;

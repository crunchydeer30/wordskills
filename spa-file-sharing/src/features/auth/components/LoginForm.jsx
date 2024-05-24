import useLogin from "../hooks/useLogin";
import { useState } from "react";
import { Link } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

const LoginForm = () => {
  const [creds, setCreds] = useState({ email: "", password: "" });
  const { login } = useLogin();
  const { validation_errors } = useAuth();

  console.log(validation_errors.email);


  const handleSubmit = (e) => {
    e.preventDefault();
    try {
      login(creds);
    } catch (e) {
      console.log(e);
    }
  };

  return (
    <form className="form signUp" onSubmit={handleSubmit}>
      <h3 className="title form">Авторизация</h3>

      <label htmlFor="email">Эл. почта</label>
      <input
        type="email"
        id="email"
        placeholder="Эл. почта"
        value={creds.email}
        required
        className={validation_errors?.email ? "input-invalid" : null}
        onChange={(e) => setCreds({ ...creds, email: e.target.value })}
      />
      {validation_errors?.email && <p className="failure">{validation_errors?.email[0]}</p>}

      <label htmlFor="password">Пароль</label>
      <input
        type="password"
        id="password"
        placeholder="Пароль"
        value={creds.password}
        required
        className={validation_errors?.email ? "input-invalid" : null}
        onChange={(e) => setCreds({ ...creds, password: e.target.value })}
      />
      {validation_errors?.password && <p className="failure">{validation_errors?.password[0]}</p>}

      <input type="submit" value="Авторизация" />
      <Link to="/register">Регистрация</Link>
    </form>
  );
};

export default LoginForm;

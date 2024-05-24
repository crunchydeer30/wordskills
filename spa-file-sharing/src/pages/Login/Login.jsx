import LoginForm from "../../features/auth/components/LoginForm";
import "./Login.css";
import { useResetErrors } from "../../features/auth/context/AuthContext";

const Login = () => {
  useResetErrors();

  return (
    <div id="login">
      <LoginForm />
    </div>
  );
};

export default Login;

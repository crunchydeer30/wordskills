import RegisterForm from "../../features/auth/components/RegisterForm";
import "./Register.css";
import { useResetErrors } from "../../features/auth/context/AuthContext";

const Register = () => {
  useResetErrors();

  return (
    <div id="register">
      <RegisterForm />
    </div>
  );
};

export default Register;

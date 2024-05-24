import { useAuth } from "../context/AuthContext";
import authApi from "../api/auth.api";
import formatErrorMessage from "../../../utils/formatErrorMessage";
import { useNavigate } from "react-router-dom";
import { AxiosError } from "axios";

const useLogin = () => {
  const { dispatch } = useAuth();
  const navigate = useNavigate();

  const login = async (credentials) => {
    try {
      const response = await authApi.login(credentials);
      dispatch({ type: "login", payload: response });
      localStorage.setItem("token", response.token);
      navigate("/");
    } catch (error) {
      alert(formatErrorMessage(error.message));
      if (error instanceof AxiosError && error.response.status === 422) {
        dispatch({ type: "login/error", payload: error.response.data.message });
      }
    }
  };

  return { login };
};

export default useLogin;

import { useAuth } from "../context/AuthContext";
import authApi from "../api/auth.api";
import formatErrorMessage from "../../../utils/formatErrorMessage";
import { useNavigate } from "react-router-dom";
import { AxiosError } from "axios";

const useRegister = () => {
  const { dispatch } = useAuth();
  const navigate = useNavigate();

  const register = async (credentials) => {
    try {
      await authApi.register(credentials);
      navigate("/login");
    } catch (error) {
      alert(formatErrorMessage(error.message));
      if (error instanceof AxiosError && error.response.status === 422) {
        dispatch({ type: "login/error", payload: error.response.data.message });
      }
    }
  };

  return { register };
};

export default useRegister;

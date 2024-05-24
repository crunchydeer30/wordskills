/* eslint-disable react/prop-types */
import { useReducer, createContext, useContext, useEffect } from "react";

const initialState = {
  token: localStorage.getItem("token") || null,
  isAuth: Boolean(localStorage.getItem("token")),
  validation_errors: {},
};

export const AuthContext = createContext(initialState);

const reducer = (state, action) => {
  switch (action.type) {
    case "login":
      return {
        ...state,
        token: action.payload.token,
        isAuth: true,
        validation_errors: {},
      };
    case "logout":
      return {
        ...state,
        token: null,
        isAuth: false,
      };
    case "login/error":
      return {
        ...state,
        validation_errors: action.payload,
      };
    case "register/error":
      return {
        ...state,
        validation_errors: action.payload,
      };
    case "errors/cleared":
      return {
        ...state,
        validation_errors: {},
      };
    default:
      return state;
  }
};

export const AuthProvider = ({ children }) => {
  const [{ token, isAuth, validation_errors }, dispatch] = useReducer(reducer, initialState);

  return (
    <AuthContext.Provider value={{ token, isAuth, dispatch, validation_errors }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  return useContext(AuthContext);
};

export const useResetErrors = () => {
  const { dispatch } = useAuth();
  useEffect(() => {
    dispatch({ type: "errors/cleared" });
  }, [dispatch]);
}


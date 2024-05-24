/* eslint-disable react/prop-types */
import { createContext, useReducer, useContext, useEffect } from "react";
import filesApi from "../api/files.api";
import { Outlet } from "react-router-dom";

const initialState = {
  files: [],
  isLoading: false,
};

const reducer = (state, action) => {
  switch (action.type) {
    case "files/loaded":
      return {
        ...state,
        files: action.payload,
        isLoading: false,
      };
    case "files/loading":
      return {
        ...state,
        isLoading: true,
      };
    default:
      return state;
  }
};

export const SharedContext = createContext(initialState);

export const SharedProvider = ({ children }) => {
  const [{ files, isLoading }, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    const load = async () => {
      try {
        dispatch({ type: "files/loading" });
        const files = await filesApi.shared();
        dispatch({ type: "files/loaded", payload: files });
      } catch (e) {
        console.log(e);
      }
    };

    load();
  }, []);

  return (
    <SharedContext.Provider value={{ files, isLoading, dispatch }}>
      {children}
    </SharedContext.Provider>
  );
};

export const useShared = () => {
  return useContext(SharedContext);
};

export const SharedLayout = () => {
  return (
    <SharedProvider>
      <Outlet />
    </SharedProvider>
  );
};

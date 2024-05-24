/* eslint-disable react/prop-types */
import { createContext, useReducer, useContext, useEffect } from "react";
import filesApi from "../api/files.api";
import { Outlet } from "react-router-dom";

const initialState = {
  files: [],
  isLoding: false,
};

const reducer = (state, action) => {
  switch (action.type) {
    case "files/loaded":
      return {
        ...state,
        isLoading: false,
        files: action.payload,
      };
    case "file/removed":
      return {
        ...state,
        files: state.files.filter((file) => file.file_id !== action.payload),
      };
    case "file/updated":
      return {
        ...state,
        files: state.files.map((file) => {
          if (file.file_id === action.payload.id) {
            return { ...file, name: action.payload.name };
          }
          return file;
        }),
      };
    case "file/accesses/updated":
      return {
        ...state,
        files: state.files.map((file) => {
          if (file.file_id === action.payload.file_id) {
            return { ...file, accesses: action.payload.accesses };
          }
          return file;
        }),
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

export const DiskContext = createContext(initialState);

export const DiskProvider = ({ children }) => {
  const [{ files, isLoading }, dispatch] = useReducer(reducer, initialState);

  useEffect(() => {
    const load = async () => {
      try {
        dispatch({ type: "files/loading" });
        const files = await filesApi.disk();
        dispatch({ type: "files/loaded", payload: files });
      } catch (e) {
        console.log(e);
      }
    };

    load();
  }, []);

  return (
    <DiskContext.Provider value={{ files, isLoading, dispatch }}>
      {children}
    </DiskContext.Provider>
  );
};

export const useDisk = () => {
  return useContext(DiskContext);
};

export const DiskLayout = () => {
  return (
    <DiskProvider>
      <Outlet />
    </DiskProvider>
  );
};

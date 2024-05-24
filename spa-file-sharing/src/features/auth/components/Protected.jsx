/* eslint-disable react/prop-types */
import { useEffect } from "react";
import { useAuth } from "../context/AuthContext";
import { useNavigate } from "react-router-dom";
import { Outlet } from "react-router-dom";

const Protected = ({ type }) => {
  const { isAuth } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (!isAuth && type === "auth") {
      navigate("/login");
    } else if (isAuth && type === "guest") {
      navigate("/");
    } else {
      return;
    }
  }, [isAuth]);

  return <Outlet />;
};

export default Protected;

const formatErrorMessage = (e) => {
  if (typeof e === "string") {
    return e;
  } else if (typeof e === "object")  {
    return JSON.stringify(e);
  } else {
    return JSON.stringify(e);
  }
}

export default formatErrorMessage 
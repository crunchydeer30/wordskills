/* eslint-disable react/prop-types */
import useRevokeAccess from "../hooks/useRevokeAccess";

const AccessItem = ({ file_id, user }) => {
  const { revokeAccess } = useRevokeAccess();

  return (
    <article>
      <p className="name">{user.fullname}</p>
      <p className="email">{user.email}</p>
      <button
        className="deleteButton"
        onClick={() => revokeAccess(file_id, { email: user.email })}
      >
        Удалить
      </button>
    </article>
  );
};

export default AccessItem;

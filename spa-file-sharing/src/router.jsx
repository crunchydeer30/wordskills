import {
  Navigate,
  Route,
  createBrowserRouter,
  createRoutesFromElements,
} from "react-router-dom";
import Disk from "./pages/Disk/Disk";
import Login from "./pages/Login/Login";
import Register from "./pages/Register/Register";
import Protected from "./features/auth/components/Protected";
import NotFound from "./pages/NotFound/NotFound";
import File from "./pages/File/File";
import Accesses from "./pages/Accesses/Accesses";
import { DiskLayout } from "./features/files/context/DiskContext";
import { SharedLayout } from "./features/files/context/SharedContext";
import Shared from "./pages/Shared/Shared";
import Upload from "./pages/Upload/Upload";

const router = createBrowserRouter(
  createRoutesFromElements(
    <Route path="/">
      <Route index element={<Navigate to="/files/disk" replace />} />

      <Route element={<DiskLayout />}>
        <Route path="files" element={<Protected type="auth" />}>
          <Route path="disk">
            <Route index element={<Disk />} />
            <Route path=":file_id" element={<File />} />
            <Route path=":file_id/accesses" element={<Accesses />} />
          </Route>

          <Route element={<SharedLayout />}>
            <Route path="shared" element={<Shared />} />
          </Route>

          <Route path="upload" element={<Upload />} />
        </Route>
      </Route>

      <Route element={<Protected type="guest" />}>
        <Route path="login" element={<Login />} />
        <Route path="register" element={<Register />} />
      </Route>

      <Route path="*" element={<NotFound />} />
    </Route>
  )
);

export default router;

import React, { lazy, Suspense } from "react";
import { createBrowserRouter, createRoutesFromChildren, Route } from "react-router-dom";
import PageNotFound from "./pages/pageNotFound";
import Loader from "./components/Loader";

const LandingPage = lazy(() => import("./pages/LandingPage"));
const RootLayout = lazy(() => import("./layouts/RootLayout"));
const AdminLayout = lazy(() => import("./layouts/AdminLayout"));
const Maintenance = lazy(() => import("./pages/Maintenance"));
const ChangePassword = lazy(() => import("./pages/ChangePassword"));
const GeneralSettings = lazy(() => import("./pages/superAdmin/GeneralSettings"));
const Admin = lazy(() => import("./pages/admin/Admin"));
const UserLayout = lazy(() => import("./layouts/UserLayout"));
const User = lazy(() => import("./pages/user/User"));
const ForgetPassword = lazy(() => import("./pages/ForgetPassword"));
const NoAccess = lazy(() => import("./pages/NoAccess"));
const SuperAdminLayout = lazy(() => import("./layouts/SuperAdminLayout"));
const SuperAdmin = lazy(() => import("./pages/superAdmin/superAdmin"));
const WorkingHours = lazy(() => import("./pages/admin/WorkingHours"));
const DaysOff = lazy(() => import("./pages/admin/DaysOff"));
const Planning = lazy(() => import("./pages/admin/Planning"));
const Products = lazy(() => import("./pages/admin/Products"));
const ProductForUser = lazy(() => import("./pages/ProductForUser"));
const UserMessages = lazy(() => import("./pages/admin/UserMessages"));

const Router = createBrowserRouter(
  createRoutesFromChildren(
    <Route path="/" element={
      <Suspense fallback={<Loader/>}>
        <RootLayout/>
      </Suspense>
    }>
      <Route index element={
        <Suspense fallback={<Loader/>}>
          <LandingPage/>
        </Suspense>
      }/> 
      <Route path="changePassword" element={
        <Suspense fallback={<Loader/>}>
          <ChangePassword/>
        </Suspense>
      }/>
      <Route path="forgetPassword" element={
        <Suspense fallback={<Loader/>}>
          <ForgetPassword/>
        </Suspense>
      }/>
      <Route path="maintenance" element={
        <Suspense fallback={<Loader/>}>
          <Maintenance/>
        </Suspense>
      }/>
      <Route path="NoAccess" element={
        <Suspense fallback={<Loader/>}>
          <NoAccess/>
        </Suspense>
      }/>
      <Route path="products/:id" element={
        <Suspense fallback={<Loader/>}>
          <ProductForUser/>
        </Suspense>
      }/>
    
      <Route path="guest" element={<UserLayout/>}>
        <Route index element={
          <Suspense fallback={<Loader/>}>
            <User/>
          </Suspense>
        }/>
      </Route>
      <Route path="admin" element={<AdminLayout/>}>
        <Route index element={
          <Suspense fallback={<Loader/>}>
            <Admin/>
          </Suspense>
        }/>
        <Route path="products" element={
          <Suspense fallback={<Loader/>}>
            <Products/>
          </Suspense>
        }/>
        <Route path="guestMessages" element={
          <Suspense fallback={<Loader/>}>
            <UserMessages/>
          </Suspense>
        }/>
        <Route path=":id/workingHours" element={
          <Suspense fallback={<Loader/>}>
            <WorkingHours/>
          </Suspense>
        }/>
        <Route path=":id/daysOff" element={
          <Suspense fallback={<Loader/>}>
            <DaysOff/>
          </Suspense>
        }/>
        <Route path=":id/planning" element={
          <Suspense fallback={<Loader/>}>
            <Planning/>
          </Suspense>
        }/>
      </Route>
      <Route path="superAdmin" element={<SuperAdminLayout/>}>
        <Route index element={
          <Suspense fallback={<Loader/>}>
            <SuperAdmin/>
          </Suspense>
        }/>
        <Route path="generalSettings" element={
          <Suspense fallback={<Loader/>}>
            <GeneralSettings/>
          </Suspense>
        }/>
      </Route>

      <Route path="*" element={
        <Suspense fallback={<Loader/>}>
          <PageNotFound/>
        </Suspense>
      }/>
    </Route>
  )
);

export default Router;

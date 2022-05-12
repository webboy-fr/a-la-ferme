import React, { lazy, Suspense } from 'react';
import './App.scss';

import {
  BrowserRouter as Router,
  Routes,
  Route
} from "react-router-dom";
import ProtectedRoute from './services/ProtectedRoutes';


import FarmsList from './components/Farm/FarmsList';
import Farm from './components/Farm/Farm';
import MyAccount from './components/User/MyAccount';

import Navbar from './components/Navbar';
import Login from './components/User/Login';
import toast, {Toaster} from 'react-hot-toast';

const Home = lazy(() => import('./components/Home'));
const notify = () => toast('Here is your toast.');

function App() {
  return (

    <Router>
      <Navbar />
      <Suspense fallback={<div onLoad={notify}>Chargement...</div>}>
        <Routes>
          <Route exact path="/" element={<Home />} />
          <Route exact path="/farms" element={<FarmsList />} />
          <Route path="/farms/:slug" element={<ProtectedRoute />}>
            <Route path="" element={<Farm />} />
          </Route>
          <Route path="/my-account" element={<ProtectedRoute />}>
            <Route path="" element={<MyAccount />} />
          </Route>
          <Route path="/login" element={<Login />} />
          <Route
            path="*"
            element={
              <main style={{ padding: "1rem" }}>
                <p>There's nothing here!</p>
              </main>
            }
          />

        </Routes>
      </Suspense>
    </Router>
  );
}

export default App;

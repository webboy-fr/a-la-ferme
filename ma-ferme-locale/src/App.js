import React from 'react';
import './App.scss';
import {
  BrowserRouter as Router,
  Routes,
  Route
} from "react-router-dom";

import FarmsList from './components/Farm/FarmsList';
import Farm from './components/Farm/Farm';
import Home from './components/Home';
import Navbar from './components/Navbar';
import Login from './components/User/Login';

function App() {
  return (
    <Router>
      <Navbar />

      {/* A <Switch> looks through its children <Route>s and
            renders the first one that matches the current URL. */}
      <Routes>
        <Route exact path="/" element={<Home />} />
        <Route exact path="/farms" element={<FarmsList />} />
        <Route path="/farms/:slug" element={<Farm />} />
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
    </Router>
  );
}

export default App;

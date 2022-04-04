import React from 'react';
import './App.css';
import { BrowserRouter as Router, Route, NavLink } from 'react-router-dom';
import Switch from 'react-router';
import Farms from './components/Farms';


function App() {
  return (
    <>
      <div>
        <Route path="/farms">
          <Farms />
        </Route>
        <Route path="/:user">
          <User />
        </Route>
        <Route>
          <NoMatch />
        </Route>
      </div>
    </>


  );
}

export default App;

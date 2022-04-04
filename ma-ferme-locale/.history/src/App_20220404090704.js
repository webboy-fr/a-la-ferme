import React from 'react';
import './App.css';
import { BrowserRouter as Router, Switch, Route, NavLink } from 'react-router-dom';
import Switch from 'react-router-dom/Switch';
import Farms from './components/Farms';


function App() {
  return (
    <Router>
      <div>
        <NavLink to='/farms'>Books</NavLink>
      </div>
      <Switch>
        <Route path='/farms' component={Farms} />
      </Switch>
    </Router>
  );
}

export default App;

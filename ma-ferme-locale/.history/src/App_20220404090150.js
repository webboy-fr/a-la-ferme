import React from 'react';
import logo from './logo.svg';
import './App.css';

function App() {
  return (
    <Router>
      <div>
        <NavLink to='/books'>Books</NavLink>
      </div>
      <Switch>
        <Route path='/books' component={Books} />
      </Switch>
    </Router>
  );
}

export default App;

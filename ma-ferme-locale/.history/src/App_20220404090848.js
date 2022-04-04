import React from 'react';
import './App.css';
import { BrowserRouter as Route } from 'react-router-dom';
import Switch from 'react-router';
import Farms from './components/Farms';


function App() {
  return (
    <>
      <div>
        <Route path="/farms">
          <Farms />
        </Route>
      </div>
    </>


  );
}

export default App;

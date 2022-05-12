import React from 'react';
import { Navigate, Outlet } from 'react-router-dom';
import user from '../components/User/User';

const ProtectedRoute = (props) => {
    return user.isLoggedIn() ? <Outlet /> : <Navigate to="/login" state={ {from: props.location}} />;
};

export default ProtectedRoute;
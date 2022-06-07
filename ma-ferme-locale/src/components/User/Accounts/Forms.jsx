import React from "react";
import LoginForm from "./LoginForm";
import RegisterForm from "./RegisterForm";

const Forms = ({login}) => {

    if (login) {
        return (
            <LoginForm />
        )
    } else {
        return (
            <RegisterForm />
        )
    }
}

export default Forms;

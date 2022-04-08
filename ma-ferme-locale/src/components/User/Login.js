import React from 'react';

import { ApiClient } from '../../services/ApiClient';

export default class Login extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            email: '',
            setEmail: function (email) {
                this.email = email;
            },
            password: '',
            setPassword: function (password) {
                this.password = password;
            }
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();

        ApiClient.get('http://localhost:8000/sanctum/csrf-cookie')
            .then(response => {
                ApiClient.post(`/login`, {
                    headers: {
                        Accept: 'application/json'
                    },
                    email: this.state.email,
                    password: this.state.password
                }).then(response => {
                    localStorage.setItem('sanctum_token', response.data.data.token);
                }).catch(error => 
                    //check if response status is 404, alert user that email or password is incorrect
                    error.response.status === 404 ? alert('Email or password is incorrect') : console.error(error)
                    );
            });
    }

    render() {

        return (
            <>
                <div className="login-container" style={{ backgroundImage: 'url(./img/sheep_in_a_field_eating_grass.webp' }}>
                    <div>
                        <h1>Login</h1>
                        <form onSubmit={this.handleSubmit}>
                            <input
                                type="email"
                                name="email"
                                placeholder="Email"
                                value={this.state.email}
                                onChange={e => this.setState({ email: e.target.value })}
                                required
                            />
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                value={this.state.password}
                                onChange={e => this.setState({ password: e.target.value })}
                                required
                            />
                            <button type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </>
        );

    }
}
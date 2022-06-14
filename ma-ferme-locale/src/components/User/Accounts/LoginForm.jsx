import React from 'react';
import { ApiClient } from '../../../services/ApiClient';
import { getPhotos } from '../../../services/Pexels';
import user from '../User';
import { Typography, TextField, Button, FormControlLabel, Link, Checkbox, Box, Grid } from '@mui/material';
import toast from 'react-hot-toast';
import { useNavigate } from "react-router-dom";

export default class LoginForm extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            email: '',
            password: '',
            backgroundImage: null
        };
    }

    notify = () => toast('Identifiant incorrect !', {
        icon: '❌',
        position: 'bottom-center',
    });

    /**
     * Callback for the form submit event
     */
    authenticatedCallback = () => {
        let {from} = this.props.location || {from: {pathname: '/dashboard'}}
        let navigate = useNavigate();
        navigate(from);
    }

    componentDidMount() {
        // Get the background image from Pexels API
        getPhotos(158179).then(res => {
            this.setState({ backgroundImage: res.src.large2x });
        });
    }

    handleSubmit = (e) => {
        e.preventDefault();

        ApiClient.get('sanctum/csrf-cookie')
            .then(response => {
                ApiClient.post(`api/login`, {
                    headers: {
                        Accept: 'application/json'
                    },
                    email: this.state.email,
                    password: this.state.password
                }).then(response => {
                    user.authenticated(response.data, this.authenticatedCallback)
                });
            });
    }

    render() {

        return (
                <Box className='login-container' display="grid" alignItems="center" height="100vh">
                    <img src={this.state.backgroundImage} alt="Mouton dans la prairie"/>
                    <Grid container direction='row' spacing={0} minHeight="75%" maxWidth="lg" margin="0 auto" align='center' justifyContent="center">
                        <Grid item container direction='column' display="flex" justifyContent="center" xs={12} sm={12} md={4} sx={{ background: "#407A64" }}>
                            <Typography color='white' variant="h3" align='center'>
                                Welcome<br /> Back!
                            </Typography>
                            <Typography color='white'>
                                Connecte-toi pour rester en contact avec nous.
                            </Typography>
                        </Grid>
                        <Grid item container direction='column' display="flex" justifyContent="center" xs={12} sm={12} md={6} padding={{sm: "0 10%"}} sx={{ background: "white" }}>
                            <Box component="form" onSubmit={this.handleSubmit} noValidate sx={{ mt: 1 }}>
                                <TextField
                                    margin="normal"
                                    required
                                    fullWidth
                                    id="email"
                                    label="Adresse email"
                                    name="email"
                                    autoComplete="email"
                                    autoFocus
                                    onChange={(e) => this.setState({ email: e.target.value })}
                                />
                                <TextField
                                    margin="normal"
                                    required
                                    fullWidth
                                    name="password"
                                    label="Mot de passe"
                                    type="password"
                                    id="password"
                                    autoComplete="current-password"
                                    onChange={(e) => this.setState({ password: e.target.value })}
                                />
                                <FormControlLabel
                                    control={<Checkbox value="remember" color="primary" />}
                                    label="Se souvenir de moi"
                                />
                                <Button
                                    type="submit"
                                    fullWidth
                                    variant="contained"
                                    sx={{ mt: 3, mb: 2 }}
                                >
                                    Se connecter
                                </Button>
                                <Grid container>
                                    <Grid item xs={12}>
                                        <Link href="#" variant="body2">
                                            Mot de passe oublié ?
                                        </Link>
                                    </Grid>
                                    <Grid item xs={12}>
                                        <Link href="/register" variant="body2">
                                            {"Pas encore de compte ? S'inscrire"}
                                        </Link>
                                    </Grid>
                                </Grid>
                            </Box>
                        </Grid>
                    </Grid>
                </Box>
        );

    }
}
import React from 'react';
import { Link } from 'react-router-dom';
import { ApiClient } from '../../services/ApiClient';
import toast, { Toaster } from 'react-hot-toast';
import { Autocomplete, Button, Divider, Grid, Slider, TextField, Typography } from '@mui/material';
import { Box } from '@mui/system';
import { ThemeProvider } from '@emotion/react';
import farmTheme from '../../FarmTheme';
import AutocompleteBAN from '../../services/AutocompleteBAN';

class FarmsList extends React.Component {

    getLocation() {
        var longitude;
        var latitude;

        function success(position, setLocation) {
            setLocation(position.coords.longitude, position.coords.latitude);
        }

        //if the longitude and latitude are set, then we can use them to get the location
        if (longitude && latitude) {
            this.setLocation(longitude, latitude);
        }

        function error() {
            toast.error('Unable to retrieve your location');
        }

        if (!navigator.geolocation) {
            toast.error('Geolocation is not supported by your browser');
        } else {
            toast.success('Locating…', { autoClose: false });
            navigator.geolocation.getCurrentPosition(success, error);
        }

    }

    slugify(string) {
        const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìıİłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
        const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
        const p = new RegExp(a.split('').join('|'), 'g')

        return string.toString().toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w-]+/g, '') // Remove all non-word characters
            .replace(/--+/g, '-') // Replace multiple - with single -
            .replace(/^-+/, '') // Trim - from start of text
            .replace(/-+$/, '') // Trim - from end of text
    }

    constructor(props) {
        super(props);

        this.state = {
            farms: [],
            longitude: '',
            latitude: '',
            radius: 5,
        };

        this.setLocation = this.setLocation.bind(this);
    }

    getFarmByRadius() {

        ApiClient.get(`/api/farms/${this.state.longitude}/${this.state.latitude}/${this.state.radius}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if(response.status === 404) {
                    this.setState({
                        farms: []
                    });
                } else {

                this.setState({
                    farms: response.data.data.data
                });
            }
                //console.log(this.state.farms);    
            })
            .catch(error =>
                console.error(error)
            );
    }

    setLocation(longitude, latitude) {
        this.setState({
            longitude: longitude,
            latitude: latitude
        });
    }

    componentDidMount() {
        ApiClient.get(`/api/farms`, {
            headers: {
                Accept: 'application/json'
            }
        })
            .then(response => {
                this.setState({
                    farms: response.data.data
                });
                //console.log(this.state.farms);
            })
            .catch(error =>
                console.error(error)
            );
    }

    componentWillUnmount() {
        this.setState({
            farms: []
        });
    }

    render() {

        return (
            <>
                <Box sx={{ width: '100vw', maxWidth: '100%', mx: 'auto' }}>
                    <Grid container spacing={0} >
                        <Grid item xs={12} md={6}>
                            <img src='./img/fresh_farm_products.png' />
                        </Grid>
                        <Grid sx={{ display: 'grid', alignContent: 'space-evenly' }} item xs={12} md={6} padding="0 5%">
                            <Typography color='black' variant="h4" align='center'>
                                Filtrer votre recherche :
                            </Typography>

                            <Grid container spacing={2}>
                                <Grid item xs={6} >
                                    <AutocompleteBAN maxResults={5} setLocation={this.setLocation} />
                                </Grid>
                                <Grid item xs={6} >
                                    <Button onClick={() => this.getLocation()} sx={{ borderRadius: '20px' }} color="primary" variant="contained" fullWidth>Utiliser votre position</Button>
                                </Grid>
                            </Grid>

                            <Slider
                                aria-label="Small steps"
                                defaultValue={5}
                                step={5}
                                marks
                                min={5}
                                max={25}
                                valueLabelDisplay="auto"
                                sx={{ borderRadius: '0 !important' }}
                            />
                            <Button onClick={() => this.getFarmByRadius()} variant="contained" sx={{ color: 'white' }} color='black' size='large' fullWidth>
                                Rechercher
                            </Button>
                        </Grid>
                    </Grid>

                    <Divider sx={{ width: '50%', margin: '0 auto', border: '1px solid' }} variant='fullWidth' textAlign='center' />
                </Box>

                <ul>
                    {
                        this.state.farms.length === 0 ?
                            <p>No farms found</p>
                            :
                            this.state.farms.map(farm =>
                                <li key={farm.id}>
                                    <Link to={`/farms/${this.slugify(farm.name)}`}>{farm.name}</Link>
                                </li>
                            )
                    }
                </ul>
            </>
        );
    }

}

export default FarmsList;
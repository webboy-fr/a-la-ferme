import React from 'react';
import { Link } from 'react-router-dom';
import { ApiClient } from '../../services/ApiClient';
import toast, { Toaster } from 'react-hot-toast';
import { Autocomplete, Button, Divider, Grid, Slider, TextField, Typography } from '@mui/material';
import { Box } from '@mui/system';

import AutocompleteBAN from './Positions/AutocompleteBAN';
import GeoLoc from './Positions/GeoLoc';

class FarmsList extends React.Component {

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
            radius: 10,
        };

        this.setLocation = this.setLocation.bind(this);
    }

    setFarms(farms) {
        this.setState({ farms });
    }

    setLocation(longitude, latitude) {
        this.setState({
            longitude: longitude,
            latitude: latitude
        });
    }


    getFarmByRadius() {

        ApiClient.get(`/api/farms/${this.state.longitude}/${this.state.latitude}/${this.state.radius}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                this.setFarms(response.data.data.data);   
            })
            .catch(error =>
                console.error(error),
                this.setFarms([])
            );
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
                                    <GeoLoc setLocation={this.setLocation} />
                                </Grid>
                            </Grid>

                            <Slider
                                aria-label="Radius"
                                onChange={(event, newValue) => this.setState({ radius: newValue })}
                                defaultValue={10}
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
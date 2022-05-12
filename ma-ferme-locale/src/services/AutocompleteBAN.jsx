
import React from "react";

import { debounce } from "lodash"
import { Autocomplete, Box, Grid, TextField, Typography } from "@mui/material";
import axios from "axios";
import LocationOnIcon from '@mui/icons-material/LocationOn';

export default function AutocompleteBAN({ maxResults, setLocation }) {

    const [value, setValue] = React.useState(null);
    const [inputValue, setInputValue] = React.useState('');
    const [options, setOptions] = React.useState([]);

    const fetch = React.useMemo( // memoize the fetching of the data to avoid unnecessary requests
        () =>
            debounce((request, callback) => {
                axios.get('http://api-adresse.data.gouv.fr/search/?q=' + request + '&limit=' + maxResults)
                    .then(response => {
                        callback(response.data.features);
                    }
                    )
                    .catch(error => {
                        console.log(error);
                    });
            }, 500),
        [],
    );

    React.useEffect(() => {
        let active = true;

        if (inputValue === '') {
            setOptions(value ? [value] : []);
            return undefined;
        }

        fetch(inputValue, (results) => {
            if(active) {
                let newOptions = [];

                if (value) {
                    newOptions = [value];
                }

                if(results) {
                    newOptions = [...newOptions, ...results];
                }
                
                setOptions(newOptions);
            }
        });

        return () => {
            active = false;
        };

    }, [value, inputValue, fetch]);

    return (
        <Autocomplete
            id="combo-box-demo"
            options={options}
            filterOptions={(x) => x}
            autoComplete
            includeInputInList
            filterSelectedOptions
            value={value}
            getOptionLabel={option => option.properties.name + ', ' + option.properties.postcode + ' ' + option.properties.city}
            isOptionEqualToValue={(option, value) => option.properties.label === value.properties.label}
            onChange={(event, newValue) => {
                setOptions(newValue ? [newValue, ...options] : options);
                setValue(newValue);
                setLocation(newValue.geometry.coordinates[0], newValue.geometry.coordinates[1]);
            }}
            onInputChange={(event, newInputValue) => {
                setInputValue(newInputValue);
            }}
            renderInput={params => (<TextField {...params} label="Rechercher une adresse" variant="outlined" />)}
            renderOption={(props, option) => {
                return (
                    <li {...props}>
                        <Grid container alignItems="center">
                            <Grid item>
                                <Box
                                    component={LocationOnIcon}
                                    sx={{ color: 'text.secondary', mr: 2 }}
                                />
                            </Grid>
                            <Grid item xs>
                                    <span key={option.properties.id}>
                                        {option.properties.name}
                                    </span>

                                <Typography variant="body2" color="text.secondary">
                                    {option.properties.postcode + ' ' + option.properties.city}
                                </Typography>
                            </Grid>
                        </Grid>
                    </li>
                );
            }}

        />
    );
}




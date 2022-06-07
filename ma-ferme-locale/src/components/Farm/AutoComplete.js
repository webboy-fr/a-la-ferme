import { Autocomplete, Box, Grid, TextField, Typography } from '@mui/material';
import axios from 'axios';
import React from 'react';
import { Link } from 'react-router-dom';

// create a class called AutoComplete that extends React.Component 
// the class will create an auto complete component that fetch data from the api https://api-adresse.data.gouv.fr/search/ with a search query 
// the class will render a list of results that will be displayed in the autocomplete component using mui autocomplete component

export default function AutoComplete() {

    const [value, setValue] = React.useState(null);
    const [inputValue, setInputValue] = React.useState('');
    const [options, setOptions] = React.useState([]);
    const loaded = React.useRef(false);

    const fetch = React.useMemo(
        // fetch data from the api https://api-adresse.data.gouv.fr/search/ with a search query coming from the input value
        () => {
            if (!loaded.current) {
                loaded.current = true;
                const searchQuery = inputValue.replace(/\s/g, '+');
                axios.get(`https://api-adresse.data.gouv.fr/search/?q=${searchQuery}&autocomplete=1`)
                    .then(response => {
                        setOptions(response.data.features);
                    })
                    .catch(error => {
                        console.log(error);
                    });

            }
        }, [inputValue]);

    React.useEffect(() => {
        let active = true;

        if (inputValue === '') {
            setOptions(value ? [value] : []);
            return undefined;
        }

        fetch({ input: inputValue }, (results) => {
            if (active) {
                let newOptions = [];

                if (value) {
                    newOptions = [value];
                }

                if (results) {
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
            id="google-map-demo"
            sx={{ width: 300 }}
            getOptionLabel={(option) =>
                typeof option === 'string' ? option : option.description
            }
            filterOptions={(x) => x}
            options={options}
            autoComplete
            includeInputInList
            filterSelectedOptions
            value={value}
            onChange={(event, newValue) => {
                setOptions(newValue ? [newValue, ...options] : options);
                setValue(newValue);
            }}
            onInputChange={(event, newInputValue) => {
                setInputValue(newInputValue);
            }}
            renderInput={(params) => (
                <TextField {...params} label="Add a location" fullWidth />
            )}
            renderOption={(props, option) => {
                const matches = option.structured_formatting.main_text_matched_substrings;
                const parts = Object.parse(
                    option.structured_formatting.main_text,
                    matches.map((match) => [match.offset, match.offset + match.length]),
                );

                return (
                    <li {...props}>
                        <Grid container alignItems="center">
                            <Grid item>
                                <Box
                                    //component={LocationOnIcon}
                                    sx={{ color: 'text.secondary', mr: 2 }}
                                />
                            </Grid>
                            <Grid item xs>
                                {parts.map((part, index) => (
                                    <span
                                        key={index}
                                        style={{
                                            fontWeight: part.highlight ? 700 : 400,
                                        }}
                                    >
                                        {part.text}
                                    </span>
                                ))}

                                <Typography variant="body2" color="text.secondary">
                                    {option.structured_formatting.secondary_text}
                                </Typography>
                            </Grid>
                        </Grid>
                    </li>
                );
            }}
        />
    );

}
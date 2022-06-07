import { Button } from "@mui/material";
import React from "react";

const GeoLoc = ({setLocation}) => {

    const getLocation = () => {

        function success(position) {
            setLocation(position.coords.longitude, position.coords.latitude);
        }

        if (!navigator.geolocation) {
            console.log('Geolocation is not supported by your browser');
        } else {
            navigator.geolocation.getCurrentPosition(success);
            console.log('Locating …');
        }
    }

    return (
        <div>
            <Button data-testid="geoPosButton" onClick={() => getLocation()} 
                sx={{ borderRadius: '20px' }} color="primary" variant="contained" fullWidth>Utiliser votre position</Button>
        </div>
    );
}

    export default GeoLoc;
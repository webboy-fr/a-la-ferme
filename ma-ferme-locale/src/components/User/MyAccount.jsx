import { Grid, Typography } from "@mui/material";
import { Box } from "@mui/system";
import React from "react";
import { ApiClient } from "../../services/ApiClient";
import { getPhotos } from "../../services/Pexels";

class MyAccount extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            user: '',
            backgroundImage: '',
        }
    }

    componentDidMount() {
        getPhotos(288621).then(res => {
            this.setState({ backgroundImage: res.src.large2x });
        });

        ApiClient.get('api/user').then(res => {
            this.setState({ user: res.data });
        });

    }

    render() {
        return (
            <>
                <Box height="30vh" width="100%" position="relative">
                    <Box zIndex={1} padding="2% 3%" width={{xs: "100%", sm: "80%"}} position="absolute" borderRadius="40px" left="50%" bottom="-50%" sx={{ backgroundColor: "#315955", transform: "translateX(-50%)" }}>
                        <Grid container direction="row">
                            <Grid item container xs={12} sm={6}>
                                <Grid container direction="row" columnSpacing={2} rowSpacing={0}>
                                    <Grid item container xs={12} sm={4}>
                                        <img src="./img/poule_avatar.png" alt="avatar" style={{width: "100%", height: "100%", objectFit: "cover", border: "5px solid black", borderRadius: "10%", position: "relative", bottom: "50%"}}/>
                                    </Grid>
                                    <Grid item container xs={12} sm={8} alignContent="flex-start">
                                        <Typography variant="h3" color="common.white" width="100%">Bonjour, {localStorage.getItem('userFirstName')}</Typography>
                                        <Typography variant="body1" color="common.black">Agriculteur</Typography>
                                    </Grid>
                                </Grid>
                            </Grid>
                            <Grid item container xs={12} sm={6} pl="5%" borderLeft="1px solid black">
                                <Grid container direction="row" rowSpacing={5}>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            ADRESSE MAIL
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white">
                                            agriculteur@mfl.com
                                        </Typography>
                                    </Grid>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            ADRESSE
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white" maxWidth="65%">
                                            34 Rue du blé,
                                            75000 Paris
                                        </Typography>
                                    </Grid>
                                    <Grid item container xs={12} sm={6}>
                                        <Typography variant="h6" align="left" fontWeight="bold" width="100%">
                                            TELEPHONE
                                        </Typography>
                                        <Typography variant="body1" align="left" fontWeight="bold" color="common.white">
                                            +33 6 78 78 78 78
                                        </Typography>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Box>
                    <img src={this.state.backgroundImage} alt="background" style={{ width: "100%", height: "100%", objectFit: "cover" }} />
                </Box>
            </>
        );
    }

}

export default MyAccount;
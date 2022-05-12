import { Button, Grid, Typography } from "@mui/material";
import { Box } from "@mui/system";
import React from "react";

class Home extends React.Component {


    render() {
        return (
            <>

                <Box textAlign="center" height="100vh">
                    <video id="background-video" playsInline autoPlay loop muted>

                        <source src="./videos/farming_video.mp4" type="video/mp4" />

                    </video>
                    <Grid container justifyContent='center' sx={{ height: '90vh' }}>
                        <Grid item xs={12} display="inline-grid" alignContent="space-around" justifyContent="center">
                            <Typography color="white" variant="h1" sx={{ p: '5% 0' }}>
                                LE LOCAL POUR <br /> UN AVENIR MEILLEUR
                            </Typography>
                        </Grid>
                        <Grid item alignItems="center" sx={{ display: 'grid' }}>
                            <Button variant="contained" size="large" color="secondary" href="/farms">
                                Je découvre le projet
                            </Button>
                            <Button variant="contained" size="large" color="primary" href="/login">
                                Je cherche une ferme !
                            </Button>
                        </Grid>
                    </Grid>



                </Box>
                <Box textAlign="center" sx={{background: "white"}}>
                    <Grid container justifyContent='center' sx={{ height: '90vh' }}>
                    </Grid>
                </Box>
            </>

        )
    }

}

export default Home;
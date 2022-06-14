import { Grid, Typography, Box, Button } from '@mui/material';

const Error404Page = () => {
    return (
        <Box height="100vh">
            <Grid container spacing={2} py="5%" justifyContent="space-around" alignItems="center" textAlign="left" height="100%">
                <Grid item xs={12} sm={5}>
                    <img src='./img/bouteille.svg' alt='Bouteille à la mer' />
                </Grid>
                <Grid item xs={12} sm={6}>
                    <Typography variant="404" color="#43B3B9" gutterBottom>
                        404
                    </Typography>
                    <Typography variant="h5" color="common.black" gutterBottom>
                        Vous êtes parti tellement loin que vous êtes tombé sur une île !
                    </Typography>
                    <Button variant="contained" color="secondary" href="/" gutterBottom>
                        Cliquez ici
                    </Button>
                    <Typography variant="h5" color="common.black" gutterBottom>
                        Pour revenir à la page d'accueil
                    </Typography>
                </Grid>
            </Grid>
        </Box>
    );
}

export default Error404Page;
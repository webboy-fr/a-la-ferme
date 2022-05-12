import { AppBar, IconButton, Toolbar, Fab, Box, Grid } from "@mui/material";
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import SearchOutlinedIcon from '@mui/icons-material/SearchOutlined';
import AddIcon from '@mui/icons-material/Add';
import LogoutIcon from '@mui/icons-material/Logout';
import PersonOutlineIcon from '@mui/icons-material/PersonOutline';
import React from "react";

export default function Mobile() {

    const [anchorEl, setAnchorEl] = React.useState(null);
    const [clickHex, setClickHex] = React.useState(false);

    return (
        <AppBar position="fixed" color="white" sx={{ top: 'auto', bottom: 0 }}>
            <Toolbar>
                <Grid container justifyContent='space-between'>
                    <Grid item alignSelf='center' >
                        <IconButton color="inherit" aria-label="open drawer">
                            <HomeOutlinedIcon />
                        </IconButton>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <IconButton color="inherit" aria-label="open drawer">
                            <SearchOutlinedIcon />
                        </IconButton>
                    </Grid>
                    <Grid item sx={{filter: 'drop-shadow(0px 5px 4px #ccc)'}}>
                    <div class="hexagon" onClick={() => setClickHex(!clickHex)} className={clickHex ? 'hexagon turning' : 'hexagon'}>
                        <AddIcon id="search-icon" color="white" sx={{display: 'block', margin: 'auto', transform: 'translateY(80%)'}} />
                    </div>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <IconButton color="inherit" aria-label="open drawer">
                            <PersonOutlineIcon />
                        </IconButton>
                    </Grid>
                    <Grid item alignSelf='center'>
                        <IconButton color="inherit" aria-label="open drawer">
                            <LogoutIcon />
                        </IconButton>
                    </Grid>
                </Grid>


            </Toolbar>
        </AppBar>
    );
}
import { Typography } from "@mui/material";
import { Box } from "@mui/system";
import React from "react";

class MyAccount extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            farms: [],
        }
    }

    render() {
        return (
            <>
                <Box>
                    <Typography variant="h1">
                        Mon compte
                    </Typography>
                </Box>
            </>
        );
    }

}

export default MyAccount;
import { createTheme } from '@mui/material/styles';

const farmTheme = createTheme({
    palette: {
        type: 'light',
        primary: {
            main: '#EF7E0E',
            contrastText: '#fff'
        },
        secondary: {
            main: '#407A64',
        },
        black: {
            main: '#000000',
            contrastText: '#ffffff',
        },
        white: {
            main: '#ffffff',
            contrastText: '#000000',
        }
    },
    typography: {
        h1: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.5rem, 8vw - 2rem, 5rem)',
        },
        h2: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
        },
        fontFamily: '"Karla", "Helvetica", "Arial", sans-serif',
        h3: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
        },
        h4: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
        },
        h5: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: '1.2rem',
        },
    },
});

export default farmTheme;
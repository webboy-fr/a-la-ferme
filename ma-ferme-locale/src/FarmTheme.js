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
        thirdary: {
            main: '#FFF',
        },
        black: {
            main: '#000000',
            contrastText: '#ffffff',
        },
        white: {
            main: '#ffffff'
        }
    },
    typography: {
        h1: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.5rem, 8vw - 2rem, 5rem)',
        },
        h2: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.6rem, 2vw + 0.5rem, 2rem)',
        },
        fontFamily: '"Karla", "Helvetica", "Arial", sans-serif',
        h3: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.4rem, 2vw + 0.5rem, 1.7rem)',
        },
        h4: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1.2rem, 2vw + 0.5rem, 1.4rem)',
        },
        h5: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(1rem, 2vw + 0.5rem, 1.2rem)',
        },
        body1: {
            fontFamily: '"Karla", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(0.8rem, 2vw + 0.5rem, 1rem)',
        },
        404: {
            fontFamily: '"Rubik", "Helvetica", "Arial", sans-serif',
            fontSize: 'clamp(10rem, 8vw - 2rem, 10rem)',
        }
    },
});

export default farmTheme;
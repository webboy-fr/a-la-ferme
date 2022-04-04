import React from 'react';
import axios from 'axios';

const Farms = () => {
    
    const [farms, setFarms] = React.useState([]);

    React.useEffect(() => {
        axios.get('http://localhost:8000/api/farms', {
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer 4|i59XqEQI05f1lBiS5qBUmcBFqInBD76edgKo515Y'
            }
        }) 
        .then(response => {
            setFarms(response.data)
        })
        .catch(error => console.error(error));
    }, []);

    const farmsList = farms.map((farm) =>
        <li key={farm.id}>{farm.title}</li>
    );

    return (
        <ul>{farmsList}</ul>
    );

}
export default Farms;
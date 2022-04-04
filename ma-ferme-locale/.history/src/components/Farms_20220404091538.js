import React from 'react';
import axios from 'axios';

const Farms = () => {
    
    const [farms, setFarms] = React.useState([]);

    React.useEffect(() => {
        axios.get('localhost:8000/api/farms', {
            headers: {
                Accept: 'application/json',
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
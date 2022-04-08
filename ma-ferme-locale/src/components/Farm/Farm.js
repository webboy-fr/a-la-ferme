import React from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

class Farm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            farm: [],
            setFarm: function (farm) {
                this.farm = farm;
            }
        };

    }

    componentDidMount() {
        axios.get(`${process.env.REACT_APP_API_URL}/farms`, {
            headers: {
                Accept: 'application/json'
            }
        })
            .then(response => {
                this.setState({
                    farms: response.data.data.data
                });
                console.log(this.state.farms);
            })
            .catch(error => console.error(error));
    }

    componentWillUnmount() {
        this.setState({
            farms: []
        });
    }

    render() {

        return (
            <div>
                <h1>Farms</h1>
                <ul>
                    {//create a for loop on the farms state
                        this.state.farms.map(farm =>
                            <li key={farm.id}>
                                <Link to={`/farms/${this.slugify(farm.name)}`}>{farm.name}</Link>
                            </li>
                        )}
                </ul>
            </div>
        );
    }

}

export default Farm;
import React from 'react';
import { Link } from 'react-router-dom';
import { ApiClient } from '../../services/ApiClient';

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
        ApiClient.get('/api/farms', {
            headers: {
                Accept: 'application/json'
            }
        })
            .then(response => {
                this.setState({
                    farms: response.data.data.data
                });
                console.log(this.state.farm);
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
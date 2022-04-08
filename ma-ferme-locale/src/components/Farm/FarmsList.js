import React from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import Farm from './Farm';

class FarmsList extends React.Component {

    slugify(string) {
        const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìıİłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
        const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
        const p = new RegExp(a.split('').join('|'), 'g')

        return string.toString().toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w-]+/g, '') // Remove all non-word characters
            .replace(/--+/g, '-') // Replace multiple - with single -
            .replace(/^-+/, '') // Trim - from start of text
            .replace(/-+$/, '') // Trim - from end of text
    }

    constructor(props) {
        super(props);

        this.state = {
            farms: [],
            setFarms: function (farms) {
                this.farms = farms;
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

export default FarmsList;
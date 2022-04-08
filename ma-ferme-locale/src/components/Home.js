import React from "react";

class Home extends React.Component {

    render() {
        return <h1>Bonjour, {this.props.name}</h1>;
    }

}

export default Home;
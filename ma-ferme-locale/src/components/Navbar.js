import React from 'react';
import { Link } from 'react-router-dom';

import '../styles/global.scss';

class Navbar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            isExpanded: false
        }
    }

    /* Ajouter un sous-menu
    <li>
        <a href="#!">Services</a>
        <ul class="nav-dropdown">
            <li><a href="#!">Web Design</a></li>
            <li><a href="#!">Web Development</a></li>
            <li><a href="#!">Graphic Design</a></li>
        </ul>
    </li>
    */

    render() {

        return (
            <section class="navigation">
                <div class="nav-container">
                    <div class="brand">
                        <Link to="/">Ma ferme locale</Link>
                    </div>
                    <nav>
                        <div class="nav-mobile">
                            <a id="nav-toggle" className={this.state.isExpanded ? "active" : ""} onClick={() => this.setState({ isExpanded: !this.state.isExpanded })}><span></span></a>
                        </div>
                        <ul class="nav-list " style={this.state.isExpanded ? { display: 'block' } : {}}>
                            <li><Link to="/">Accueil</Link></li>
                            <li><Link to="/farms">Les fermes</Link></li>
                            <li><a href="#!">Le projet</a></li>
                            <li><a href="#!">Aide</a></li>
                            <li><a href="/login">Connexion test</a></li>
                        </ul>
                    </nav>
                </div>
            </section>
        );
    }
}

export default Navbar;
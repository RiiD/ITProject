import React from "react";
import { Link, withRouter } from "react-router";
import ComboBox from "../Friends/ComboBox/ComboBox.react.js";

class Header extends React.Component {
    render() {
        const { user } = this.props;
        
        return (
            <div className="row">
                <nav className="navbar navbar-default">
                    <div className="container-fluid">
                        <div className="navbar-header">
                            <Link className="navbar-brand" to="/">
                                AfekaFace
                            </Link>
                        </div>
                        <div className="collapse navbar-collapse" classID="bs-example-navbar-collapse-1">
                            <ul className="nav navbar-nav">
                                <li><Link to="/">Posts</Link></li>
                                <li><Link to="/my-posts">My posts</Link></li>
                                <li>
                                    <div className="nav navbar-nav navbar-left">
                                        <ComboBox />
                                    </div>
                                </li>
                            </ul>

                            <ul className="nav navbar-nav navbar-right">
                                <li><p className="navbar-text navbar-right">Signed in as { user.username }. <a href="/logout" className="navbar-link">Logout</a></p></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        );
    }
}

export default withRouter(Header);
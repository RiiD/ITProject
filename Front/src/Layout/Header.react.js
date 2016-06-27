import React from "react";

export default class Header extends React.Component {
    render() {
        const { user } = this.props;
        return (
            <div className="row">
                <nav className="navbar navbar-default">
                    <div className="container-fluid">
                        <div className="navbar-header">
                            <a className="navbar-brand" href="#">
                                AfekaFace
                            </a>
                        </div>
                        <div className="navbar-collapse">
                            <p className="navbar-text navbar-right">Signed in as { user.username }. <a href="/logout" className="navbar-link">Logout</a></p>
                        </div>
                    </div>
                </nav>
            </div>
        );
    }
}
import React from "react";
import Header from "./Header.react";
import Footer from "./Footer.react";
import Home from "../Home/Home.react";

const Layout = React.createClass({

    getInitialState: function() {
        return {
            isLoading: true,
            user: {}
        };
    },

    loadUser: function() {
       fetch("/user", {credentials: 'include'}).then(response => response.json()).then(user => {
           this.setState({
               user: user,
               isLoading: false
           });
       });
    },

    componentDidMount: function() {
        this.loadUser();
    },

    render: function() {
        const { children } = this.props;
        const { user, isLoading } = this.state;
        return isLoading ? <div>Loading</div> : (
            <div className="container">
                <Header user={user} />
                <div className="row">
                    { children || <Home /> }
                </div>
                <Footer />
            </div>
        );
    }
});

export default Layout;
import React from "react";
import Header from "./Header.react";
import Footer from "./Footer.react";
import Home from "../Home/Home.react";

const Layout = React.createClass({

    getInitialState: function() {
        return {
            isLoading: true,
            user: {},
            searchFriendQuery: ""
        };
    },

    setSearchFriendQuery: function(query) {
        this.setState({ searchFriendQuery: query });
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
        const { user, isLoading, searchFriendQuery } = this.state;

        const childrenWithProps = React.Children.map(children, child => React.cloneElement(child, { user, searchFriendQuery }));

        return isLoading ? <div>Loading</div> : (
            <div className="container">
                <Header user={user} searchFriendQuery={searchFriendQuery} setSearchFriendQuery={this.setSearchFriendQuery} />
                <div className="row">
                    { childrenWithProps || <Home user={user} /> }
                </div>
                <Footer />
            </div>
        );
    }
});

export default Layout;
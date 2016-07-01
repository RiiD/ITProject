import React from "react";
import FriendList from "./FriendLists.react";

const FriendsController = React.createClass({
    getInitialState: function() {
        return {
            isLoading: true,
            friends: []
        };
    },

    loadFriends: function() {

        const { searchFriendQuery } = this.props;

        fetch("/user/friends.php?query=" + searchFriendQuery, {credentials: 'include'})
            .then(resp => resp.json())
            .then(friends => this.setState({ isLoading: false, friends: friends }));
    },

    componentDidMount: function() {
        this.loadFriends();
    },

    makeFriend(index, friend) {
        const { friends } = this.state;

        let nextFriends = friends.slice(0, index).concat(friends.slice(index + 1));

        this.setState({
            friends: nextFriends
        });

        fetch('/user/friends.php', {
            credentials: 'include',
            method: 'POST',
            body: JSON.stringify({ friend: friend.id })});
    },

    render: function () {
        const { friends, isLoading } = this.state;
        const { searchFriendQuery } = this.props;

        console.log(searchFriendQuery);

        return isLoading ? <div>Loading...</div> : <FriendList friends={friends} makeFriend={this.makeFriend} />
    }
});

export default FriendsController;
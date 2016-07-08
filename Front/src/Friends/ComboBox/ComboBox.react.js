import React from "react";

import Results from "./Results.react.js";

const ComboBox = React.createClass({
    getInitialState: function() {
        return {
            query: "",
            friends: [],
            isSuggestionsVisible: false
        };
    },

    onChange: function() {
        this.setState({
            query: this.inputBox.value,
            isSuggestionsVisible: true
        });
    },

    componentDidUpdate: function (prevProps, prevState) {
        if(this.state.isSuggestionsVisible && prevState.query !== this.state.query) {
            if(this.state.query.length) {
                this.loadFriends(this.state.query);
            } else {
                this.setState({friends: []});
            }
        }
    },

    loadFriends: function(query) {
        fetch("/user/friends.php?query=" + query, {credentials: 'include'})
            .then(resp => resp.json())
            .then(friends => this.setState({ friends }));
    },

    hideSuggestions: function() {
        this.setState({isSuggestionsVisible: false, query: ""});
    },

    componentDidMount: function() {
        window.addEventListener("click", this.hideSuggestions);
    },

    componentWillUnmount: function() {
        window.removeEventListener("click", this.hideSuggestions);
    },

    makeFriend(index) {
        const { friends } = this.state;
        const friend = friends[index];

        let nextFriends = friends.slice(0, index).concat(friends.slice(index + 1));

        this.setState({
            friends: nextFriends
        });

        fetch('/user/friends.php', {
            credentials: 'include',
            method: 'POST',
            body: JSON.stringify({ friend: friend.id })});
    },

    render: function() {
        const { query, isSuggestionsVisible, friends } = this.state;

        return (
            <div className="ComboBox" onClick={ev => ev.stopPropagation()}>
                <input type="text"
                       value={query}
                       onChange={this.onChange}
                       ref={r => this.inputBox = r}
                       className="form-control" placeholder="Find friends..." />
                { isSuggestionsVisible && <Results {...{friends, makeFriend: this.makeFriend}} />}
            </div>
        );
    }
});

export default ComboBox;
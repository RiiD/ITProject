import React from "react";

const Friend = React.createClass({
    render: function() {
        const { friend, makeFriend } = this.props;

        return (
            <div>
                <h3 onClick={makeFriend.bind(null, friend)}>{friend.username}</h3>
                <img src="/images/avatars/{friend.avatar}" alt="friend.avatar" />
            </div>
        );
    }
});

export default Friend;


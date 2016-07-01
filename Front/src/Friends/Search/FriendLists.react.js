import React from "react";
import Friend from "./Friend.react";

const FriendList = React.createClass({
    render: function(){

        let { friends, makeFriend } = this.props;

        return (
            <ul>
                {
                    friends.map(function(friend, index) {
                        return <li key={friend.id}><Friend friend={friend} makeFriend={makeFriend.bind(null, index)} /></li>
                    })
                }
            </ul>
        )
    }
});

export default FriendList;
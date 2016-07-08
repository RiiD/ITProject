import React from "react";

const ResultRow = React.createClass({
    render: function() {
        const {friend, makeFriend} = this.props;

        return (
            <div className="ResultRow">
                <img src={"/images/user/" + friend.id + ".jpg"}/>
                <div className="username">{friend.username}</div>
                <div className="make-friend">
                    <a onClick={makeFriend} href="#">Make friend</a>
                </div>
            </div>
        );
    }
});

export default ResultRow;
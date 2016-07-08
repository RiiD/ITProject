import React from "react";
import ResultRow from "./ResultRow.react.js";

const Results = React.createClass({
    render: function() {
        const {friends, makeFriend} = this.props;

        return (
            <div className="Results">
                <ul className="list-group">
                    { friends.map((friend, index) =>
                        <li key={index} className="list-group-item">
                            <ResultRow friend={friend} makeFriend={makeFriend.bind(null, index)} />
                        </li>) }
                    { friends.length == 0 && <li className="list-group-item"><div>Friends not found!</div></li> }
                </ul>
            </div>
        );
    }
});

export default Results;
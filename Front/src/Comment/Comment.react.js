import React from "react";

const Comment = React.createClass({

    getInitialState: function() {
        return {
            user: {},
            isLoading: true
        };
    },

    componentDidMount: function() {
        const { comment: {user} } = this.props;

        this.getUser(user);
    },

    getUser: function(id) {
        fetch("/user/?id=" + id, {credentials: 'include'})
            .then(resp => resp.json())
            .then(user => this.setState({ isLoading: false, user }));
    },

    render: function(){
        const { comment: {body} } = this.props;
        const { user, isLoading } = this.state;

        return (
            <div className="Post">
                <div className="row">
                    <div className="col-md-12">
                        <b>Author:</b>
                        <span>{isLoading ? "loading..." : user.username}</span>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-offset-1 col-md-11">
                        <p>{body}</p>
                    </div>
                </div>
            </div>
        );
    }
});

export default Comment;
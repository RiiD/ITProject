import React from "react";

const Post = React.createClass({

    like: function() {
        const { post, postSave } = this.props;

        postSave(Object.assign({}, post, {likes: post.likes + 1}));
    },

    render: function(){

        const { post: {user, title, body, likes, } } = this.props;

        return (
            <div className="Post">
                <h2>{user} </h2>
                <h2>{title} </h2>
                <p>{body}</p>
                <button type="button" onClick={this.like}>Like</button>
                <h4>{likes}</h4>
            </div>
        );
    }
});

export default Post;
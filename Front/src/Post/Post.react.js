import React from "react";
import { Link } from "react-router";
const Post = React.createClass({

    like: function() {
        const { post, postSave } = this.props;

        postSave(Object.assign({}, post, {likes: post.likes + 1}));
    },

    render: function(){

        const { post: {id, user, title, body, likes, } } = this.props;

        return (
            <div className="Post">
                <h2>{user} </h2>
                <Link to={"/post/" + id} >
                    <h2>{title} </h2>
                </Link>
                <p>{body}</p>
                <button type="button" onClick={this.like}>Like</button>
                <h4>{likes}</h4>
            </div>
        );
    }
});

export default Post;
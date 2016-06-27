import React from "react";
import Post from "./Post.react";

const PostList = React.createClass({
    render: function(){

        let { posts, postSave } = this.props;

        return (
            <ul>
                {
                    posts.map(function(post, index) {
                        return <li key={post.id}><Post post={post} postSave={postSave.bind(null, index)} /></li>
                    })
                }
            </ul>
        )
    }
});

export default PostList;
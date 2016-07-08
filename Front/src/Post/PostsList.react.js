import React from "react";
import Post from "./Post.react";

const PostList = React.createClass({
    render: function(){

        let { posts, postSave, location } = this.props;

        return (
            <ul className="list-unstyled">
                {
                    posts.map(function(post, index) {
                        return (
                            <li key={post.id}>
                                <Post post={post} postSave={postSave.bind(null, index)} location={ location } />
                            </li>
                        );

                    })
                }
            </ul>
        )
    }
});

export default PostList;
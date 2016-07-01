import React from "react";
import CommentController from "../Comment/CommentController.react";

const PostPage = React.createClass({

    getInitialState: function() {
        return {
            isLoading: true,
            post: {},
            user: {}
        };
    },

    componentDidMount: function() {
        const { params: { id } } = this.props;

        this.getPost(id);
    },

    getPost: function(id) {
        fetch("/post/?id=" + id, {credentials: 'include'})
            .then(resp => resp.json())
            .then(post => {
                this.setState({ post });
                return post.user;
            })
            .then(this.getUser);
    },

    getUser: function(id) {
        fetch("/user/?id=" + id, {credentials: 'include'})
            .then(resp => resp.json())
            .then(user => this.setState({ isLoading: false, user }));
    },

    render: function() {
        const { isLoading, post, user } = this.state;

        return isLoading ? <div>Loading...</div> : (
            <div>
                <div className="row">
                    <div className="col-md-12">
                        <h1>{ post.title }</h1>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6">
                        <h5><b>Author</b>: {user.username}</h5>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <p>{post.body}</p>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <h5>Comments:</h5>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-offset-1 col-md-11">
                        <CommentController postId={post.id} />
                    </div>
                </div>
            </div>
        );
    }

});

export default PostPage;
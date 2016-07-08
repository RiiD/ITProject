import React from "react";
import CommentController from "../Comment/CommentController.react";
import PostImages from "./PostImages.react";

const PostPage = React.createClass({

    getInitialState: function() {
        return {
            isLoading: true,
            post: {}
        };
    },

    componentDidMount: function() {
        const { params: { id } } = this.props;

        this.getPost(id);
    },

    like: function(ev) {
        const { post } = this.state;
        const nextPost = Object.assign({}, post, {likes: post.likes + 1});

        ev.preventDefault();

        this.setState({
            post: nextPost
        });

        this.postSave(nextPost);
    },

    postSave(post) {
        fetch('/post/index.php', {
            credentials: 'include',
            method: 'PUT',
            body: JSON.stringify(post)});
    },

    getPost: function(id) {
        fetch("/post/?id=" + id, {credentials: 'include'})
            .then(resp => resp.json())
            .then(post => this.setState({ post, isLoading: false }));
    },

    render: function() {
        const { isLoading, post, post: { user } } = this.state;

        return isLoading ? <div>Loading...</div> : (
            <div>
                <div className="panel panel-default">
                    <div className="panel-heading">
                        <div className="row">
                            <div className="col-md-10">
                                <h4>{ post.title }</h4>
                                <p><b>Author</b>: {user.username}</p>
                            </div>
                            <div className="col-md-1">
                                <span>{post.likes}</span>
                            </div>
                            <div className="col-md-1">
                                <a href="Like" onClick={this.like}>
                                    <span className="glyphicon glyphicon-thumbs-up pull-right" aria-hidden="true" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div className="panel-body">
                        {post.body}
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        {post.imgs.length > 0 && <PostImages images={post.imgs} />}
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
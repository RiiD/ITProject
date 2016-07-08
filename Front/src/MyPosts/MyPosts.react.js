import React from "react";
import PostList from "../Post/PostsList.react";
import PostAddController from "../Post/PostAddController.react"

const MyPosts = React.createClass({
    getInitialState: function() {
        return {
            isLoading: true,
            posts: []
        };
    },

    loadPosts: function() {
        fetch("/post/index.php", {credentials: 'include'})
            .then(resp => resp.json())
            .then(posts => this.setState({ isLoading: false, posts: posts }));
    },

    componentDidMount: function() {
        this.loadPosts();
    },

    addPost: function(post) {
        const { posts } = this.state;

        this.setState({
            posts: [post, ...posts]
        });
    },

    postSave(index, post) {
        const { posts } = this.state;

        let nextPosts = posts.slice(0);

        nextPosts[index] = post;

        this.setState({
            posts: nextPosts
        });

        fetch('/post/index.php', {
            credentials: 'include',
            method: 'PUT',
            body: JSON.stringify(post)});
    },

    render: function () {
        const { posts, isLoading } = this.state;

        return isLoading ? <div>Loading...</div> : (
            <div className="row">
                <div className="col-md-12">
                    <PostAddController onAddPost={this.addPost} />
                </div>
                <div className="col-md-12">
                    <PostList posts={posts} postSave={this.postSave} location="MyPosts" />
                </div>
            </div>
        )
    }
});

export default MyPosts;
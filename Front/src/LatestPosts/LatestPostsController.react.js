import React from "react";
import PostList from "../Post/PostsList.react";

const LatestPostsController = React.createClass({
    getInitialState: function() {
        return {
            isLoading: true,
            posts: []
        };
    },
    
    loadPosts: function() {
        fetch("/user/posts.php", {credentials: 'include'})
            .then(resp => resp.json())
            .then(posts => this.setState({ isLoading: false, posts: posts }));
    },

    componentDidMount: function() {
        this.loadPosts();
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

        return isLoading ? <div>Loading...</div> : <PostList posts={posts} postSave={this.postSave} />
    }
});

export default LatestPostsController;
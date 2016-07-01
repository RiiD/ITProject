import React from "react";
import CommentList from "./CommentList.react";

const CommentController = React.createClass({

    createComment : function(body){
        const { postId } = this.props;
        const { comments } = this.state;

        fetch('/comment/index.php', {
            credentials: 'include',
            method: 'POST',
            body: JSON.stringify({ body, postId })})
            .then(resp => resp.json())
            .then(comment => this.setState({ comments: [...comments, comment] }));
    },
    getInitialState: function() {
        return {
            comments: [],
            isLoading: true
        };
    },

    componentDidMount: function() {
        const { postId } = this.props;

        console.log(postId);

        this.getComments(postId);
    },

    getComments: function(postId) {
        fetch("/comment/?postId=" + postId, {credentials: 'include'})
            .then(resp => resp.json())
            .then(comments => this.setState({ isLoading: false, comments }));
    },

    render: function() {
        const { comments } = this.state;

        return <CommentList createComment={this.createComment} comments={comments} />
    }
});

export default CommentController;
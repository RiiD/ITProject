import React from "react";
import Comment from "./Comment.react";
import CommentForm from "./CommentForm.react";

const CommentList = React.createClass({
    render: function() {
        const { comments, createComment } = this.props;

        return (
            <div className="CommentList">
                <div className="row">
                    <div className="col-md-12">
                        <ul className="list-unstyled">
                            {
                                comments.map(function(comment) {
                                    return <li key={comment.id}><Comment comment={comment} /></li>
                                })
                            }
                        </ul>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <CommentForm createComment={createComment} />
                    </div>
                </div>
            </div>

        );
    }
});

export default CommentList;
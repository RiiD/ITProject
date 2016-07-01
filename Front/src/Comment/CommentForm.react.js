import React from "react";

const CommentForm = React.createClass({

    onSubmit: function() {
        const { createComment } = this.props;
        const body = this.textArea.value;

        this.textArea.value = "";
        createComment(body);
    },

    render: function() {
        return (
            <div className="CommnetForm">
                <div className="row">
                    <div className="col-md-12">
                        <h4>Add comment:</h4>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        <textarea ref={r => this.textArea = r} className="form-control" rows="3"></textarea>
                        <button type="button" className="btn btn-primary" onClick={this.onSubmit}>Submit</button>
                    </div>
                </div>
            </div>

        );
    }
});

export default CommentForm;
import React from "react";

const PostAddController = React.createClass({
    getInitialState: function() {
        return {
            numberOfFiles: 1
        };
    },

    onSubmit : function(ev){

        const { onAddPost } = this.props;

        ev.preventDefault();

        fetch('./post/index.php', {
            credentials : 'include',
            method : 'POST',
            body : new FormData(ev.target)
        })
            .then(resp => resp.json())
            .then(onAddPost);

    },

    addFileField: function(ev) {
        const { numberOfFiles } = this.state;

        ev.preventDefault();

        this.setState({
            numberOfFiles: numberOfFiles + 1
        });
    },

    render: function(){
        const { numberOfFiles } = this.state;

        return (
        <div className="PostAdd well">
            <h3>Add post</h3>
            <form onSubmit={this.onSubmit}>
                <div class="form-group">
                    <label htmlFor="title">Title</label>
                    <input type="text" className="form-control" rows="3" name="title" id="title" />
                </div>

                <div class="form-group">
                    <label htmlFor="body">Body</label>
                    <textarea className="form-control" rows="3" name="body" id="body" />
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="isPrivate" /> Private post
                    </label>
                </div>

                <div class="form-group">
                    <label>Images</label>
                { Array
                    .apply(null, {length: numberOfFiles})
                    .map(Function.call, Number)
                    .map((i) => <input key={i} type="file" name="file[]" id="file[]" accept="image/jpeg" />)
                }
                </div>
                <div>
                    <a onClick={this.addFileField} href="Add file">Add file</a>
                </div>
                <button type="submit" className="btn btn-primary">Submit</button>
            </form>
        </div>
        )
    }
});

export default PostAddController;
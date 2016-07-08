import React from "react";
import { Link } from "react-router";

const Post = React.createClass({

    save: function(newPost) {
        const { postSave } = this.props;

        postSave(newPost);
    },

    render: function(){

        const { post, post: {id, user, title, likes, isPrivate}, location } = this.props;

        return (
            <div className="Post well">
                <div className="row">
                    <div className="col-md-10">
                        <Link to={"/post/" + id} ><h2>{title} </h2></Link>
                        <p>Author: {user.username}</p>
                    </div>
                    <div className="col-md-2">
                        { location == "MyPosts" ?
                            <div>
                                <h4>Private: </h4>
                                <input type="checkbox"
                                       checked={ isPrivate }
                                       onChange={ this.save.bind(null, Object.assign({}, post, {isPrivate: !isPrivate }))} />
                            </div>
                            :
                            <div>
                                <h4>{likes}</h4>
                                <button type="button"
                                        onClick={this.save.bind(null, Object.assign({}, post, { likes: likes + 1}))}>Like</button>
                            </div>
                        }
                    </div>
                </div>
            </div>
        );
    }
});

export default Post;
import React from "react";

const PostImages = React.createClass({
    getInitialState: function() {
        return {
            currentImage: 0
        };
    },

    selectImage: function(index) {
        this.setState({
            currentImage: index
        });
    },

    render: function() {
        const { images } = this.props;
        const { currentImage } = this.state;

        return (
            <div className="PostImages">
                <div className="row">
                    <div className="col-md-12">
                        <img src={ "/images/post/" + images[currentImage].name } className="img-rounded" width="100%"/>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        { images
                            .map((img, index) => <img key={index}
                                                      onClick={this.selectImage.bind(null, index)}
                                                      src={ "/images/post/thumb/" + images[index].name }
                                                      className="img-thumbnail"/>) }
                    </div>
                </div>
            </div>
        );
    }
});

export default PostImages;
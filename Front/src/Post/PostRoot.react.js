import React from "react";

export default class PostRoot extends React.Component {
    render() {
        const { children } = this.props;
        return (
            <div className="PostRoot">
                { children }
            </div>
        );
    }
}
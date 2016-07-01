import React from "react";
import { Link, withRouter } from "react-router";

class Header extends React.Component {
    render() {
        const { user, searchFriendQuery, setSearchFriendQuery, router } = this.props;
        
        return (
            <div className="row">
                <nav className="navbar navbar-default">
                    <div className="container-fluid">
                        <div className="navbar-header">
                            <Link className="navbar-brand" to="/">
                                AfekaFace
                            </Link>
                        </div>
                        <div className="collapse navbar-collapse" classID="bs-example-navbar-collapse-1">
                            <ul className="nav navbar-nav">
                                <li className="active"><Link to="/posts">Posts</Link></li>
                            </ul>
                            <form className="navbar-form navbar-left" role="search" onSubmit={ e => { e.preventDefault(); router.push("/search-friends"); } }>
                                <div className="form-group">
                                    <input type="text"
                                           className="form-control"
                                           placeholder="Search friends"
                                           ref={r => this.s = r}
                                           value={searchFriendQuery}
                                           onChange={() => { setSearchFriendQuery(this.s.value) }} />
                                </div>
                                <Link className="btn btn-default" to="/search-friends" role="button">Find</Link>
                            </form>
                            <ul className="nav navbar-nav navbar-right">
                                <li><p className="navbar-text navbar-right">Signed in as { user.username }. <a href="/logout" className="navbar-link">Logout</a></p></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        );
    }
}

export default withRouter(Header);
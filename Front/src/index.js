import React from "react";
import ReactDOM from "react-dom";
import Layout from "./Layout/Layout.react";
import Home from "./Home/Home.react";
import PostRoot from "./Post/PostRoot.react.js";
import CreatePost from "./Post/Create.react";
import FriendsController from "./Friends/Search/FriendsController.react.js";
import PostPage from "./Post/PostPage.react";

import { Router, Route, browserHistory } from 'react-router'

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={Layout}>
            <Route path="about" component={Home}/>
            <Route path="post" component={PostRoot}>
                <Route path=":id" component={PostPage} />
                <Route path="create" component={CreatePost}/>
            </Route>
            <Route path="search-friends" component={FriendsController} />
        </Route>
    </Router>, document.getElementById('app'));
import React from "react";
import ReactDOM from "react-dom";
import Layout from "./Layout/Layout.react";
import Home from "./Home/Home.react";
import PostRoot from "./Post/PostRoot.react.js";
import CreatePost from "./Post/PostAddController.react.js";
import PostPage from "./Post/PostPage.react";
import MyPosts from "./MyPosts/MyPosts.react";

import { Router, Route, browserHistory } from 'react-router'

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={Layout}>
            <Route path="about" component={Home}/>
            <Route path="post" component={PostRoot}>
                <Route path=":id" component={PostPage} />
                <Route path="create" component={CreatePost}/>
            </Route>
            <Route path="my-posts" component={MyPosts} />
        </Route>
    </Router>, document.getElementById('app'));
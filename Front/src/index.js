import React from "react";
import ReactDOM from "react-dom";
import Layout from "./Layout/Layout.react";
import Home from "./Home/Home.react";
import PostRoot from "./Post/PostRoot.react.js";
import CreatePost from "./Post/Create.react";

import { Router, Route, browserHistory } from 'react-router'

ReactDOM.render(
    <Router history={browserHistory}>
        <Route path="/" component={Layout}>
            <Route path="about" component={Home}/>
            <Route path="post" component={PostRoot}>
                <Route path="create" component={CreatePost}/>
            </Route>
        </Route>
    </Router>, document.getElementById('app'));
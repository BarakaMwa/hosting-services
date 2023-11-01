import ReactDOM from "react-dom";
import React from "react";
import Intro from "./Intro";
import App from "./AppClass";
import "./index.css";

const appTitle = "My First Real React Lesson";

ReactDOM.render(
    <React.StrictMode>
        {/*<div className={"container"}>
            <h1>Baraka Mwang'amba</h1>
        </div>*/}
        {/*<h1>Baraka Mwang'amba</h1>*/}
        {/*{React.createElement("h1", {className: 'title'}, "Baraka Mwang'amba")}*/}
        {/*{div}*/}
        <App title={appTitle}/>
        <Intro/>
    </React.StrictMode>,
    document.getElementById('root')
)
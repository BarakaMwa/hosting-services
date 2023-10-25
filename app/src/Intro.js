import React from "react";
import Counter from "./Counter";

let intro = React.createElement("h3", {className: "intro"}, "Hey Guys");

function Intro() {
    return (
        <div>
            {intro}
        <Counter/>
        </div>
    )
}

export default Intro;
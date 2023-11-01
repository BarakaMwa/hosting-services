import React from "react";
import Counter from "./CounterClass";

let intro = React.createElement("h3", {className: "intro"}, "Hey Guys");

class Intro extends React.Component {
    render() {
        return(
            <intro>
                {intro}
                <Counter/>
            </intro>

        )
    }
}
export default Intro;
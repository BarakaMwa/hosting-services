import React from "react";

function Minus (props) {
    return (
        <button
            className={"button-minus"}
            onClick={() => props.handleClick(-1)}
        >{props.title}</button>
    )
}

export default Minus;
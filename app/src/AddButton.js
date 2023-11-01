import React from "react";

function Add(props) {

    return (
        <button
            className={"button-add"}
            onClick={() => props.handleClick(1)}
        >{props.title}</button>
    )

}
export default Add;

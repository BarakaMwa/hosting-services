import React from "react";

class MinusButton extends React.Component {
    render() {
        return (
            <button
                className={"button-minus"}
                onClick={() => {this.props.handleClick(-1)}}
                // onClick={function() {this.props.handleClick(-1)}}
            >{this.props.title}</button>
        )
    }
}

export default MinusButton;
import React from "react";

class AddButton extends React.Component {

    render() {
        return (
            <button
                className={"button-add"}
                onClick={() => this.props.handleClick(1)}
            >{this.props.title}</button>
        )
    }

}

export default AddButton;
import React from "react";
import AddButton from "./AddButtonClass";
import MinusButton from "./MinusButtonClass";

class Counter extends React.Component {

    /*constructor(){
        super();
        this.state = {
            counter: 0
        }
    }*/

    state = {
        counter: 0
    }

    addCount = (num) => {
        // debugger
        this.setState({
            counter: this.state.counter + num
        });
    }

    render() {
        // debugger
        return (
            <counter>
                <h4 className={"counter"}>Counter : {this.state.counter} </h4>
                <AddButton title={"Add"} counter={this.state.counter} handleClick={this.addCount}/>
                <MinusButton title={"Minus"} counter={this.state.counter} handleClick={this.addCount}/>
            </counter>
        )
    }
}

export default Counter;
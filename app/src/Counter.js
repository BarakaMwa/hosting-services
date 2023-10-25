import React, {useState} from "react";
import Add from "./AddButton";
import Minus from "./MinusButton";

function Counter() {

    const [counter, setCounter] = useState(0);

    function add(num){
        console.log(num);
        setCounter(counter + num)
    }

    return(
        <div>
            <h4 className={"counter"}>Counter : {counter} </h4>
            <Add title={"Add"} handleClick={add} />
            <Minus title={"Minus"} handleClick={add} />
        </div>
    )

}

export default Counter;
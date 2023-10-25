import React from "react";



 function App (props){
     const h1 = React.createElement("h1", null, props.title);
     let name = React.createElement("div", {className: "container"}, h1);
    return(
        <div>
            {name}
        </div>
    )
}

export default App;
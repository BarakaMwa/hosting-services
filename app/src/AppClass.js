import React from "react";

class App extends React.Component{
    h1 = React.createElement("h1", null, this.props.title);
    name = React.createElement("div", {className: "container"}, this.h1);
    render() {
        return(
            <app>
                {this.name}
            </app>

        )
    }
}
export default App;
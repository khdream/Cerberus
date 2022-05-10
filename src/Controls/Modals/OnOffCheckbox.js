import React from "react";

class OnOffCheckbox extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      status: props.status,
    };
  }

  componentWillReceiveProps(newProps) {
    this.setState({
      status: newProps.status,
    });
  }

  ClickBTN() {
    let status = this.state.status;
    if (Number(this.state.status) === 1) {
      status = "0";
    } else {
      status = "1";
    }
    this.setState({status});
    if (this.props.callback) {
      this.props.callback(status, this.props.name);
      this.forceUpdate();
    }
  }

  render() {
    return (
      <div className="d-flex my-1">
        <i
          class={`pointer ${
            Number(this.state.status) === 1 ? "fa-green fas fa-check-circle" : "fa-gray far fa-circle"
          }`}
          onClick={this.ClickBTN.bind(this)}
          style={{
            fontSize: 24,
            marginRight: 5
          }}
        ></i>
        <span className="text-nowrap">{this.props.label}</span>
      </div>
    );
  }
}

export default OnOffCheckbox;

import React from 'react';

class OnOffSwitcher extends React.Component {
    constructor(props)
    {
        super(props);
        this.state = {
            status: props.status
        };
    }

    componentWillReceiveProps(newProps) {
        this.setState({
            status: newProps.status
        })
    }

    ClickBTN() {
	let status = this.state.status;
        if(Number(this.state.status) === 1) {
            status = '0';
        }
        else {
            status = '1';
        }
	this.setState({status});
        this.props.callback(status, this.props.name);
        this.forceUpdate();
    }

    render() {
        return(
            <React.Fragment>
                <button type="button" style={({lineHeight:'10px', float:'right', width: '56px'})} onClick={this.ClickBTN.bind(this)} class={"btn " + (Number(this.state.status) === 1 ? "btn-success" : "btn-outline-danger")}>{(Number(this.state.status) === 1 ? "ON" : "OFF")}</button>
            </React.Fragment>
        );
    }
}

export default OnOffSwitcher;

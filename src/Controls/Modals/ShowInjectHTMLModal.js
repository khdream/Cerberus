import React from 'react';
import SettingsContext from '../../Settings';
import { try_eval } from '../../serviceF';

class ShowInjectHTMLModal extends React.Component {
    
    constructor(props)
    {
        super(props);
        this.state = {
        };
    }

    UpdateLogsModal() {
        this.forceUpdate();
    }

    componentWillReceiveProps() {
        this.forceUpdate();
    }

    CloseModal() {
        try_eval('$("#ShowInjectModal").modal("hide");');
    }
    

    render () {
        let TitleMODAL = 'Inject ' + SettingsContext.InjectSelectedAPPName;
        return (
            //<!-- Modal -->
            <div className="modal fade" id="ShowInjectModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div className="modal-dialog" role="document" style={({maxWidth:'50%'})}>
                <div className="modal-content" style={({minHeight:"80vh"})}>
                <div className="modal-header">
                    <h5 className="modal-title" id="exampleModalLongTitle">{TitleMODAL}</h5>
                    <button type="button" className="close" data-dismiss="modal" aria-label="Close" onClick={this.CloseModal.bind(this)}>
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div className="modal-body">
                    <iframe src={'data:text/html;base64,' + SettingsContext.HTMLShowContentBase64} width="100%" height="100%" title="show inject html modal" />
                </div>
                </div>
            </div>
            </div>
        );
    }
}

export default ShowInjectHTMLModal;

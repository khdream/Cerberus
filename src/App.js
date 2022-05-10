import React from 'react';

import LeftBar from './SideBar/LeftBar';
import ContentManager from './ContentManager/ContentManager';
//import {try_eval} from './serviceF';

// Главный класс инициализации приложения
const App = () => (
  <div class="wrapper">
    <LeftBar />
    {/* <i class="fal fa-ellipsis-v-alt leftbarmenu" onClick={() => {
        try_eval('document.getElementById("sidebar").style.display = "block";document.getElementById("blackbox").style.display = "block";');
    }}/>
    <div id="blackbox"  onClick={() => {
        try_eval('document.getElementById("sidebar").style.display = "";document.getElementById("blackbox").style.display = "";');
    }}/> */}
    <ContentManager />
  </div>
);

export default App;

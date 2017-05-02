<?php
ini_set("display_errors","on");

print "<header class='mdl-layout__header'>";
   print "<div class='mdl-layout__header-row'>";
   //<img src="imagens/logo.png" alt="wecash">
      print "<span class='mdl-layout-title'>WeCash</span>";
      print "<div class='mdl-layout-spacer'></div>";
      print "<span class='header-current__total'></span>";
   print "</div>";
   print "<div class='mdl-layout__tab-bar mdl-js-ripple-effect'>";
      print "<a href='#tab_movimentacao' class='mdl-layout__tab' id='movimentacao'>Movimentacao</a>";
      print "<a href='#tab_historico' class='mdl-layout__tab is-active' id='historico'>Histórico</a>";
      print "<a href='#tab_planejamento' class='mdl-layout__tab' id='planejamento'>Planejamento</a>";
   print "</div>";
print "</header>";
print "<div class='mdl-layout__drawer'>";
   print "<span class='mdl-layout-title'>";
      print "<div class='back-title'>";
         print "<div id='conteudo-title'>";
            print "<ul class='list-title'>";
               print "<li><img class='img_user_title mdl-button--raised' src='imagens/foto.gif'></li>";
               print "<li class='user-info-1'>Lucas Macedo Dimatteu Telles</li>";
               print "<li class='user-info-2'>lucas123@hotmail.com</li>";
            print "</ul>";
            print "<div class='hr'></div>";
         print "</div>";
      print "</div>";
   print "</span>";
   print "<nav class='mdl-navigation'>";
         print "<ul class='navigation-list' style='list-style-type:none;padding:10px;margin-top:10px;'>";
            print "<li><a class='mdl-navigation__link' id='goToGraficos' href='javascript:void(0);'><img src='imagens/chart-bar.png' class='menu-icon'>Gráficos</a></li>";
            print "<li><a class='mdl-navigation__link' id='goToSettings' href='javascript:void(0);'><img src='imagens/settings.png' class='menu-icon'>Configurações</a></li>";
            print "<li><a class='mdl-navigation__link' id='getOut' href='javascript:void(0);'><img src='imagens/exit-to-app.png' class='menu-icon'>Sair</a></li>";
         print "</ul>";
      print "</nav>";
print "</div>";

?>
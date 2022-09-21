<?php
// include_once ("../autoloader.php");
// instantiate navigation class
$navigation = new Navigation();
//fetch navigation items
$navitems = $navigation->getNavigation();
// echo '<pre>' . print_r($_SESSION,1) . '</pre>';
?>
<div class="navbar navbar-inverse">
  <div class="navbar-header">
    <a href="index.php" class="navbar-brand">
            <img src="images/overwatch_logo2.png" alt="Overwatch Logo">
    </a>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
      <div class="icon-bar"></div>
      <div class="icon-bar"></div>
      <div class="icon-bar"></div>
    </button>
  </div>
  <div class="collapse navbar-collapse" id="navbar-menu">
    <ul class="nav navbar-nav navbar-right">
      <?php
      //render navigation items
      //render the navigation by looping through array
      foreach ($navitems as $item) {
        $link = $item["page_link"];
        $name = $item["page_name"];
        echo "<li><a href=\"$link\">$name</a></li>";
      }
      ?>
    </ul>
  </div>
</div>
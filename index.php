<?php
  $M_DataSource = "company";
  $M_UserID = "webguest";
  $M_PWD = "password";
  $link = @odbc_connect($_DataSource, $M_UserID, $M_PWD);
  if (!$link) {
     exit("Error " . odbc_error() . " ! - " . odbc_errormsg() . ".");
  }
  $txtsql = "SELECT * FROM ItemMaster WHERE Class='4' ORDER BY ItenNo";
  $itemresuit = odbc_exec($link, $txtsql);
  print "table border='1'>";
  while ($itemrow = odbc_fetch_array($itemresuit)){
    print "<tr>";
    print "<tr>" . $itemrow["ItemNo"];
    print "<tr>" . $itemrow["Desc"];
    print "<tr>" . $itemrow["class"];
    print "<tr>" . $itemrow["type"];
  }
  PRINT "</table>";
  odbc_close($link);
?>

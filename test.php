<html>
<?php
if ($c=OCILogon("ora_o1c0b", "a55307145", "ug")) {
  echo "Successfully connected to Oracle.\n";
  OCILogoff($c);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}
?>
</html>

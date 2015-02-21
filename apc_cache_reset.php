<html>
<PRE>
<?php
$key_names = [
  '_ah_app_identity_:https://www.googleapis.com/auth/devstorage.read_only',
  '_ah_app_identity_:https://www.googleapis.com/auth/devstorage.read_write',
];


foreach($key_names as $key) {
  print 'Resetting: ' . $key . ' ';
  print apc_delete($key) ? 'OK' : 'FAILED';
  print PHP_EOL;
}
?>
</PRE>
</html>
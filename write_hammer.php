<?php

$bucket_name = \google\appengine\api\cloud_storage\CloudStorageTools::getDefaultGoogleStorageBucketName();
$file_name = 'gs://' . $bucket_name . '/' . uniqid() . '.txt';
$data = 'The time is now ' . date('m/d/Y h:i:s a', time());

$ctx = stream_context_create([
   'gs' => [
       'Content-Type' => 'text/plain',
       'acl' => 'private',
       'enable_cache' => false,
   ],
]);

if (!file_put_contents($file_name, $data, 0, $ctx)) {
  syslog(LOG_ERR, 'Could not write file.');
}

$result = file_get_contents($file_name, false, $ctx);
if ($result === false) {
  syslog(LOG_ERR, 'Could not read back file.');
}
if ($result !== $data) {
  syslog(LOG_ERR, 'Data read back does not match');
}

if (!unlink($file_name)) {
  syslog(LOG_ERR, 'Could not unlink file.');
}

$task = new \google\appengine\api\taskqueue\PushTask('/write_hammer');
$queue = new \google\appengine\api\taskqueue\PushQueue('write-hammer-queue');
$queue->addTasks([$task]);

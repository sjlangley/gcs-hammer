<?php

if (!apc_clear_cache('user')) {
  syslog(LOG_DEBUG, 'Could not clear the apc_cache');
} else {
  echo 'Cache Reset';
}
#!/bin/bash
export PHP_VER=82
/usr/sbin/php-fpm$PHP_VER
status=$?
if [ $status -ne 0 ]; then
  echo "Failed to start php-fpm: $status"
  exit $status
fi
echo "Started php-fpm succesfully"
while sleep 60; do
  ps |grep php-fpm$PHP_VER |grep -v grep
  PROCESS_1_STATUS=$?
  if [ -f $PROCESS_1_STATUS ]; then
    echo "PHP-FPM has already exited."
    exit 1
  fi
done

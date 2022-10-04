#!/bin/bash
echo "Be sure to start a normal PHP server first:"
echo "php -S localhost:8111 -t public"
echo "Usage: normalphp.sh ntp|ipsum|prime|weather"
curl -X GET http://localhost:8111?action=$1

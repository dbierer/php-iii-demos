#!/bin/bash
echo "Be sure to start a normal PHP server first:"
echo "php -S localhost:8111 -t public"
echo "Be sure to start a ReactPHP server first:"
echo "php public/react.php"
echo "Usage: both.sh ntp|ipsum|prime|weather [ntp|ipsum|prime|weather]"
curl -X GET http://localhost:8111?action=$1
curl -X GET http://localhost:8222?action=$1
if [[ ! -z $2 ]]; then
    curl -X GET http://localhost:8111?action=$2
    curl -X GET http://localhost:8222?action=$2
fi


#!/bin/bash
if [[ $# -eq 0 || "$1" = "--help" ]]; then
    echo "Be sure to start a normal PHP server first:"
    echo "php -S localhost:8111 -t public"
    echo "Usage: normalphp.sh ntp|ipsum|prime|city|weather"
    exit 0
fi
curl -X GET http://localhost:8111?action=$1

#!/bin/bash
if [[ $# -eq 0 || "$1" = "--help" ]]; then
    echo "Be sure to start a ReactPHP server first:"
    echo "php public/react_server.php"
    echo "Usage: reactphp.sh ntp|ipsum|prime|city|weather"
    exit 0
fi
curl -X GET http://localhost:8222?action=$1

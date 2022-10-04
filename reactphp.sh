#!/bin/bash
echo "Be sure to start a ReactPHP server first:"
echo "php public/react.php"
echo "Usage: reactphp.sh ntp|ipsum|prime|weather"
curl -X GET http://localhost:8222?action=$1

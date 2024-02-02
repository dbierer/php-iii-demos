# Middleware Demo

## To install
Install dependencies using composer:
```
./composer.phar install
```

## Run the built-in PHP webserver
Open a terminal window and run:
```
php -S localhost:9999 -t public
```

## Make a request
Open another terminal window and run:
```
curl -X GET http://localhost:9999
curl -X GET http://localhost:9999?id=1
```

## Post data
From a terminal window run:
```
curl -X POST \
	-F status=open \
	-F amount=99.99 \
	-F description="Covid-19 vaccine" \
	-F customer=1 \
	http://localhost:9999
```

## Delete data
From a terminal window run:
```
curl -X DELETE http://localhost:9999?id=12
```

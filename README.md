# Example API

This is an example API which uses a handful of libraries available in composer to demonstrate a few simple concepts:

1. Basic "MVC-Style" routing (although in this case we're using single method / invokable controllers, i.e. actions)
2. Clean dependency injection (Dependency wiring is configured early and in a central location, object dependencies are injected from there)
3. Separation of Concerns (persistence layer is obfuscated behind the repository interface which is the most basic interface which we work directly with at the API level)


## Installing

Clone the repo:

```
git clone git@github.com:mattsah/simple-api.git mattsah-simple-api
```

Change directory:

```
cd mattsah-simple-api
```

Composer install for dependencies:

```
composer install
```

## Running

Run a local test server from within the directory you cloned to:

```
php -S localhost:8080 -t public
```

## Using the API

The API is currently schema-less and requires no authentication.

### Create a New User

#### Request

- **Path:** `/api/v1/users/`
- **Method:** POST
- **Query:** N/A
- **Body:**

The HTTP Body can be an `application/x-www-form-urlencoded` and can contain any properties desired.  All properties will be persisted to the new user object and recalled back.

#### Response:

- **Status:** 201 Created
- **Content-Type:** application/json
- **Body:**

The HTTP Body will return the JSON encoded representation of the new user object along with the assigned id.


#### Curl Example:

```
curl -X POST -d "name=Matthew%20J.%20Sahagian&email=matthew.sahagian@gmail.com" http://localhost:8080/api/v1/users/
```

Output:

```
{"id":1,"name":"Matthew J. Sahagian","email":"matthew.sahagian@gmail.com"}
```


### List Users

#### Request

- **Path:** `/api/v1/users/`
- **Method:** GET
- **Query:** N/A
- **Body:** N/A

#### Response:

- **Status:** 200 OK
- **Content-Type:** application/json
- **Body:**

The HTTP Body will return the JSON encoded array of user objects.

#### Curl Example:

```
curl -X GET http://localhost:8080/api/v1/users/
```

Output:

```
[{"id":1,"name":"Matthew J. Sahagian","email":"matthew.sahagian@gmail.com"}]
```


### Select a Single User

#### Request

- **Path:** `/api/v1/users/{id}`
- **Method:** GET
- **Query:** N/A
- **Body:** N/A

#### Response:

- **Status:** 200 OK, 404 Not Found
- **Content-Type:** application/json
- **Body:**

The HTTP Body will return the JSON encode user object whose ID was requested in the path.  If no user can be found, an empty body with a status code of `404` will be returned.


#### Curl Example

```
curl -X GET http://localhost:8080/api/v1/users/1
```

Output:

```
{"id":1,"name":"Matthew J. Sahagian","email":"matthew.sahagian@gmail.com"}
```
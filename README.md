# Tools for Statamic
Various tools commonly used in our Statamic projects.

## Modifiers
### MakeResource
Converts entries or terms to an api resource.  Can be a query or collection.
```antlers
{{ collection | make_resource | to_json | sanitize }}
{{ query | make_resource | to_json | sanitize }}
```

### ApiRouteList
Converts entries or terms to an array of api routes.  Can be a query or collection.
```antlers
{{ collection | api_route_list | to_json | sanitize }}
{{ query | api_route_list | to_json | sanitize }}
```

## Tags
### RandomString
Creates a random string using the `Str::random($length)` Laravel function.  Default length is 20.
```antlers
{{ random_string }}
{{ random_string length="10" }}
```
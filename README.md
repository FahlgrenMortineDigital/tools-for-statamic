# Tools for Statamic
Various tools commonly used in our Statamic projects.

## Modifiers
### MakeResource
Converts entries or terms to an api resource.  Can be a query or collection.
```antlers
{{ collection | make_resource | to_json | sanitize }}
{{ query | make_resource | to_json | sanitize }}
```
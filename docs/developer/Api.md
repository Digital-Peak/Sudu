# API
The front end of Sudu talks to the back end via a laravel powered REST API. In this document we outline the endpoints:

# Files
The files endpoint offers some files interactions.

### List of files in a folder
Method: GET
Path: /api/v1/files/{path}
Authentication: No
Description: Get the list of files in the folder specified by the path
Example: `curl -X GET -H "Accept: application/json" https://example.com/holiday/2021`

![KoalaVM](http://dpr.clayfreeman.com/1kRYJ+ "KoalaVM")

`koalasignd`
============

`koalasignd` is the daemon responsible for signing outgoing payloads targeted
for `koalad`.  `koalasignd` uses a JSON-based API on SSL port `4765` by default.
Outgoing messages are signed with GPG by the daemon using the secret key located
at `data/KoalaCore/gpg.sec`.

Message Structure
=================

Incoming messages must match the following JSON format:

```json
{
  "command": "...",
  <...>
}
```

* `command` is a string containing the name of the command to execute.
* `data` is an optional *protocol agnostic* type of data that `command` expects.

Response
========

`koalasignd` will always respond with a JSON object regarding the status of the
requested operation.  Responses are modeled as such:

```json
{
  "status": "...",
  "message": "...",
  "data": "...",
}
```

Upon success, `status` will have the value `"200"` and `data` will hold the base
64 encoded JSON request for `koalad`.

In general, `message` is a string describing the status of the operation.

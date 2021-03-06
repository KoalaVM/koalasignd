![KoalaVM](http://dpr.clayfreeman.com/1kRYJ+ "KoalaVM")

`koalasignd`
============

`koalasignd` is the daemon responsible for signing outgoing payloads targeted
for `koalad`.  `koalasignd` uses a JSON-based API on SSL port `4765` by default.
Outgoing messages are signed with GPG by the daemon using the secret key located
at `data/KoalaSign/gpg.sec`.

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
* Optional *protocol agnostic* data that `command` expects can also be included.

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

Licensing
=========

This work is licensed under the Creative Commons Attribution-ShareAlike 4.0
International License. To view a copy of this license, visit
http://creativecommons.org/licenses/by-sa/4.0/ or send a letter to Creative
Commons, PO Box 1866, Mountain View, CA 94042, USA.

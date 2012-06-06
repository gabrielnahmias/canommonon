Tweeter
=============

**Canommonon** is a **PHP _script_** that finds the common values between two sets of data (soon to be as many as you'd like).

What can it do?
-----------

* Shows you the commonality between two sets of data
* Can be returned in several different formats.
* Makes you go, _"WHOA!"_

How to use it
-----------

Upload it or otherwise store it on a server with at least PHP5 installed and visit the page!  You can use the form or call it with other scripts, etc.

There are 4 different options (```GET``` variables) you can set.  The first two are required.  They are:

1.  **first** - first set of comma-separated values.
2.  **second** - second set of comma-separated values.

These are extra:

3.  **debug** - show debugging (only in HTML mode).
4.  **format** - the format in which the results should be (JSON, text, etc.).
5.  **hideform** - hide form when showing HTML results.

Examples
-----------

As simple as it gets (of course, you'll change the URL prefix):

```http://localhost/?first=a,b,c&second=a,b,c,d,e```

Here it is with some options:

```http://localhost/?first=a,b,c&second=a,b,c,d,e&debug&hideform```

That would show some debugging information and remove the initial form.  How about some JSON?

```http://localhost/?first=a,b,c&second=a,b,c,d,e&format=json```

Yup.  It's that easy!  That would produce this:

```{ common: ["a", "b", "c"] }```

License
-----------

Public domain

Acknowledgements
------------

Canommonon is a project by [Gabriel Nahmias](http://github.com/terrasoftlabs "Terrasoft's GitHub"), co-founder of Terrasoft.
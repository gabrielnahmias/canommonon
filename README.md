Canommonon
=============

**Canommonon** is a **PHP _script_** that finds the common values between two sets of data (soon to be as many as you'd like).

What does it do?
-----------

* Compares two sets of data with two different methods
* Gives results in several different formats
* Allows for flexible and customizable return data
* Lets you call it remotely by way of a `GET` request
* Makes you go, _"WHOA!"_

How to use it
-----------

Upload it or otherwise store it on a server with at least PHP5 installed and visit the page!  You can use the form or call it with other scripts, etc.

There are 8 different options (```GET``` variables) you can set.  The first two are required.  They are:

1.  **first** - first set of comma-separated values.
2.  **second** - second set of comma-separated values.

These are extra:

3.  **debug** (default: `false`) - show debugging (only in normal mode).
4.  **format** (default: normal) - the format in which the results should be (JSON, text, etc.).
5.  **hideform** (default: `false`) - hide form when showing HTML results.
6.	**operation** (default: common) - the operation to perform (common or uncommon).
7.	**showcode** (default: `false`) - additionally display the results as an array coded in several programming langauges (currently, PHP, JavaScript, Ruby, and Visual Basic).
8.	**showduplicates** (default: `false`) - show if there are multiple copies of the same value with a result set.

Examples
-----------

As simple as it gets (of course, you'll change the URL prefix):

``` http://localhost/?first=a,b,c&second=a,b,c,d,e ```

Here it is with some options:

``` http://localhost/?first=a,b,c,c,c&second=a,b,c,c,d,e&debug&hideform&showcode&showduplicates ```

That would show some debugging information, remove the initial form, show some code, and show duplicates.  How about some JSON?

``` http://localhost/?first=a,b,c&second=a,b,c,d,e&format=json ```

Yup.  It's that easy!  That would produce this:

``` { common: ["a", "b", "c"] } ```

This is an easily accessible data structure that is virtually universal.

License
-----------

Public domain

Acknowledgements
------------

Canommonon is a project by [Gabriel Nahmias](mailto:gabriel@terrasoftlabs.com), co-founder of Terrasoft.
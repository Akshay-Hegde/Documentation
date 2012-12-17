Documentation
=============

A flat-file documentation system for PyroCMS powered by extended Markdown.

Installation
------------

1. Add the documentation module to your default/addons or shared_addons modules folder
2. Ensure that the docs/en folder is writable
3. Add the route below to your system/cms/config/routes.php file

# Route
$route['documentation(/:any)?'] = 'documentation/front/index$1';

After that is added you can access the documentation via /documentation

Usage
-----

In the admin side of things you'll find documentation under the content menu.

From this page you can create new documents by setting the general options, metadata and its' parent. After creating a document you can click on the entry on the left to load the options for this document and click update to save or edit to add content to it. While editing the left hand side will automatically update with how the final version should look.

The flat-file system is powered by a JSON file and a number of markdown text files, these can be distrubted or edited outside of the module and added back in directly after updates have been made.

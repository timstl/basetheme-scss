WordPress theme files to build from. Currently uses Bootstrap 4 Beta 2.

* Download and place in themes folder
* Rename basetheme-scss folder
* Update style.css to include correct theme name
* Update gulpfile.js to include correct site URL for browsersync.
* Install basetheme-helper-plugin: https://github.com/timstl/basetheme-helper-plugin

# In theme directory:
* Run ```npm install```
* Run ```gulp``` to launch browsersync and begin watch tasks.
* Make sure to use your local URL (not browsersync URL) when working in the admin URL.

# Bootstrap
Commenting out any files you don't need in scss/_bootstrap.scss will reduce unnecessary bloat from Bootstrap. By default all are enabled.

# Variables
Override bootstrap variables and create custom variables in scss/_variables.scss. Avoid editing scss bootstrap files themselves.

# Javascript
An example of how to use SSM is located in js/custom/scripts.js. Add any other javascript files you like to these folders. See gulpfile.js for information on the order these are compiled.

# Navigation
Navigation is currently a work in process - still uses Bootstrap 3 methods and needs to be updated.
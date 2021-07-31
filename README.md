This repository is no longer regularly maintained and this theme may not work as intended!

Basetheme is a starter WordPress theme to build from. It relies heavily on Bootstrap and ACF. It includes some basic functionality that we use on most sites. A lot of this may or may not be applicable to your work flow. Be sure to dig in and modify as needed.

# Getting Started

- Download and place in themes folder
- Rename basetheme-scss folder
- Update style.css to include correct theme name
- Update gulpfile.js to include correct site URL for browsersync.
- Install basetheme-helper-plugin: https://github.com/timstl/basetheme-helper-plugin
- Install basetheme-modify-core-blocks: https://github.com/timstl/basetheme-modify-core-blocks

### In theme directory:

- Run `npm install`
- Run `npm start` to launch browsersync and begin watch tasks.
- Make sure to use your local URL (not browsersync URL) when working in the admin URL.

# Configuring

There are several files that you should configure for your specific project.

- **./src/scss/\_bootstrap.scss** - Loads individual Bootstrap files. Some are commented out by default to reduce bloat. Adjust as needed.
- **./src/scss/\_variables.scss** - Here you can override Bootstrap variables and create your own custom variables. This is preferred over modifying anything in the ./src/scss/bootstrap/ folder.
- **./src/scss/\_blocks.scss** - Loads some block CSS into the main theme styles. More on blocks later.
- **./lib/theme-setup.php** - Update font URLs in the bt_fonts() function. May also need to adjust menus, sidebars, image sizes, etc.
- **./lib/theme-acfblocks.php** - Update constants for ACF blocks, uncomment any pre-built blocks you may need, and create custom blocks here.

This theme also includes many custom field groups in the acf-json folder. After installing ACF, use the "Sync Available" feature to import these field groups. You may wish to delete some field groups for blocks that you don't intend to use.

# Blocks

This basetheme includes several pre-made ACF Blocks. These are mostly unstyled, and by default only Bootstrap Buttons and Bootstrap Button Group blocks are enabled. The other blocks included are commented out in ./lib/theme-acfblocks.php.

Most of these blocks merge their SCSS into the main stylesheet because they rely on Bootstrap variables, mixins, or styles. You can uncomment these blocks (or add your own) in ./src/scss/\_blocks.scss. This file will be imported into both front-end and admin stylesheets.

The slider block (powered by Slick Slider) loads its styles and javascript into individual files, which are then enqueued only if the block is used. If you wish to use this same method on other blocks, follow the ACF enqueue instructions for `acf_register_block_type` and structure your SCSS and javascript as outlined below.

# SCSS

In addition to SCSS files mentioned above, there are a few other SCSS files to be aware of:

- **./src/scss/style.scss** - Imports all files that will be merged into the main CSS file for the site.
- **./src/scss/\_common-frontend.scss** - These files are loaded only on the front-end.
- **./src/scss/editor-styles.scss** - Imports all files that will be merged into the main CSS file for the admin. All styles are wrapped by _.editor-styles-wrapper_ to limit their impact on the admin.
- **./src/scss/\_editor.scss** - These styles are loaded ONLY in the admin.
- **./src/scss/blocks/core/** - Styles for the built-in WordPress core blocks, which are loaded into the main stylesheet.
- **./src/scss/blocks/custom/** - Styles for custom blocks, which are loaded into the main stylesheet.
- **./src/scss/blocks/enqueue_style/** - Styles for custom blocks that will be individually processed into ./dist/css/blocks/. Don't use a leading underscore.
- **./src/scss/\_kadence.scss** - We currently use [Kadence Blocks](https://wordpress.org/plugins/kadence-blocks/) for creating rows in the admin. These styles change the Kadence rows to behave as Bootstrap containers.
- **./src/scss/\_align.scss** - Adjusts the behavior of .alignfull and .alignwide.

Most other SCSS files should be self-explanatory, and you can create your own partials as needed. Just be sure to import them into the correct SCSS files.

# Javascript

Gulpfile.js will process Javascript files in different ways depending on which folder they are placed in. Most files will be merged and enqueued automatically into the header or the footer.

### Head Javascript

**./dist/js/jquery.min.js** is not processed in any way and is enqueued on its own in the head of the site.

**./src/js/head/** files will be concatinated in the following order into _./dist/js/head.min.js_:

- **./vendor/** - All plugin and vendor scripts go here. They are not processed through eslint, babel, or uglify.
- **./bootstrap/**
- **./custom/** - First run through eslint, babel, and uglify. Create any custom javascript that you wish to load in the head of your site here.

### Footer Javascript

**./src/js/footer/** files will be concatinated in the following order into _./dist/js/scripts.min.js_:

- **./vendor/** - All plugin and vendor scripts go here. They are not processed through eslint, babel, or uglify.
- **./bootstrap/**
- **./custom/** - First run through eslint, babel, and uglify. Create any custom javascript that you wish to load in the head of your site here.

**NOTE:** Currently there is no way to control the order of concatination for javascript files beyond the folders above. Meaning, you can't tell script2.js to concatinate before script1.js if they are both in ./custom/. If the order matters for certain scripts consider combining them into a single src file. This should be improved in the future.

### Block Javascript

If you plan to enqueue an individual javascript file for a block - rather than merging that block's JS with the main site javascript - you can create folders in **./src/js/blocks/**.

- Put your javascript in a folder for your block. Any files in a **/vendor/** subfolder will not run through Babel. Any other files will. They will then be concatinated together. Example: _./src/js/blocks/slider/vendor/slick.min.js_ and _./src/js/blocks/slider/block-slider.js_ are merged together into _./dist/js/blocks/block-slider.min.js_. This ./dist/ file is then enqueued with `acf_register_block_type`.
- Don't put any javascript files directly into **./src/js/blocks/**.

# Navigation

Basetheme includes Main, Utility and Footer navs out of the box. The header navigation includes basic styling. A navwalker is used to make WordPress menus play nicer with Bootstrap's navbar.

# Template Parts

Template parts for various content pieces should be placed in the _./template-parts/_ folder. It's also appropriate to create subfolders here when it makes sense. For example: A group of re-used blog template parts could go in _./template-parts/blog/_.

# Page Templates

By default, the Basetheme no longer includes any page templates. On a block-driven site, we can strive to use a single, blank page template. This may not always be possible. When page templates are required, create them in the _./page-templates/_ folder.

SCSS added to this folder will be processed and moved to /dist/css/blocks/. It will not be concatenated with other files.

Name your file without a leading underscore. e.g., slick.scss.

The purpose of this is to allow you to enqueue styles in ACF blocks that will only be loaded if that block is used:

'enqueue_style'   => get_template_directory_uri() . '/dist/css/blocks/slick.css',

The downside of this is you won't easily have access to Bootstrap mixins within your SCSS file.
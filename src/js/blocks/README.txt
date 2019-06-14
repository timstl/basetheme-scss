Javascript added to this folder will be moved to /dist/js/blocks/. It will not be concatenated with other files.

Put your javascript in a folder for your block. Any files in a /vendor/ folder will not run through Babel. Any other files will. They will then be concatinated together. Example: /js/blocks/slider/block-slider.js and /js/blocks/slider/vendor/slick.min.js.

Don't put any javascript files directly into /js/blocks/; they will not be used.

If your block does not enqueue individual javascript files, add your javascript to /footer/custom/, and it will be concatenated to the main site scripts file.
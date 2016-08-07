module.exports = function(grunt) {
    grunt.initConfig({
        // Compile LESS
        less: {
            dev: {
                options: {
                    paths: ["assets/css/src"]
                },
                files: {
                    "assets/css/services-buttons.css": "assets/css/src/services-buttons.less",
                    "assets/css/app.css": "assets/css/src/app.less"
                }
            },
            production: {
                options: {
                    paths: ["assets/css/src"],
                    compress: true,
                    cleancss: true
                },
                files: {
                    "assets/css/services-buttons.css": "assets/css/src/services-buttons.less",
                    "assets/css/app.css": "assets/css/src/app.less"
                }
            }
        },

        // Compile ES6
        browserify: {
            dev: {
                options: {
                    browserifyOptions: {
                        debug: true
                    },
                    transform: [
                        ["babelify", {
                            presets: ["es2015"],
                            compact: false,
                            minified: false,
                            comments: true
                        }]
                    ]
                },
                files : {
                    "assets/js/main.js": ["assets/js/src/main.es6"]
                }
            },
            production: {
                options: {
                    browserifyOptions: {
                        debug: false
                    },
                    transform: [
                        ["babelify", {
                            presets: ["es2015"],
                            compact: true,
                            minified: true,
                            comments: false
                        }]
                    ]
                },
                files : {
                    "assets/js/main.js": ["assets/js/src/main.es6"]
                }
            }
        },

        // Minify Javascript
        uglify: {
            dev: {
                options: {
                    beautify: true,
                    report: 'none'
                },
                files: {
                    "assets/js/main.min.js": "assets/js/main.js"
                }
            },
            production: {
                options: {
                    compress: {
                        dead_code: true,
                        drop_console: true,
                        conditionals: true
                    },
                    preserveComments: false,
                    report: 'none'
                },
                files: {
                    "assets/js/main.min.js": "assets/js/main.js"
                }
            }
        }
    });

    // Load plugins
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks("grunt-browserify");
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Available tasks
    var dev = ['less:dev', 'browserify:dev', 'uglify:dev'],
        production = ['less:production', 'browserify:production', 'uglify:production'];

    grunt.registerTask('default', production);
    grunt.registerTask('dev', dev);
    grunt.registerTask('production', production);
};

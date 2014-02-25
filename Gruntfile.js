module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		php: {
			serve: {
				options: {
					port: 7007,
					hostname: 'localhost',
					base: 'live/',
					keepalive: true,
					open: true
				}
			},
			watch: {
				css: {
					files: ['scss/*.scss'],
					tasks: ['sass:dist', 'copy:css'],
					options: {
						spawn: false,
						livereload: false
					}
				},
				js: {
					files: ['js/*.js'],
					tasks: ['copy:js'],
					options: {
						spawn: false,
						livereload: false
					}
				}
			}
		},
		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				files: {
					'live/css/styles.css': 'dev/scss/styles.scss'
				}
			},
			live: {
				options: {
					style: 'compressed'
				},
				files: {
					'live/css/styles.css': 'dev/scss/styles.scss'
				}
			}
		},
		copy: {
			dev: {
				files: [
					{
						expand: true,
						src: 'dev/img/*',
						dest: 'live/img/',
						flatten: true
					},
					{
						expand: true,
						src: 'dev/js/*',
						dest: 'live/js/',
						flatten: true
					},
					{
						src: 'dev/index.html',
						dest: 'live/index.html',
						filter: 'isFile'
					},
					{
						expand: true,
						src: 'dev/rsrc/*',
						dest: 'live/rsrc/',
						flatten: true
					}
				]
			}
		},
		watch: {
			html: {
				files: ['dev/*.html'],
				tasks: ['copy:index'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			css: {
				files: ['dev/scss/*'],
				tasks: ['sass', 'copy:css'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			js: {
				files: ['dev/js/*'],
				tasks: ['copy:js'],
				options: {
					spawn: false,
					livereload: false
				}
			}
		}

	});

	grunt.loadNpmTasks("grunt-php");
	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("phpwatch", [
		"php:watch"
	]);

	grunt.registerTask("server", [
		"php"
	]);

	grunt.registerTask("dev", [
		"watch"
	]);

	grunt.registerTask("live", [
		"sass:live"
	]);
	
};
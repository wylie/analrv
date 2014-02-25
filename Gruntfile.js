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
					files: ['css/*.scss'],
					tasks: ['sass', 'copy:css'],
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
			dist: {
				options: {
					style: 'expanded'
				},
				files: {
					'live/css/styles.css': 'dev/css/styles.scss'
				}
			}
		},
		copy: {
			main: {
				src: 'dev/*',
				dest: 'live/',
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
				files: ['dev/css/*'],
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
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("phpwatch", [
		"php:watch",
		"watch"
	]);

	grunt.registerTask("server", [
		"php"
	]);

	grunt.registerTask("dev", [
		"copy",
		"phpwatch"
	]);

	grunt.registerTask("live", [
		"copy"
	]);
	
};
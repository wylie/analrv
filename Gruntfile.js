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
					'live/css/styles.css': 'css/styles.scss'
				}
			}
		},
		copy: {
			index: {
				files: [
					{expand: true, src: ['index.html'], dest: 'live/', filter: 'isFile'}
				]
			},
			css: {
				files: [
					{expand: true, src: ['css/**'], dest: 'live/css', filter: 'isFile'}
				]
			},
			js: {
				files: [
					{expand: true, src: ['js/**'], dest: 'live/js/', filter: 'isFile'}
				]
			}
		},
		watch: {
			html: {
				files: ['*.html'],
				tasks: ['copy:index'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			css: {
				files: ['css/*'],
				tasks: ['sass', 'copy:css'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			js: {
				files: ['js/*'],
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
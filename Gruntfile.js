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
			watch: {}
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
						src: 'dev/img/rvs/*',
						dest: 'live/img/rvs/',
						flatten: true
					},
					{
						expand: true,
						src: 'dev/js/*',
						dest: 'live/js/',
						flatten: true
					},
					{
						expand: true,
						src: 'dev/rsrc/*',
						dest: 'live/rsrc/',
						flatten: true
					},
					{
						src: 'dev/index.html',
						dest: 'live/index.html',
						filter: 'isFile'
					},
					{
						src: 'dev/rvs.json',
						dest: 'live/rvs.json',
						filter: 'isFile'
					}
				]
			}
		},
		watch: {
			html: {
				files: ['dev/*.html'],
				tasks: ['copy'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			css: {
				files: ['dev/scss/*'],
				tasks: ['copy'],
				options: {
					spawn: false,
					livereload: false
				}
			},
			js: {
				files: ['dev/js/*'],
				tasks: ['copy'],
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
		"php",
		"watch"
	]);

	grunt.registerTask("server", [
		"phpwatch"
	]);

	grunt.registerTask("dev", [
		"sass:live",
		"watch"
	]);

	grunt.registerTask("live", [
		"sass:live",
		"copy"
	]);
	
};
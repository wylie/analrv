module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		php: {
			test: {
				options: {
					port: 7007,
					hostname: 'localhost',
					keepalive: true,
					open: true
				}
			}
		},
		less: {
			dev: {
				files: {
					"dist/css/styles.css": "src/less/styles.less"
				}
			},
			dist: {
				files: {
					"dist/css/styles.css": "src/less/styles.less"
				},
				options: {
					compress: true,
					yuicompress: true,
					report: 'gzip'
				}
			}
		},

		watch: {
			css: {
				files: ['src/less/*.less'],
				tasks: ['less']
			}
		}
	});

	grunt.loadNpmTasks("grunt-php");
	grunt.loadNpmTasks("grunt-contrib-less");
	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("src", [
		"less",
		"watch"
	]);

	grunt.registerTask("server", [
		"php",
		"watch"
	]);

	grunt.registerTask("dev", [
		"php",
		"watch"
	]);
	
};
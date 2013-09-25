module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		php: {
			test: {
				options: {
					port: 7007,
					hostname: 'localhost',
					bases: "site",
					keepalive: true,
					open: true
				}
			}
		},
		less: {
			development: {
				files: {
					"site/css/styles.css": "site/css/styles.less"
				}
			}
		},
		watch: {
			css: {
				files: ['site/css/styles.less'],
				tasks: ['less']
			}
		}
	});

	grunt.loadNpmTasks("grunt-php");
	grunt.loadNpmTasks("grunt-contrib-less");
	grunt.loadNpmTasks("grunt-contrib-watch");

	grunt.registerTask("compile", [
		"less"
	]);

	grunt.registerTask("server", [
		"php",
		"watch"
	]);
	
};
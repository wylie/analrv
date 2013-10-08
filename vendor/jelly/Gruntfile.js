module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		less: {
			development: {
				options: {
					paths: ["jelly"],
					report: 'gzip'
				},
				files: {
					"jelly.css": "jelly/jelly.less"
				}
			},
			production: {
				options: {
					paths: ["jelly"],
					yuicompress: true,
					report: 'gzip'
				},
				files: {
					"jelly.min.css": "jelly/jelly.less"
				}
			}
		},
		watch: {
			files: ['jelly/*.less'],
			tasks: ['less']
		},
		express: {
			rel: {
				options: {
					port: 4000
				}
			}
		}
	});

	grunt.loadNpmTasks("grunt-contrib-less");
	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks('grunt-express');

	grunt.registerTask("dev", [
		"less:development"
	]);

	grunt.registerTask("server", [
		"express",
		"watch",
		"express-keepalive"
	]);

	grunt.registerTask("pro", [
		"less:development",
		"less:production"
	]);
	
};
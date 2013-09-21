module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		php: {
			test: {
				options: {
					port: 7007,
					hostname: 'localhost',
					base: 'dev/',
					keepalive: true,
					open: true
				}
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
		"php"
	]);
	
};
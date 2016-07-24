module.exports = function(grunt) {

	// project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

    express: {
			server: {
				options: {
					port: 8070,
					host: 'http://localhost',
					bases: 'dist'
				}
			}
		},

		sass: {
			dev: {
				options: {
					style: 'expanded'
				},
				files: {
					'dist/css/styles.css': 'dev/scss/styles.scss'
				}
			},
			live: {
				options: {
					style: 'compressed'
				},
				files: {
					'dist/css/styles.css': 'dev/scss/styles.scss'
				}
			}
		},

    copy: {
			html: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['dev/*.html'],
						dest: 'dist/',
						filter: 'isFile'
					}
				]
			},
			images: {
				files: [
					{
						expand: true,
						cwd: 'dev/img',
						src: '**',
						dest: 'dist/img'
					}
				]
			},
			js: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['dev/js/**'],
						dest: 'dist/js',
						filter: 'isFile'
					}
				]
			},
			json: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['dev/data/**'],
						dest: 'dist/data',
						filter: 'isFile'
					}
				]
			},
			php: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['dev/actions/**'],
						dest: 'dist/actions',
						filter: 'isFile'
					}
				]
			}
		},

    watch: {
			html: {
				files: ['dev/*.html'],
				tasks: ['copy:html'],
				options: {
					livereload: true,
				}
			},
			css: {
				files: ['dev/less/*.less'],
				tasks: ['less', 'postcss'],
				options: {
					livereload: true,
				}
			},
			js: {
				files: ['dev/js/*.js'],
				tasks: ['copy:js'],
				options: {
					livereload: true,
				}
			},
			json: {
				files: ['dev/data/*.json'],
				tasks: ['copy:json'],
				options: {
					livereload: true,
				}
			},
			php: {
				files: ['dev/actions/*.php'],
				tasks: ['copy:php'],
				options: {
					livereload: true,
				}
			}
		},

	});

  grunt.loadNpmTasks('grunt-express');
	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-contrib-watch");

  grunt.registerTask('default', [
		'build',
		'server'
	]);

	grunt.registerTask('build', [
		'copy',
		'sass'
	]);

	grunt.registerTask('dev', [
		'express:dev',
		'sass',
		'copy',
		'watch'
	]);

	grunt.registerTask('server', [
		'express',
		'watch',
		'sass',
		'copy',
		'express-keepalive'
	]);

};

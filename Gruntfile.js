/*global module:false*/
module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			development: {
				options: {
					style: 'compressed',
					sourcemap: 'none'
				},
				files: {
					"src/Public/Styles/Frontend.css": "src/Private/Styles/Frontend.scss",
					"src/Public/Styles/Backend.css": "src/Private/Styles/Backend.scss"
				}
			}
		},
		watch: {
			sass_files_changed: {
				files: [
					"src/Private/Styles/*"
				],
				tasks: ['sass'],
				options: {
					event: ['changed']
				}
			},
			sass_files_added_deleted: {
				files: [
					"src/Private/Styles/*"
				],
				tasks: ['sass'],
				options: {
					event: ['added', 'deleted'],
					interrupt: false
				}
			}
		},
		concat: {
			options: {
				separator: ';'
			},
			backend: {
				src: [
					'bower_components/jquery/dist/jquery.js',
					'bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
					'src/Private/JavaScript/Backend.js'
				],
				dest: 'src/Public/JavaScript/Backend.js'
			},
			frontend: {
				src: [
					'bower_components/jquery/dist/jquery.js',
					'bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
					'src/Private/JavaScript/Frontend.js'
				],
				dest: 'src/Public/JavaScript/Frontend.js'
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-prettify');
	grunt.loadNpmTasks('grunt-notify');
	grunt.registerTask('default', ['build']);
	grunt.registerTask('build', ['sass']);
};

var LIVERELOAD_PORT = 38085;
module.exports = function(grunt) {
	require('load-grunt-tasks')(grunt);
	grunt.initConfig({
		exec: {
			phpcs: {
				cmd: 'phpcs --standard=WordPress *.php ./**/*.php',
				exitCode: [0, 1]
			}
		},
		compass: {
			options: {
				config: 'config.rb'
			},
			prod: {
				options: {
					environment: 'production',
					force: true
				}
			},
			dev: {
				options: {
					environment: 'development',
					force: true
				}
			}
		},
		uglify: {
			dist: {
				options: {
					beautify: true
				},
				files: {
					'style.js': ['components/js/google-code-prettify/prettify.js', 'js/navigation.js', 'js/skip-link-focus-fix.js', 'js/script.js']
				}
			}
		},
		bower: {
			install: {
				options: {
					targetDir: './components',
					cleanTargetDir: true,
					layout: 'byType'
				}
			}
		},
		watch: {
			scripts: {
				files: ['js/*.js'],
				tasks: ['uglify'],
				options: {
					spawn: false
				}
			},
			sass: {
				files: ['sass/**/*.scss'],
				tasks: ['compass:dev']
			},
			php: {
				files: ['*.php', './**/*.php'],
				tasks: ['phpcs']
			},
			livereload: {
				options: {
					livereload: LIVERELOAD_PORT
				},
				files: ['*.css', '*.js']
			}
		}
	});
	grunt.registerTask('build', [
		'bower:install',
		'compass:prod',
		'uglify'
	]);

	grunt.registerTask('debug', [
		'bower:install',
		'compass:dev',
		'phpcs',
		'uglify',
		'watch'
	]);

	grunt.registerTask('phpcs', ['exec:phpcs']);

	grunt.registerTask('default', ['build']);
};
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
		jshint: {
			options: {
				force: true
			},
			beforeconcat: ['js/navigation.js', 'js/skip-link-focus-fix.js', 'js/script.js']
		},
		uglify: {
			dist: {
				options: {
					beautify: true
				},
				files: {
					'style.js': ['components/js/google-code-prettify/prettify.js', 'js/skip-link-focus-fix.js', 'js/script.js']
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
				tasks: ['jshint', 'uglify'],
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
				files: ['*.css', '*.js', '*.php', './**/*.php']
			}
		}
	});

	grunt.registerTask('build', [
		'bower:install',
		'compass:prod',
		'jshint',
		'uglify'
	]);

	grunt.registerTask('debug', [
		'bower:install',
		'compass:dev',
		'phpcs',
		'jshint',
		'uglify',
		'watch'
	]);

	grunt.registerTask('phpcs', ['exec:phpcs']);

	grunt.registerTask('default', ['build']);
};
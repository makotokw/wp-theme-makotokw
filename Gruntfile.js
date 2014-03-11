module.exports = function(grunt) {
	grunt.initConfig({
		compass: {
			prod: {
				options: {
					config: 'config.rb',
					environment: 'production',
					force: true
				}
			},
			dev: {
				options: {
					config: 'config.rb',
					environment: 'development'
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
			livereload: {
				options: {
					livereload: 38085
				},
				files: ['*.css', '*.js']
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-bower-task');

	grunt.registerTask('default', ['compass:prod', 'uglify']);
};
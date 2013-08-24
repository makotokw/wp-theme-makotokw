module.exports = function(grunt) {
	grunt.initConfig({
		compass: {
			dist: {
				options: {
					config: 'config.rb',
					environment: 'production'
				}
			}
		},
		uglify: {
			dist: {
				files: {
					'components/js/google-code-prettify/prettify.min.js': ['components/js/google-code-prettify/prettify.js'],
					'style.js': ['js/navigation.js', 'js/skip-link-focus-fix.js', 'js/script.js'],
					'js/keyboard-image-navigation.min.js': ['js/keyboard-image-navigation.js'],
					'amazonjs.js': ['js/amazonjs.js']
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
		}
	});
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-bower-task');

	grunt.registerTask('default', ['compass', 'uglify']);
};
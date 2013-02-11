module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-recess');
	grunt.loadNpmTasks('grunt-shell');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-coffee');

	var recessOptions = function(bool) {
		bool = ((typeof bool === 'undefined')? false : bool);
		var config = {
			compile: true,
			compress: bool,
			noIDs: false,
			noJSPrefix: false,
			noOverqualifying: false,
			noUnderscores: false,
			noUniversalSelectors: false,
			prefixWhitespace: false,
			strictPropertyOrder: false,
			zeroUnits: false
		};

		return config;
	}

	grunt.initConfig({
		pkg: '<json:package.json>',
		meta: {},
		files: {
			coffee: [
				'assets/coffee/*.coffee'
			],
			js: [
				'assets/js/*.js',
			],
			less: [
				'assets/less/base.less'
			],
			html: [
				'*.html'
			]
		},
		coffee: {
			app: {
				src: '<config:files.coffee>',
				dest: 'assets/js',
				options: {
					bare: true
				}
			}
		},
		concat: {
			js: {
				src: '<config:files.js>',
				dest: 'assets/app.js'
			}
		},
		min: {
			js: {
				src: '<config:files.js>',
				dest: 'assets/app.js'
			}
		},
		recess: {
			min: {
				src: '<config:files.less>',
				dest: 'assets/style.css',
				options: recessOptions(true)
			},
			max: {
				src: '<config:files.less>',
				dest: 'assets/style.css',
				options: recessOptions(false)
			}
		},
		watch: {
			less: {
				files: ['assets/less/*.less', 'assets/less/**/*.less'],
				tasks: 'concat recess:max'
			},
			coffee: {
				files: '<config:files.coffee>',
				tasks: 'coffee concat recess:max'
			},
			html: {
				files: '<config:files.html>',
				tasks: 'concat recess:max'
			}
		},
		jshint: {
			options: {
				curly: true,
				eqeqeq: true,
				immed: true,
				latedef: true,
				newcap: true,
				noarg: true,
				sub: true,
				undef: true,
				boss: true,
				eqnull: true,
				browser: true
			}
		},
		uglify: {}
	});

	// Default task.
	grunt.registerTask('default', 'coffee min recess:min');
};

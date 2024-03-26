/*global module:false*/
module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
	// Metadata.
	pkg: grunt.file.readJSON('package.json'),
	banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
	  '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
	  '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
	  '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
	  ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
	// Task configuration.
	concat: {
	  options: {
		stripBanners: true
	  }
	},
	uglify: {
	  options: {
		banner: '<%= banner %>'
	  },
	  dist: {
		src: '<%= concat.dist.dest %>',
		dest: 'dist/<%= pkg.name %>.min.js'
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
		unused: true,
		boss: true,
		eqnull: true,
		browser: true,
		globals: {
		  jQuery: true
		}
	  },
	  gruntfile: {
		src: 'Gruntfile.js'
	  },
	  lib_test: {
		src: ['lib/**/*.js', 'test/**/*.js']
	  }
	},
	qunit: {
	  files: ['test/**/*.html']
	},

	less: {
		dev: {
			options: {
			  paths: ['less'],
			  sourceMap: true
			},
			files: {
			  'style.css': 'less/style.less'
			}
		},

		prod: {
			options: {
			  paths: ['less'],
			  cleancss: true,
			  compress: true
			},
			files: {
			  'style.css': 'less/style.less'
			}
		}
	},

	autoprefixer: {
        dev: {
            src: 'style.css',
            dest: 'style.css',
            options: {
                map: true
            }
        },

        prod: {
            src: 'style.css',
            dest: 'style.css'
        }
    },

	watch: {
	  gruntfile: {
		files: '<%= jshint.gruntfile.src %>',
		tasks: ['jshint:gruntfile']
	  },
	  css: {
		  files: 'less/**/*.less',
		  tasks: ['less:dev', 'autoprefixer:dev']
	  },
	  livereload: {
		  options: { livereload: true },
		  files: [
			  'js/*.js',
			  'style.css',
			  '*.php'
		  ]
	  }
	}
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-qunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-autoprefixer');


  // watch tasks
  grunt.registerTask('dev', ['watch']);
  grunt.registerTask('dev:css', ['watch:css']);

  // Default task.
  grunt.registerTask('default', ['less:prod', 'autoprefixer:prod']);

};

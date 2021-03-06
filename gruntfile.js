module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        libraries : [
          "js/libs/jquery.zclip.js"
        ],
        custom: [
          "js/background.js",
          //"js/copypasta.js",
          "js/gallery.js"
        ],
        src: [ '<%= concat.dist.libraries %>', '<%= concat.dist.custom %>' ],
        dest: 'js/story.dev.js'
      }
    },
    uglify: {
      options: {
        //banner: '/*! <%= pkg.name %> <%= grunt.template.today() %> */\n'
      },
      dist: {
        files: {
          'js/story.js': ['<%= concat.dist.dest %>']
        }
      }
    },
    jshint: {
      files: [ 'Gruntfile.js', '<%= concat.dist.custom %>' ],
      options: {
        asi: true,
        smarttabs: true,
        laxcomma: true,
        es3: true,
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    notify: {
      watch: {
        options: {
          title: 'Task Complete',
          message: 'JS uglified successfully'
        }
      }
    },

    less: {
      development: {
        files: {
         'style.dev.css': 'style.less'
        }
      },
      production: {
        options: {
          cleancss: true
        },
        files: {
          'style.css': 'style.less'
        }
      }
    },

    watch: {
      js: {
        files: ['<%= concat.dist.src %>'],
        tasks: ['default']
      },
      css: {
        files: ['*.less','less/*.less'],
        tasks: ['less']
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-less');

  grunt.loadNpmTasks('grunt-notify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');


  grunt.registerTask('default', ['less', 'jshint', 'concat', 'uglify', 'notify']);
  grunt.registerTask( 'js', [ 'jshint', 'concat', 'notify' ]);

};

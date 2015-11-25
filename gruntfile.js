module.exports = function(grunt) {

    // Load all tasks
    require('load-grunt-tasks')(grunt);
    require('time-grunt')(grunt);
    
    var mozjpeg  = require('imagemin-mozjpeg');

    var htmlFileList = [
      'index.php'
    ];

    var cssFileList = [
      'bower_components/normalize.css/normalize.css',
      'bower_components/font-awesome-4.4.0/css/font-awesome.min.css'
    ];

    var jsFileList = [
      'bower_components/jquery/dist/jquery.js',
      'assets/scripts/vendors/modernizr.min.js',
      'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js'
    ];

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        jshint: {
          options: {
            jshintrc: '.jshintrc'
          },
          all: [
            'gruntfile.js',
            'assets/js/main.js'
          ]
        },
        // modernizr: {
        //   build: {
        //     devFile: 'bower_components/modernizr/modernizr.js',
        //     outputFile: 'dist/assets/scripts/vendors/modernizr.min.js',
        //     uglify: true,
        //     parseFiles: true
        //   }
        // },
        concat: { 
            options: {
              separator: ';',
            },  
            build: {
              files: {
                'assets/scripts/main.min.js': ['assets/scripts/main.js'],
                'assets/scripts/vendors.js': [jsFileList]
              },
            },
        },
        uglify: {
            build: {
              files: {
                'dist/assets/scripts/main.min.js' : 'assets/scripts/main.js',
                'dist/assets/scripts/vendors.min.js' : 'assets/scripts/vendors.js'
              }
            }
        },
        imagemin: {
          dynamic: {
            options: {
              optimizationLevel: 4,
              svgoPlugins: [{ removeViewBox: false }],
              progressive: true,
              use: [mozjpeg({quality: 80})]
            },
            files: [{
              expand: true,                     // Enable dynamic expansion
              cwd: 'assets/img/',                // Src matches are relative to this path
              src: ['**/*.{png,jpg}'],   // Actual patterns to match
              dest: 'dist/assets/img/'           // Destination path prefix
            }]
          },
        }, 
        sass: {                              // Task
          dev: {                            // Target
            options: {                       // Target options
              style: 'expanded',
              sourcemap: 'auto'
            },
            files: {                         // Dictionary of files
              'assets/styles/main.css': 'assets/styles/main.scss'
            }
          },
          build: {                            // Target
            options: {                       // Target options
              style: 'compressed'
            },
            files: {                         // Dictionary of files
              'dist/assets/styles/main.min.css': 'assets/styles/main.scss'
            }
          }
        },   
        autoprefixer: {
          options: {
            browsers: ['last 2 versions', '> 1%', 'ff > 20', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
          },
          dev: {
            options: {
              map: {
                prev: 'assets/styles/'
              }
            },
            src: 'assets/styles/main.css'
          },
          build: {
            src: 'dist/assets/styles/main.css'
          }
        },
        processhtml: {
          build: {
            files: {
              'dist/index.php': ['index.php']
            }
          }
        },
        uncss: {
          options: {
            compress: true,
            report: 'min'
          },
          build: {
            files: {
              'dist/assets/styles/main.min.css': [htmlFileList]
            }
          }
        },
        // If not using SASS, enable this!
        // cssmin: {
        //   minify: {
        //     files: {
        //         'dist/assets/styles/main.min.css': ['assets/styles/main.css']
        //     }
        //   }
        // },
        copy:{
          build: {
            files: [
              {
                expand: true, 
                cwd: 'assets/fonts/font-awesome-4.2.0/', 
                src: ['**'], 
                dest: 'dist/assets/fonts/', 
                flatten: true, 
                filter: 'isFile'
              },
              {
                expand: true, 
                cwd: '', 
                src: 'assets/images/icons/favicon.ico', 
                dest: 'dist/assets/images/icons/', 
                flatten: true, 
                filter: 'isFile'
              },
               {
                src: ['/*.php'], 
                dest: 'dist/'
              }
            ]
          }
        },
        favicons: {
          options: {
            trueColor: true,
            precomposed: false,
            appleTouchBackgroundColor: "#e2b2c2",
            coast: true,
            windowsTile: true,
            tileBlackWhite: false,
            tileColor: "auto",
            html: 'index.php',
            HTMLPrefix: "assets/images/icons/"
          },
            icons: {
            src: 'assets/favicon.png',
            dest: 'assets/images/icons'
          }
        },
        'ftp-deploy':{
          deploy: {
            auth: {
              authPath: '../.ftppass',
              host: 'ftp.andresceron.se',
              port: 21,
              authKey: 'key1'
            },
            src: 'dist/',
            dest: 'test22/',
            exclusions: [
              '.DS_Store',
              '.gitignore',
              '.ftppass'
            ]
          }
        },
        connect: {
          all: {
            options:{
              port: 8888,
              hostname: "localhost",
              keepalive: false
            }
          }
        },
        open: {
          all: {
            path: 'http://localhost:<%= connect.all.options.port%>'
          }
        },
        browserSync: {
            dev: {
                bsFiles: {
                    src : [
                        'assets/styles/main.css',
                        '*.php'
                    ]
                },
                options: {
                    watchTask: true,
                    proxy: "localhost:8888/ProjectCenter"
                }
            }
        },
        watch: {
          js: {
              files: ['assets/scripts/main.js'],
              tasks: ['jshint', 'concat'],
              options: {
                  spawn: false
              },
          },
          css: {
            files: ['assets/styles/**/*.scss'],
            tasks: ['sass:dev', 'autoprefixer:dev']
          }
        }   
    });

    grunt.registerTask('default', [
        'dev'
    ]);

    grunt.registerTask('dev', [
        // 'modernizr',
        'jshint',
        'sass:dev',
        'autoprefixer:dev',
        'concat'
    ]);

    grunt.registerTask('build', [
        'jshint',
        'sass:build',
        'autoprefixer:build',
        'newer:concat',
        'newer:uglify',
        'newer:favicons',
        // 'newer:imagemin',
        'processhtml',
        'newer:uncss',
        'newer:copy:build'
    ]);

    grunt.registerTask('live', [
        'dev',
        'browserSync',
        'watch'
    ]);

    grunt.registerTask('serve',[
        'dev',
        'open',
        'connect',
        'watch'
    ]);

    grunt.registerTask('deploy', [
        'build',
        'ftp-deploy'
    ]);

    };
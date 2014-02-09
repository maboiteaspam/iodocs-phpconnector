'use strict';

var should = require('should');
var log = require('npmlog');

describe('iodocs-phpconnector command line, generates JSON for iodocs', function () {

  this.timeout(4000);

  var php_cli = __dirname+"/../shared/cli.php";
  var config_file = __dirname+"/php-app/iodocs.json";

  var php_process = null;
  before(function(done){

    log.level = "silent";
    log.level = "info";

    if(!php_process){
      php_process = open_php([php_cli,config_file],function(){
        done();
      });
    }else{
      done();
    }
  });
  after(function(done){
    if(php_process){
      php_process.stdout.on('data', function (data) {
      });
    }
    done();
  });


  it('should generate fiels with correct format', function(done) {
    /* todo */
    done();
  });
});

function open_php(args,cb){
  var stdout = "";
  var stderr = "";
  var php = require('child_process').spawn("php", args);
  php.stdout.on('data', function (data) {
    log.info('stdout', '', data.toString());
    stdout+=data.toString();
  });
  php.stderr.on('data', function (data) {
    log.info('stderr', '', data.toString());
    stderr+=data.toString();
  });
  php.on('exit', function (code) {
    if(cb) cb(code,stdout,stderr);
  });
  return php;
}
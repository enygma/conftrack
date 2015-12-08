$(function() {

});

if (!Array.prototype.remove) {
  Array.prototype.remove = function(val) {
    var i = this.indexOf(val);
         return i>-1 ? this.splice(i, 1) : [];
  };
}

requirejs.config({
    baseUrl: '/assets/js',
    paths: {
        jquery: 'jquery-1.11.3'
    }
});

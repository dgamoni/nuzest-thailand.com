(function() {
  "use strict";

  // Shared underscore extensions

  //Compact an object by removing falsey elements
  //(only need this because WP uses an old version of underscore)
  _.mixin({
    compactObject : function(o) {
       var clone = _.clone(o);
       _.each(clone, function(v, k) {
         if(!v) {
           delete clone[k];
         }
       });
       return clone;
    }
  });

})()
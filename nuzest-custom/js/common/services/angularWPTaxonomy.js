(function() {
  "use strict";

  // WP taxonomy module
  angular.module('angularWPTaxonomy', [])

  .factory('taxonomyService', function($http) {
    var url = '/wp-json/taxonomies/';
    return {
      list: list
    };

    function list(type) {
      return $http.get(url + type + '/terms');
    }
  });

})()
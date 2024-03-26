(function() {
  "use strict";

  // WP recipe post type module
  angular.module('angularWPAuthor', ['angularWPPosts'])

  // WP post type recipe service
  .factory('authorService', function($http, postsService) {

    return postsService.getNew('author');

  });
})()
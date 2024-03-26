(function() {
  "use strict";

  // WP recipe post type module
  angular.module('angularWPRecipe', ['angularWPPosts'])

  // WP post type recipe service
  .factory('recipeService', function($http, postsService) {

    return postsService.getNew('recipes');

  });
})()
(function() {
  "use strict";

  angular.module('recipeSearchApp', ['ngSanitize', 'ngAnimate', 'truncate', 'angularWPTaxonomy', 'angularWPRecipe'])

  // Recipe search area controller
  .controller('SearchArea', function($scope, $q, $location, taxonomyService, recipeService) {
      var vm = $scope.vm = this;
      var types = ['meal_type','dietary','products']; //taxonomies we are concerned with
      vm.filters = {};      //filters for search service for each type
      vm.taxonomies = {};   //loaded taxonomy data for each type
      vm.selected = {};     //selected items by name for each type
      var inited = false;
      init();

      ////

      function init() {
        loadAllTaxonomies().then(function() {
          //watch & throttle search updates on filter changes
          var throttledSearch = _.throttle(search, 500, {leading: false});
          $scope.$watch('vm.filters', function(newValue, oldValue) {
            if (newValue !== oldValue || !inited) {
              inited = true;
              throttledSearch();
              updateSelections();
            }
          }, true);
        });
      }

      function loadAllTaxonomies() {
        var loaders = [];
        _.each(types, function(type) {
          loaders.push(loadTaxonomyList(type));
        });
        return $q.all(loaders);
      }

      function loadTaxonomyList(type) {
        return taxonomyService.list(type)
        .success(function(res) {
          vm.taxonomies[type] = res;
        });
      }

      function search() {
        recipeService.search(vm.filters);
      }

      function updateSelections() {
        //update all types
        _.each(types, function(type) {
          //clear current type
          vm.selected[type] = [];
          //get all slugs of all selected items
          var keys = _.chain(vm.filters[type]).compactObject().keys().value();
          //get names from all slugs and push to current type
          _.each(keys, function(slug) {
            vm.selected[type].push(_.findWhere(vm.taxonomies[type],{slug:slug}).name);
          });
        })
      }
  })

  // Recipe list controller
  .controller('RecipeList', function($scope, $timeout, $window, recipeService) {
    var vm = $scope.vm = this;
    vm.loading = true;
    vm.noResults = noResults;

    init();

    ////

    function init() {
      $scope.$watch(
        function() {
          return recipeService.items;
        },
        function (newValue, oldValue) {
          if (newValue !== oldValue) {
          	vm.posts = newValue;
            $timeout($window.applySnippetHeights,500);
          }
      	}
      );
      $scope.$watch(
        function() {
          return recipeService.loading;
        },
        function (newValue, oldValue) {
          if (newValue !== oldValue) {
            vm.loading = newValue;
          }
      	}
      );
    }

    function noResults() {
      return !vm.loading && vm.posts && !vm.posts.length;
    }

  })

  // Recipe pagination controller
  .controller('RecipePagination', function($scope, recipeService) {
    var vm = $scope.vm = this;
    vm.pagination = recipeService.pagination;
    vm.pages = {};
    init();

    ////

    function init() {
      $scope.$watch('vm.pagination.totalPages', function (newValue, oldValue) {
        if (newValue != oldValue) {
          updatePagination();
        }
      });
      $scope.$watch('vm.pagination.currentPage', function (newValue, oldValue) {
          if (newValue != oldValue) {
            recipeService.search(null, newValue);
            updatePagination();
          }
      });
    }

    function updatePagination() {
      var max = Math.min(
        vm.pagination.totalPages,
        vm.pagination.currentPage + ((vm.pagination.currentPage==1)?2:1)
      );
      var min = Math.max(
        1,
        vm.pagination.currentPage - ((vm.pagination.currentPage==vm.pagination.totalPages)?2:1)
      );
      vm.pages = _.range(min,max+1);
    }
  })
  ;

})()

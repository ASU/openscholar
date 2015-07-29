(function() {
  angular.module('os-files-private', ['mediaBrowser', 'FileEditorModal'])
    .config(['EntityConfigProvider', function(ecp) {
      var elem = angular.element(document.querySelectorAll('.view-id-os_files_private'));
      elem.attr('ng-controller', 'OSFilesPrivateController');

      ecp.addField('files', 'private', 'only');
    }])
    .controller('OSFilesPrivateController', ['$scope', function ($scope) {
      $scope.reload = function (result) {
        if (result) {
          //window.location.reload();
        }
      }
    }]);
})();
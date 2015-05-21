angular.module('sb.lookbook', [])

.controller('LookbookConfigCtrl', function($scope, $http){
	
		
	$http.get('/lookbook/ajax/profile_fields/personal').success(function(response){
		
		$scope.personal = response;
		$scope.personal.fClick = function(data){
			//console.log(data);
			
			$http.post('/lookbook/ajax/update_lookbook_config',data).success(function(response){
				console.log(response);
			});
		}
	
		/*$scope.fSelectNone = function() {
			console.log( 'On-select-none' );
		}
		
		$scope.fReset = function() {
			console.log( 'On-reset' );
		}        
		
		$scope.fClear = function() {
			console.log( 'On-clear' );
		}*/
	
    });
	
	$http.get('/lookbook/ajax/profile_fields/custom').success(function(response){
		
		$scope.custom = response;
		
    })
});
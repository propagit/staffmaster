angular.module('sb.lookbook', [])

.controller('LookbookConfigCtrl', function($scope, $http){
	
	
	
		
	$http.get('/lookbook/ajax/profile_fields/personal').success(function(response){
		
		$scope.personal = response;
		
		// update when personal details value are checked or unchecked
		$scope.personal.fClick = function(data){
			$http.post('/lookbook/ajax/update_lookbook_personal_config',data).success(function(response){
				get_card_preview();
			});
		}
	
    });
	
	$http.get('/lookbook/ajax/profile_fields/custom').success(function(response){
		$scope.custom = response;
		$scope.custom.fClick = function(data){
			//console.log(data);
			
			$http.post('/lookbook/ajax/update_lookbook_custom_config',data).success(function(response){
				get_card_preview();
			});
		}
    })
	
});

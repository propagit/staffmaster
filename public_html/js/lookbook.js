angular.module('sb.lookbook', [])

.controller('LookbookConfigCtrl', function($scope, $http){
	
	/*$scope.states = [
		{
			state_id: "1", code: "ACT", name: "Australian Capital Territory", ticked: true},
			{state_id: "2", code: "NSW", name: "New South Wales"},
			{state_id: "3", code: "NT", name: "Northern Territory", ticked: true},
			{state_id: "4", code: "QLD", name: "Queensland", ticked: true},
			{state_id: "5", code: "SA", name: "South Australia", ticked: true},
			{state_id: "6", code: "TAS", name: "Tasmania", ticked: true},
			{state_id: "7", code: "VIC", name: "Victoria", ticked: true},
			{state_id: "8", code: "WA", name: "Western Australia", ticked: true}	
		];*/
		
		$http.get('/lookbook/ajax/profile_fields/personal').success(function(response){
		
		$scope.personal = response;
		//if($scope.lookbook.personal){ $scope.personal = true; }
       /* $scope.induction = response.induction;
        $scope.states = response.states;
        if ($scope.induction.state) { $scope.state_filter = true; }
        $scope.groups = response.groups;
        if ($scope.induction.group) { $scope.group_filter = true; }
        $scope.roles = response.roles;
        if ($scope.induction.role) { $scope.role_filter = true; }
        $scope.ages = response.ages;
        if ($scope.induction.age) { $scope.age_filter = true; }

        if ($scope.induction.gender) { $scope.gender_filter = true; }*/
    })
});
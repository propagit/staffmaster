angular.module('sb.lookbook', [])

.controller('LookbookConfigCtrl', function($scope, $http){
	
	$scope.states = [
		{state_id: "1", code: "ACT", name: "Australian Capital Territory", ticked: true},
			{state_id: "2", code: "NSW", name: "New South Wales"},
			{state_id: "3", code: "NT", name: "Northern Territory", ticked: true},
			{state_id: "4", code: "QLD", name: "Queensland", ticked: true},
			{state_id: "5", code: "SA", name: "South Australia", ticked: true},
			{state_id: "6", code: "TAS", name: "Tasmania", ticked: true},
			{state_id: "7", code: "VIC", name: "Victoria", ticked: true},
			{state_id: "8", code: "WA", name: "Western Australia", ticked: true}	
		];
});
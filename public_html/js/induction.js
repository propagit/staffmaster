angular.module('sb.induction', [])

.controller('InductionBuildCtrl', function($scope, $http, $sce, $document){

    $scope.steps = [];
    $scope.contents = [];
    $scope.current_step = {};
    $scope.current_content = {};
    $scope.edit_title_step = {};
    $scope.edit_description_step = {};


    $http.get('/induction/ajax/get_steps/' + $scope.id).
    success(function(response){
        $scope.steps = response;
    }).error(function(error){
        console.log("ERROR: ", error);
    });
    $scope.addStep = function(type) {
        if (!type) { return; }
        $http.post('/induction/ajax/add_step', {
            induction_id: $scope.id,
            type: type
        }).success(function(step){
            $scope.steps.push(step);
            $scope.current_step = step;
            if ($scope.current_step.type != 'content') {
                $http.get('/induction/ajax/profile_fields/' + $scope.current_step.id + '/' + $scope.current_step.type).success(function(response){
                    $scope.fields = response;
                }).error(function(error){
                    console.log("ERROR: ", error);
                });
            }
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };

    $scope.editTitle = function(index) {
        $scope.edit_title_step = $scope.steps[index];
    };
    $scope.editDescription = function(index) {
        $scope.edit_description_step = $scope.steps[index];
    };

    $scope.editStep = function(index) {
        $scope.current_step = $scope.steps[index];
        if ($scope.current_step.type == 'personal'
            || $scope.current_step.type == 'financial'
            || $scope.current_step.type == 'super'
            || $scope.current_step.type == 'custom') {
            $http.get('/induction/ajax/profile_fields/' + $scope.current_step.id + '/' + $scope.current_step.type).success(function(response){
                $scope.fields = response;
            }).error(function(error){
                console.log("ERROR: ", error);
            });
        }
    };


    $scope.updateFields = function(index, fields) {
        var step = $scope.steps[index];
        step.fields = [];
        angular.forEach(fields, function(value, key) {
            if (value.ticked === true) {
                step.fields.push(value.key);
            }
        });
        $http.post('/induction/ajax/update_step/' + step.id, step)
        .success(function(response){
            $scope.edit_title_step = {};
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };

    $scope.updateStep = function(index) {
        var step = $scope.steps[index];
        $http.post('/induction/ajax/update_step/' + step.id, step)
        .success(function(response){
            $scope.edit_title_step = {};
            $scope.edit_description_step = {};
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };
    $scope.closeStep = function(index) {
        $scope.current_step = {};
    };
    $scope.$watch('current_step', function(val){
        if (val.id) {
            $http.get('/induction/ajax/get_contents/' + val.id)
            .success(function(contents){
                $scope.contents = contents;
                for(var i=0; i < $scope.contents.length; i++) {
                    $scope.contents[i].html = $sce.trustAsHtml($scope.contents[i].value);
                }
            }).error(function(error){
                console.log("ERROR: ", error);
            });
        }
    });
    $scope.deleteStep = function(index) {
        $http.delete('/induction/ajax/delete_step/' + $scope.steps[index].id)
        .success(function(response){
            $scope.steps.splice(index, 1);
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };
    $scope.addContent = function(type) {
        if (!type || !$scope.current_step.id) { return; }
        $http.post('/induction/ajax/add_content', {
            induction_id: $scope.id,
            step_id: $scope.current_step.id,
            type: type
        }).success(function(content){
            $scope.contents.push(content);
            $scope.current_content = content;
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };

    $scope.updateContent = function(index) {
        var content = $scope.contents[index];
        $http.post('/induction/ajax/update_content/' + content.id, content)
        .success(function(response){
            $scope.contents[index].html = $sce.trustAsHtml(content.value);
            $scope.current_content = {};
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };

    $scope.deleteContent = function(index) {
        $http.delete('/induction/ajax/delete_content/' + $scope.contents[index].id)
        .success(function(response){
            $scope.contents.splice(index, 1);
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };

    $scope.editContent = function(index) {
        $scope.current_content = $scope.contents[index];
    };

    $scope.onSuccess = function(response, index) {
        $scope.contents[index].value = response.data.file_name;
        $scope.updateContent(index);
    };

    $scope.dragControlListeners = {
        orderChanged: function(event) {
            // console.log($scope.steps[event.source.index]);
            // console.log($scope.steps[event.dest.index]);
            var source = $scope.steps[event.source.index];
            var temp = source.step_order;
            var dest = $scope.steps[event.dest.index];
            source.step_order = dest.step_order;
            dest.step_order = temp;
            // console.log(source);
            // console.log(dest);
            $http.post('/induction/ajax/update_step/' + source.id, source)
            .success(function(response){
                $http.post('/induction/ajax/update_step/' + dest.id, dest)
                .success(function(response){

                }).error(function(error){
                    console.log("ERROR: ", error);
                });
            }).error(function(error){
                console.log("ERROR: ", error);
            });
        }
    };
    // $scope.dragControlListeners = {
    //     accept: function (sourceItemHandleScope, destSortableScope) {return boolean}//override to determine drag is allowed or not. default is true.
    //     itemMoved: function (event) {//Do what you want},
    //     orderChanged: function(event) {//Do what you want},
    //     containment: '#board'//optional param.
    // };
})

.controller('InductionSetting', function($scope, $http, $timeout) {
    $http.get('/induction/ajax/get/' + $scope.id).success(function(response){
        $scope.induction = response.induction;
        $scope.states = response.states;
        if ($scope.induction.state) { $scope.state_filter = true; }
        $scope.groups = response.groups;
        if ($scope.induction.group) { $scope.group_filter = true; }
        $scope.roles = response.roles;
        if ($scope.induction.role) { $scope.role_filter = true; }
        $scope.ages = response.ages;
        if ($scope.induction.age) { $scope.age_filter = true; }

        if ($scope.induction.gender) { $scope.gender_filter = true; }
    })

    $scope.update = function(induction) {
        induction.state = null;
        induction.group = null;
        induction.role = null;
        induction.age = null;
        if ($scope.state_filter) {
            induction.state = [];
            angular.forEach($scope.states, function(value, key){
                if (value.ticked === true) {
                    induction.state.push(value.code);
                }
            });
        }
        if ($scope.group_filter) {
            induction.group = [];
            angular.forEach($scope.groups, function(value, key) {
                if (value.ticked === true) {
                    induction.group.push(value.group_id);
                }
            });
        }
        if ($scope.role_filter) {
            induction.role = [];
            angular.forEach($scope.roles, function(value, key) {
                if (value.ticked === true) {
                    induction.role.push(value.role_id);
                }
            });
        }
        if ($scope.age_filter) {
            induction.age = [];
            angular.forEach($scope.ages, function(value, key) {
                if (value.ticked === true) {
                    induction.age.push(value.value);
                }
            });
        }
        if (!$scope.gender_filter) {
            induction.gender = null;
        }
        $http.post('/induction/ajax/update/' + $scope.id, induction).success(function(response){
            $scope.updated = true;
            $timeout(function(){
                $scope.updated = false;
            }, 2000);
        }).error(function(error){
            console.log("ERROR: ", error);
        });
    };
})

.controller('InductionStaff', function($scope, $http, $window) {
    $scope.onSuccess = function(response) {
        $window.location.reload();
        console.log(response);
        // $scope.contents[index].value = response.data.file_name;
        // $scope.updateContent(index);
    };

    $scope.fields = [];

    $scope.onUploadFileSuccess = function(response, key) {
        $scope.fields[key] = response.data.file_name;
        console.log(key, $scope.fields);
    };
})

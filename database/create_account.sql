INSERT INTO `users` (`user_id`, `status`, `is_admin`, `is_staff`, `is_client`, `access_level`, `email_address`, `username`, `password`) VALUES
(1, 1, 1, 1, 0, 0, '$email_address', '$username', '$password');

INSERT INTO `user_staffs` (`staff_id`, `user_id`) VALUES
(1, 1);
<?php
    class UserService {
        public static function getUserById($users, $id) {
            foreach($users as $user) {
                if ($user->id == $id) {
                    return $user;
                }
            }
            return null;
        }
        
        public static function outputUsers($users, $type) {
            $mask = "|%20s |%20s |\n";
            if ($type == 'countAverageLineCount') {
                printf($mask, 'name', 'countAverageLineCount');
                foreach($users as $user) {
                    printf($mask, $user->name, round($user->lines / $user->filesCount, 2));
                }
            }
            if ($type == 'replaceDates') {
                printf($mask, 'name', 'replaceDates');
                foreach($users as $user) {
                    printf($mask, $user->name, $user->replacementCount);
                }
            }
        }
    }
?>
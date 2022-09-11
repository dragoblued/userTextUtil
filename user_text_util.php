<?php
	require_once 'User.php';
	require_once 'UserService.php';
	require_once 'File.php';

    $delimetr = ';';
    if (isset($argv[1])) {
        if ($argv[1] == 'comma') {
            $delimetr = ',';
        }
    }

    $file = new File();
    $users = [];
    $folder = './texts';
    $filename = './people.csv';

    $lines = $file->read($filename);
    foreach ($lines as $line) {
        $data = explode($delimetr, trim($line));
        if ($data[0] != 'id') {
            $users[] = new User($data[0], $data[1]);
        }
    }

    $dir = opendir($folder);
    $files = [];

    if ($dir) {
        while (false !== ($item = readdir($dir)))   {
            if ($item != "." && $item != "..")
            {
                $n = explode('-', $item);
                if (substr_count((string)$n[1], '0') <= 4) {
                    $files[] = $item;
                }
            }
        }
    }
    if (isset($argv[2])) {
        if ($argv[2] == 'countAverageLineCount') {
            foreach($files as $item) {
                $idUser = explode('-', trim($item))[0];
                $user = UserService::getUserById($users, $idUser);
                $user->filesCount += 1;
                $lines =  $file->read($folder . '/' . $item);
                $user->lines += count($lines);
            }
            UserService::outputUsers($users, 'countAverageLineCount');
        }
        if ($argv[2] == 'replaceDates') {
            foreach($files as $item) {
                $lines =  $file->read($folder . '/' . $item);
                $text = [];
                $idUser = explode('-', trim($item))[0];
                $user = UserService::getUserById($users, $idUser);
                foreach ($lines as $key => $line) {
                    $words = explode(' ', trim($line));
                    foreach ($words as $key => $word) {
                        $date = explode('/', $word);
                        if (count($date) == 3) {
                            if (checkdate((int)$date[1], (int)$date[0], (int)$date[2])) {
                                $words[$key] = $date[1] . '-' . $date[0] . '-' . $date[2];
                                $user->replacementCount += 1;
                            }
                        }
                        
                    }
                    $text[] = implode(' ', $words);
                }
                $file->write('./output_texts' . '/' . $item, implode(PHP_EOL, $text));
            }
            UserService::outputUsers($users, 'replaceDates');
        }
    }
?>

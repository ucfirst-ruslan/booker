<?php

define('DB_HOST', '127.0.0.1');
define('DB_DB', 'booker');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('PRF', 'bk_'); //префикс для таблиц

define('EXPIRE_TOKEN', 1800); // 30мин - время жизни токена
define('AUTH', false); // 'false' - debug mode, else 'true'

define('SUCC_DEL_ROOM', 'Room deleted');
define('SUCC_LOGIN', 'User is authorized');

define('SUCC_DEL_USER', 'User inactive');

define('CODE_204', 'No Content');
define('CODE_400', 'Bad Request');
define('CODE_403', 'Forbidden');
define('CODE_404', 'Not Found');
define('CODE_406', 'Not Acceptable');
define('CODE_405', 'Method Not Allowed');



define('ERR_001', 'Invalid Token');
define('ERR_002', 'Authorisation Error');

define('ERR_003', 'This room does not exist');
define('ERR_004', 'To work with the service you need to pass authorization');
define('ERR_005', 'To continue working with the service, you must have administrator rights');
define('ERR_006', 'Error creating room. Check the input data.');
define('ERR_007', 'Error updating room. Check the input data.');
define('ERR_008', 'Room not found');
define('ERR_009', 'LogOut Successful');
define('ERR_010', 'This user does not exist');
define('ERR_011', 'Error creating user. Check the input data.');
define('ERR_012', 'Error updating user. Check the input data.');
define('ERR_013', 'User not found');
define('ERR_014', 'User cannot be deleted. He has active events.');
define('ERR_015', 'No data');
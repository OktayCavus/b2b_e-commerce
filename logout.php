<?php

require_once 'system/config.php';

session_destroy();
header('Location:' . site);

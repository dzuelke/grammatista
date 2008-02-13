<?php

gettext("F\to	o 'Bar' \" lol" . '\\' . "
baz");

$tm->_("F\to	o 'Bar' \" lol\\
baz", 'multiline.test');

?>
<?php
shell_exec('bash ./test1_disable_port.gnmic');
var_dump(http_response_code(200));
?>
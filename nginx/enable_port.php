<?php
shell_exec('bash ./scripts/test1_enable_port.gnmic');
var_dump(http_response_code(200));
?>
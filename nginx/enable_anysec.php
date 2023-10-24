<?php
shell_exec('bash ./scripts/test2_enable_anysec_peer.gnmic');
var_dump(http_response_code(200));
?>
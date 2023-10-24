<?php
shell_exec('bash ./scripts/test2_disable_anysec_peer.gnmic');
var_dump(http_response_code(200));
?>
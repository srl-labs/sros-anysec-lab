#!/bin/bash

### Install gnmic
bash -c "$(curl -sL https://get-gnmic.openconfig.net)"


### set Exec permissions for the html dir
chmod +x /opt/
chmod +x /opt/lampp/
chmod +x /opt/lampp/htdocs
chmod +x /opt/lampp/htdocs/html


## Set full permissions for script files
cd /opt/lampp/htdocs/html
chmod 777 *




echo "END script execution!"
#!/bin/bash
# Copyright 2023 Nokia
# Licensed under the BSD 3-Clause License.
# SPDX-License-Identifier: BSD-3-Clause


set -eu

startTraffic1-2() {
    echo "starting traffic between clients 1 and 2"
    docker exec client1 bash /config/icmp.sh
}

# start traffic
if [ $1 == "start-icmp" ]; then
    if [ $2 == "1-2" ]; then
        startTraffic1-2
    fi
fi
#!/bin/bash
# Copyright 2020 Nokia
# Licensed under the BSD 3-Clause License.
# SPDX-License-Identifier: BSD-3-Clause


set -eu

startTraffic1-2() {
    echo "starting traffic between clients 1 and 2"
    docker exec client2 bash /config/iperf.sh
}

stopTraffic1-2() {
    echo "stopping traffic between clients 1 and 2"
    docker exec client2 pkill iperf3
}


# start traffic
if [ $1 == "start" ]; then
    if [ $2 == "1-2" ]; then
        startTraffic1-2
    fi
fi

if [ $1 == "stop" ]; then
    if [ $2 == "1-2" ]; then
        stopTraffic1-2
    fi
fi
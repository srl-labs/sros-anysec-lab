# Copyright 2020 Nokia
# Licensed under the BSD 3-Clause License.
# SPDX-License-Identifier: BSD-3-Clause

# Start iperf3 server in the background
# with 8 parallel tcp streams, each 200 Kbit/s == 1.6Mbit/s
# using ipv6 interfaces


# Iperf server configured at .yml file and client at iperf.sh
#pkill iperf3

# Start server
#iperf3 -s -p 5202 -D > iperf3_2.log


pkill iperf3
iperf3 -c 2002::172:17:0:1 -t 10000 -i 1 -p 5201 -B 2002::172:17:0:2 -P 32 -b 125K -M 1400 &
#iperf3 -c 172.17.0.1 -t 10000 -i 1 -p 5201 -B 172.17.0.2 -P 32 -b 125K -M 1400 &


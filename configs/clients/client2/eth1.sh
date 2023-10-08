# Host 2 (Client/Server) config


ifconfig eth1 down
ifconfig eth1 up


# Iperf server configured at .yml file and client at iperf.sh
#pkill iperf3

# Start server
#iperf3 -s -p 5202 -D > iperf3_2.log

# Start client to host 1
#iperf3 -c 2002::172:17:0:1 -t 10000 -i 1 -p 5201 -B 2002::172:17:0:2 -P 32 -b 125K -M 1400 &
#iperf3 -c 172.17.0.1 -t 10000 -i 1 -p 5201 -B 172.17.0.2 -P 32 -b 125K -M 1400 &



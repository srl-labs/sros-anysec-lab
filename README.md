
# CLAB SROS FP5 AnySec Demo

ANYSec is a Nokia technology that provides low-latency and line-rate native encryption for any transport (IP, MPLS, segment routing, Ethernet or VLAN), on any service, at any time and for any load conditions without impacting performance.

This lab provides an Anysec demo (https://www.nokia.com/networks/technologies/fp5/) based on Nokia SROS FP5 vSIMs running at CLAB (https://containerlab.dev/).




## Anysec Overview
Anysec is a Nokia network encryption solution available with the new FP5 models in SROS 23.3R3 and 23.7R1. 
It is quantum safe, low-latency line-rate encryption, and aims to be the future network encryption standard in the industry.
It is a simple concept, it uses MacSec standards as the foundation and introduces the flexibility to offset the authentication and encription to allow L2, L2.5 and L3 encryption.



## Clone the git lab to your server

To deploy these labs, you must clone these labs to your server with "git clone".

```bash
# change to your working directory
cd /home/user/
# Clone the lab to your server
git clone https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec.git
```


## SROS Image and License file

### SROS Image

The SROS vSIMs image files are available under Nokia's internal registry. 
If you don't have access to it, then you must get the SROS image and manually import them to CLAB following the instructions here: https://containerlab.dev/manual/vrnetlab/#vrnetlab

The stepts are:
```bash
# Clone vrnetlab
git clone https://github.com/hellt/vrnetlab && cd vrnetlab

# Download qcow2 vSIM image from Nokia support portal (https://customer.nokia.com/support/s) or get one from your Nokia contact. 

# Change name to “sros-vm-<VERSION>.qcow2”

# Upload it to ‘vrnetlab/sros’ directory (e.g. /home/vrnetlab/sros)

# Run ‘make docker-image’ to start the build process

# Verify existing docker images

docker images | grep -E "srlinux|vr-sros"
```

Note: After import the image, edit the yml file with the correct location.
```bash
# replace this 
      image: registry.srlinux.dev/pub/vr-sros:23.7.R1
# with this:
      image: vrnetlab/vr-sros:23.7.R3
```

### License file

SROS vSIMs require a valid license. You need to get a valid license from Nokia and place it in the "/r23_license.key" file.
```bash
# Copy/paste the license to the "r23_license.key" file
cd SROS_CLAB_FP5_Anysec/
vi r23_license.key
# press "i" key for insert mode => paste the license => ctl+x to save and exit 
```



## Anysec setup

The setup contains four SROS FP5 routers with 23.7R1, howhever only two of them have Anysec configured:

•	SR-1 => Anysec enabled

•	SR-1Se => Anysec enabled

•	SR-7s (FP5 only)

•	SR-14s (FP5 only)





The physical setup is the following (for the tests you may shut the interface as ilustrated):



<p align="center">
  <img width="500" height="300" src="https://user-images.githubusercontent.com/86619221/274623979-ee5e844c-2696-489d-bc53-81c9b19b33af.PNG">
</p>

The setup has:

•	Anysec between R1 and R2 (not supported in SR-2s and SR-7s/14s in this release )

•	ISIS 0 with SR-ISIS

•	iBGP

•	Services: VLL 1001, VPLS 1002 (not used), VPRN 1003





The logical setup for the VPRN 1003 is the following (Tests with ICMP between PEs):



<p align="center">
  <img width="750" height="400" src="https://user-images.githubusercontent.com/86619221/274623975-58cdedd9-15fd-41df-9744-04cbbfc10973.PNG">
</p>


The logical setup for the VLL 1001 is the following (Tests with ICMP or iPerf between clients):



<p align="center">
  <img width="500" height="300" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/53ee647e132ca214a031c6bb18fa48dda6a20ab5/pics/vll.png">
</p>



## Deploy the lab setup

Use the comand below to deploy the lab:

Note: If you imported the SROS image to docker then first edit the yml file with the correct image location as explained above.

```bash
# deploy a lab
cd SROS_CLAB_FP5_Anysec/
clab deploy --topo anysec.yml
```



## Accessing the network elements

Once the lab has been deployed, the different SROS nodes can be accessed via SSH through their management IP address, given in the summary displayed after the execution of the deploy command. 
It is also possible to reach those nodes directly via their hostname, defined in the topology file. 

```bash
# List the containers
clab inspect -a
# reach a SROS node via SSH
ssh admin@clab-anysec-SR-1x-92S
# reach Linux clients via docker
docker exec -it client1 bash
```


## Wireshark

For details about Packet capture & Wireshark at containerlab refer to:
https://containerlab.dev/manual/wireshark/#capturing-with-tcpdumpwireshark


You may found a pcap file with Anysec packets in the files above in this project. 
You may perform your own capture as explained below.

Follows an example on how to list the interfaces (links) of a given container and perform a packet capture:
```bash
# list the containers running in the server
clab inspect -a 
# list the interfaces (links) of a given container
ip netns exec clab-anysec-SR-1x-92S ip link
# Start a capture and display packets in the session
ip netns exec clab-anysec-SR-1x-92S tcpdump -nni eth1
# Start a capture and store the packets in the file
ip netns exec clab-anysec-SR-1x-92S tcpdump -nni eth1 -w capture_file.pcap
```


Besides displaying the packets to the session or store in a file, its possible to open then remotely using SSH.

Windows users should use WSL and invoke the command similar to the following:
```bash
ssh $containerlab_host_address "ip netns exec $lab_node_name tcpdump -U -nni $if_name -w -" | /mnt/c/Program\ Files/Wireshark/wireshark.exe -k -i -
Example:
ssh root@10.82.182.179 "ip netns exec clab-anysec-SR-1x-92S tcpdump -U -nni eth1 -w -" | /mnt/c/Program\ Files/Wireshark/wireshark.exe -k -i -
```

### Install WSL 
Open PowerShell or Windows Command Prompt in administrator mode by right-clicking and selecting "Run as administrator", enter the wsl --install command, then restart your machine.

See derails here: https://learn.microsoft.com/en-us/windows/wsl/install



## SROS Streaming Telemetry and Automation

This lab was enhanced with Streaming Telemetry by adding gNIMc, Prometheus and Grafana.

For details please refer to: 
https://github.com/srl-labs/srl-sros-telemetry-lab

It includes automation for the tests using gNMIC scripts invoked through PHP. There are 2 tests:

1 - disable/enable the top link to see ANYSec packets flowing through the bottom nodes.

2 - disable/enable ANYSec to see packets being sent in clear or encrypted on demand

To execute these tests there are 4 


### Telemetry stack

As the lab name suggests, telemetry is at its core. The following stack of software solutions has been chosen for this lab:

| Role                | Software                               | Port               | Link                               | Credentials        |
| ------------------- | -------------------------------------- |------------------- | ---------------------------------- |------------------- |
| Telemetry collector | [gnmic](https://gnmic.openconfig.net)  | 57400              |                                    |                    |
| Time-Series DB      | [prometheus](https://prometheus.io)    | 9090               | http://localhost:9090/graph        |                    |
| Visualization       | [grafana](https://grafana.com)         | 3000               | http://localhost:3000              | admin/admin        |
| Web Server          | [xampp](https://www.apachefriends.org/)| 9080               | http://localhost:9080/             |                    |


### Access details

If you are accessing from a remote host, then replace localhost by the CLAB Server IP address
* Grafana: <http://localhost:3000>. Built-in user credentials: `admin/admin`
* Prometheus: <http://localhost:9090/graph>
* xampp Demo Page: <http://localhost:9080/>

Note: The grafana control panel dashboard buttons will not work when accessing remotely. 
You may update the button URL to match your server's IP@:port (CLAB:9080 or xampp:80) or use the xampp Demo Page instead. xampp server contains PHP scripts that execute gnmic scripts to deploy the node configs.


## Verify the setup

Verify that you're able to access all nodes (PEs and clients) and the platforms (Grafana, Prometheus and Demo Page).
Start a Tcpdump/wireshark capture and start traffic between PE1 and PE2 under VPRN 1003.

```bash
A:admin@R1_sr-1x-92s# ping 2.2.2.2 router-instance 1003 
PING 2.2.2.2 56 data bytes
64 bytes from 2.2.2.2: icmp_seq=1 ttl=64 time=8.35ms.
64 bytes from 2.2.2.2: icmp_seq=2 ttl=64 time=2.63ms.
64 bytes from 2.2.2.2: icmp_seq=3 ttl=64 time=2.26ms.
64 bytes from 2.2.2.2: icmp_seq=4 ttl=64 time=2.15ms.
64 bytes from 2.2.2.2: icmp_seq=5 ttl=64 time=2.26ms.

---- 2.2.2.2 PING Statistics ----
5 packets transmitted, 5 packets received, 0.00% packet loss
round-trip min = 2.15ms, avg = 3.53ms, max = 8.35ms, stddev = 2.42ms

[/]
A:admin@R1_sr-1x-92s# 
```

You may also test ICMP or iPerf between client1 and 2 (uses VLL 1001).

```bash
### Ping from Client 1 to Client 2
bash-5.0# ping -c 2 172.17.0.2      
PING 172.17.0.2 (172.17.0.2) 56(84) bytes of data.
64 bytes from 172.17.0.2: icmp_seq=1 ttl=64 time=4.37 ms
64 bytes from 172.17.0.2: icmp_seq=2 ttl=64 time=3.75 ms

--- 172.17.0.2 ping statistics ---
2 packets transmitted, 2 received, 0% packet loss, time 1002ms
rtt min/avg/max/mdev = 3.748/4.059/4.371/0.311 ms
bash-5.0# 
```


Note: Under normal operation, ping will use SR-ISIS directly from R1 to R2.
You may shut the link between these nodes to force the use of SR-ISIS that goes through R4 and R3.
You may also disable Anysec to view packets in clear.


Wireshark does not have native support for decoding ANYSec MACsec (802.1AE) headers.
Nokia has an internal version with a protocol dissector for MACsec / 802.1a headers.
This is the output comparison between the public wireshark and the Nokia's version:


![pic1](https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/Anysec_Wireshark.png)






## Outputs

Use the following commands under R1 or R2 to retrieve outputs from Anysec operation:


```bash
show macsec connectivity-association "CA_Test_MACSec" detail 
show anysec tunnel-encryption detail 
show router 1003 route-table 2.2.2.2/32 extensive 
show router tunnel-table detail 
show router mpls-labels summary 
show router "1003" route-table 
show router bgp routes 2.2.2.2/32 vpn-ipv4 hunt   
```

## Demo Video

The Demo Video shows the Grafana Dashboard, the wireshark and the CLI with ICMP. Two tests are performed: disable/enable the top link and disable/enable ANYSec.


[![Watch the video](http://img.youtube.com/vi/Ka6-zXaPYGI/maxresdefault.jpg)](https://youtu.be/Ka6-zXaPYGI)


## Tests

The tests bellow can be executed in multiple ways: grafana, demo page, gnmic scripts or node CLI.


### Test 1 - Shut/No shut the link between R1 and R2 

Upon shut/no shut verify Anysec is still working but using a new SR-ISIS tunnel
```bash
show router "1003" route-table
show router 1003 route-table 2.2.2.2/32 extensive
show router 1003 route-table 2.2.2.2/32 extensive
show router bgp routes 2.2.2.2/32 vpn-ipv4 hunt   
```




<p align="center">
  <img width="400" height="300" src="https://user-images.githubusercontent.com/86619221/274623972-2115f64a-e807-423d-96c4-f86e0a1d5165.PNG">
</p>

### Test 2 - Disable Anysec at R1 and R2 

Upon Disable Anysec verify ping is still working but unecripted
Re-enable Anysec and verify traffic is encrypted again




<p align="center">
  <img width="600" height="400" src="https://user-images.githubusercontent.com/86619221/274623965-c9ef260f-9e5f-4d72-8361-7688aeafc5c0.PNG">
</p>

## Conclusion

Does Anysec work with CLAB vSIMs?

Yes for functional tests, but obviously not for performance/latency.
CLAB and vSIMs can be used to test and validate the configurations. 
Setup is fully functional with anysec stats increase and packets are encrypted as seen in the TCPDUMP capture.
Anysec is still a limited feature with no support yet for modular Chassis. 
More to come in the upcoming releases!



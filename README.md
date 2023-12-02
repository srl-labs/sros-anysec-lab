
# CLAB SROS FP5 AnySec Demo

ANYSec is a Nokia technology that provides low-latency and line-rate native encryption for any transport (IP, MPLS, segment routing, Ethernet or VLAN), on any service, at any time and for any load conditions without impacting performance.

This lab provides an Anysec demo based on Nokia SROS FP5 (https://www.nokia.com/networks/technologies/fp5/) vSIMs running at CLAB (https://containerlab.dev/).




## Anysec Overview
Anysec is a Nokia network encryption solution available with the new FP5 models in SROS 23.10R1. 
It is low-latency line-rate encryption, scalable, flexible and ensures a quantum-safe network encryption solution for the industry.
It is a simple concept, based on MacSec standards as the foundation and introduces the flexibility to offset the authentication and encription to allow L2, L2.5 and L3 encryption.



## Clone the git lab to your server

To deploy these labs, you must clone these labs to your server with "git clone".

```bash
# change to your working directory
cd /home/user/
# Clone the lab to your server
git clone https://github.com/srl-labs/sros-anysec-lab.git
```


## SROS Image and License file

### SROS Image

The SROS vSIMs image file used is 23.10R1, and is available under Nokia's internal registry. 
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
      image: registry.srlinux.dev/pub/vr-sros:23.10.R1
# with this:
      image: vrnetlab/vr-sros:23.10.R1
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

The setup contains four SROS FP5 routers with 23.10R1, howhever only two of them have Anysec configured:

•	SR-1 => Anysec enabled

•	SR-1Se => Anysec enabled

•	SR-7s (FP5 only)

•	SR-14s (FP5 only)





The physical setup is the following (for the tests you may shut the interface as ilustrated):



<p align="center">
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/physical-setup.jpg?raw=true">
</p>

The setup has:

•	Anysec between R1 and R2 (not supported in SR-2s and SR-7s/14s in this release )

•	ISIS 0 with SR-ISIS

•	iBGP

•	Services: VLL 1001 and VPRN 1003





The logical setup for the VPRN 1003 is the following (Tests with ICMP between PEs):



<p align="center">
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/vprn.jpg?raw=true">
</p>


The logical setup for the VLL 1001 is the following (Tests with ICMP or iPerf between clients):



<p align="center">
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/vll.jpg?raw=true">
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
ip netns exec r1 ip link
# Start a capture and display packets in the session
ip netns exec r1 tcpdump -nni eth1
# Start a capture and store the packets in the file
ip netns exec r1 tcpdump -nni eth1 -w capture_file.pcap
```


Besides displaying the packets to the session or store in a file, its possible to open then remotely using SSH.

Windows users should use WSL and invoke the command similar to the following:
```bash
ssh $containerlab_host_address "ip netns exec $lab_node_name tcpdump -U -nni $if_name -w -" | /mnt/c/Program\ Files/Wireshark/wireshark.exe -k -i -
Example:
ssh root@10.82.182.179 "ip netns exec r1 tcpdump -U -nni eth1 -w -" | /mnt/c/Program\ Files/Wireshark/wireshark.exe -k -i -
```

### Install WSL 
Open PowerShell or Windows Command Prompt in administrator mode by right-clicking and selecting "Run as administrator", enter the wsl --install command, then restart your machine.

See derails here: https://learn.microsoft.com/en-us/windows/wsl/install



## SROS Streaming Telemetry and Automation

This lab was enhanced with Streaming Telemetry by adding gNIMc, Prometheus and Grafana.

For details please refer to: 
https://github.com/srl-labs/srl-sros-telemetry-lab

It includes automation for the tests using gNMIC scripts invoked through PHP under the Web Server. There are 2 tests:

1 - disable/enable the top link to see ANYSec packets flowing through the bottom nodes.

2 - disable/enable ANYSec to see packets being sent in clear or encrypted on demand

To execute these tests there are 8 scripts (4 PHP and 4 gnmic). Each of the 4 buttons execute one PHP script, that in turn invoque one gnmic script.


### Telemetry and automation stack

The following stack of software solutions has been chosen for this lab:

| Role                | Software                               | Port               | Link                               | Credentials        |
| ------------------- | -------------------------------------- |------------------- | ---------------------------------- |------------------- |
| Telemetry collector | [gnmic](https://gnmic.openconfig.net)  | 57400              |                                    |                    |
| Time-Series DB      | [prometheus](https://prometheus.io)    | 9090               | http://localhost:9090/graph        |                    |
| Visualization       | [grafana](https://grafana.com)         | 3000               | http://localhost:3000              | admin/admin        |
| Web Server/gnmic    | [xampp](https://www.apachefriends.org/)| 9080               | http://localhost:9080/             |                    |



The following picture picture ilustrates the Telemetry and Automation stack:



<p align="center">
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/telemetry_automation.jpg?raw=true">
</p>




### Access details

If you are accessing from a remote host, then replace localhost by the CLAB Server IP address
* Grafana: <http://localhost:3000>. Built-in user credentials: `admin/admin`
* Prometheus: <http://localhost:9090/graph>
* xampp Demo Page: <http://localhost:9080/>   ### Alternative option to the Grafana Buttons

Note: Xampp server contains PHP scripts that execute gnmic scripts to deploy the node configs. The grafana control panel dashboard buttons invoque these scripts but will not work when accessing remotely. The requests are generated by the end user browser directly to the URL in the button.
You may update the button URL to match your CLAB server's IP@:port (<Server-IP>:9080) or use the xampp Demo Page instead. 
Another option is to establish a SSH to the CLAB Server with tunneling from localhost:9080 towards the Web Server 172.10.10.24:80. 


## Verify the setup

Verify that you're able to access all nodes (PEs and clients) and the platforms (Grafana, Prometheus and Demo Page).
Start a Tcpdump/wireshark capture and start ICMP traffic between client1 and 2 (uses VLL 1001) using the traffic.sh script.

```bash
### Ping from Client 1 to Client 2
django@orchestra:~/sros-anysec-lab$ ./traffic.sh start-icmp 1-2
starting traffic between clients 1 and 2
PING 2002::172:17:0:2(2002::172:17:0:2) 1450 data bytes
1458 bytes from 2002::172:17:0:2: icmp_seq=1 ttl=64 time=4.41 ms
1458 bytes from 2002::172:17:0:2: icmp_seq=2 ttl=64 time=2.31 ms
1458 bytes from 2002::172:17:0:2: icmp_seq=3 ttl=64 time=2.26 ms
1458 bytes from 2002::172:17:0:2: icmp_seq=4 ttl=64 time=3.61 ms
^C
```


Note: Under normal operation, ping will use SR-ISIS directly from R1 to R2.
You may shut the link between these nodes to force the use of SR-ISIS that goes through R4 and R3.
You may also disable Anysec to view packets in clear.



### Wireshark ANYSec Decoding



Wireshark does not have native support for decoding ANYSec MACsec (802.1AE) headers. 
Nokia has an internal version with a protocol dissector for ANYSec MACsec / 802.1a headers.
This is the output comparison between the public wireshark and the Nokia's version:


![pic1](https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/Anysec_Wireshark.jpg)


With the public Wireshark, the ANYSec header is shown as part of the payload.




### Anysec Stack


The ANYSec introduces the MACSec Header and the Encryption SID (ES) label between the SR-ISIS transport and VPRN service labels. The VPRN service label is encrypted.
The picture below provides an example of the ANYSec label stack between R1 and R2.


![pic1](https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/Anysec_Stack.jpg?raw=true)




### Capture multiple interfaces 


TCPDUMP on a single interface shows label stack correctly (Ethernet+VLAN+MPLS+ANYSec)
TCPDUMP on a multiple interfaces shows a distinct stack: Linux cooked capture v2 + additional MPLS Label (instead of Ethernet + VLAN)


![pic1](https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/Anysec_Tcpdump.jpg?raw=true)





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
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/LINK-DOWN.jpg?raw=true">
</p>

### Test 2 - Disable Anysec at R1 and R2 

Upon Disable Anysec verify ping is still working but unecripted
Re-enable Anysec and verify traffic is encrypted again




<p align="center">
  <img width="900" height="500" src="https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/ANYSEC-DISABLE.jpg?raw=true">
</p>





## Demo Video

The Demo Video shows the Grafana Dashboard, the wireshark and the CLI with ICMP. Two tests are performed: disable/enable the top link and disable/enable ANYSec.


[![Watch the video](http://img.youtube.com/vi/Ka6-zXaPYGI/maxresdefault.jpg)](https://youtu.be/Ka6-zXaPYGI)






## Conclusion

Does Anysec work with CLAB vSIMs?

Yes for functional tests, but obviously not for performance/latency.
CLAB and vSIMs can be used to test and validate the configurations. 
Setup is fully functional with anysec stats increase and packets are encrypted as seen in the TCPDUMP capture.
Anysec is still a limited feature with no support yet for modular Chassis. 
More to come in the upcoming releases!



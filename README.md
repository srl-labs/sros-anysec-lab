
# CLAB SROS FP5 AnySec Demo

ANYsec provides low-latency, native encryption for any transport (IP, MPLS, segment routing, Ethernet or VLAN), on any service, at any time and for any load conditions without impacting performance.

This lab provides an Anysec demo (https://www.nokia.com/networks/technologies/fp5/) based on Nokia SROS FP5 vSIMs running at CLAB (https://containerlab.dev/).




## Anysec Overview
Anysec is a Nokia network encryption solution available with the new FP5 models in SROS 23.3R3 and 23.7R1. 
It is quantum safe, low latency line rate encryption, and aims to be the future network encryption standard in the industry.
It is a simple concept, based on MacSec standards but more flexible, capable of L2, L2.5 and L3 encryption.



## Clone the git lab to your server

To deploy these labs, you should clone these labs to your server with "git clone".

```bash
# change to your home directory
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

SROS vSIMs require a valid license. You need to get a valid license from Nokia and place it in the "r23_license.lic" file.
```bash
# Copy/paste the license to the "r23_license.lic" file
cd SROS_CLAB_FP5_Anysec/
vi r23_license.lic
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

•	Services: VPRN 1003





The logical setup is the following (for the tests you may shut the interface as ilustrated):



<p align="center">
  <img width="750" height="400" src="https://user-images.githubusercontent.com/86619221/274623975-58cdedd9-15fd-41df-9744-04cbbfc10973.PNG">
</p>

## Deploy the lab setup

Use the comand below to deploy the lab:
Note: If you imported the SROS image to docker then edit the yml file with the correct image location.

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
```


## Wireshark

For details about Packet capture & Wireshark at containerlab refer to:
https://containerlab.dev/manual/wireshark/#capturing-with-tcpdumpwireshark


You may found a pcap file with Anysec packets in the files above in this project. 
You may perform your own capture as explained below.

Follows an example on how to list the interfaces (links) of a given container and performe a packet capture:
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


## Execute the test

Once the Tcpdump capture is running you may start the test by testing ICMP from R1 to R2 within VPRN 1003:
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


Note: Under normal operation, ping will use SR-ISIS directly from R1 to R2
You may shut the link between these nodes to force the use of SR-ISIS that goes through R4 and R3


Wireshark does not have native support for decoding MACsec (802.1AE) headers.
Nokia has an internal version with a protocol dissector for MACsec / 802.1a headers.
This is the output comparison between the public wireshark and the Nokia's version:


![pic1](https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec/blob/main/pics/Anysec_Wireshark.png)






## Outputs

Use the following commands to retrieve outputs from Anysec operation:


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

[![Watch the video](https://i.stack.imgur.com/Vp2cE.png)](https://github.com/srlinuxeurope/SROS_CLAB_FP5_Anysec/blob/main/pics/Demo_anysec_srExpertsPT_v2.mov)


## Tests

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




# CLAB SROS FP5 AnySec Demo

This lab provides a simple Anysec Demo based on CLAB and Nokia SROS FP5 vSIMs.
ANYsec provides low-latency, native encryption for any transport (IP, MPLS, segment routing, Ethernet or VLAN), on any service, at any time and for any load conditions without impacting performance.

For Anysec refer to https://www.nokia.com/networks/technologies/fp5/
For CLAB refer to https://containerlab.dev/.



## Anysec Overview
Anysec is a Nokia network encryption solution available with the new FP5 models in SROS 23.3R3 and 23.7R1. 
It is quantum safe, low latency line rate encryption, and aims to be the future network encryption standard in the industry.
It is a simple concept, based on MacSec standards but more flexible, capable of L2, L2.5 and L3 encryption.
This lab 


## Clone the git lab to your server

To deploy these labs, you should clone these labs to your server with "git clone".

```bash
# change to your home directory
cd /home/user/
# Clone the lab to your server
git clone https://github.com/tiago-amado/SROS_CLAB_FP5_Anysec.git
```


## License file

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


The setup has:

•	Anysec between R1 and R2 (not supported in SR-2s and SR-7s/14s in this release )

•	ISIS 0 with SR-ISIS

•	iBGP

•	Services: VPRN 1003



The physical setup is the following:

![pic1](https://user-images.githubusercontent.com/86619221/205601635-609eb772-833b-4ac9-b2ab-dc3ed661c4a1.JPG)


The logical setup is the following:

![pic1](https://user-images.githubusercontent.com/86619221/205601635-609eb772-833b-4ac9-b2ab-dc3ed661c4a1.JPG)



## Deploy the lab setup

Use the comand below to deploy the lab:

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
ssh admin@clab-clab-hw_models_FP5_SR-1-SR-1-24D
```



## Wireshark




Wireshark does not have native support for decoding MACsec (802.1AE) headers.
Nokia has an internal version with a protocol dissector for MACsec / 802.1a headers.
This is the output:


![pic1](https://user-images.githubusercontent.com/86619221/205601635-609eb772-833b-4ac9-b2ab-dc3ed661c4a1.JPG)





## Conclusion

Does Anysec work with vSIM at CLAB?
Yes for functional tests, but obviously not for performance/latency.
CLAB and vSIM can be used to validate the configuration (functional tests Encryption)
Limited feature with no support yet for modular Chassis (how about multi-complex FP5 cards/nodes)
Setup is fully functional with anysec stats increase and packets are encrypted as seen in the TCPDUMP capture



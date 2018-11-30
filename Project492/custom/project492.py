#!/usr/bin/python

from mininet.topo import Topo
from mininet.net import Mininet
from mininet.node import Node
from mininet.log import setLogLevel, info
from mininet.cli import CLI


class LinuxRouter( Node ):
    "A Node with IP forwarding enabled."

    def config( self, **params ):
        super( LinuxRouter, self).config( **params )
        # Enable forwarding on the router
        self.cmd( 'sysctl net.ipv4.ip_forward=1' )

    def terminate( self ):
        self.cmd( 'sysctl net.ipv4.ip_forward=0' )
        super( LinuxRouter, self ).terminate()


class NetworkTopo( Topo ):
    "A LinuxRouter connecting three IP subnets"

    def __init__( self ):
        "Create custom topo."
	Topo.__init__( self )
	
        defaultIP = '192.168.1.1/24'  # IP address for r0-eth1
        router = self.addNode( 'r0', cls=LinuxRouter, ip=defaultIP )

        s1, s2, s3, s4, s5, s6 = [ self.addSwitch( s ) for s in ( 's1', 's2', 's3', 's4', 's5', 's6' ) ]

        self.addLink( s1, router, intfName2='r0-eth1',
                      params2={ 'ip' : defaultIP } )  # for clarity
        self.addLink( s2, router, intfName2='r0-eth2',
                      params2={ 'ip' : '172.0.0.1/24' } )
        self.addLink( s3, router, intfName2='r0-eth3',
                      params2={ 'ip' : '163.0.0.1/24' } )
	self.addLink( s4, router, intfName2='r0-eth4',
                      params2={ 'ip' : '154.0.0.1/24' } )
	self.addLink( s5, router, intfName2='r0-eth5',
                      params2={ 'ip' : '145.0.0.1/24' } )
	self.addLink( s6, router, intfName2='r0-eth6',
                      params2={ 'ip' : '136.0.0.1/24' } )

        h1 = self.addHost( 'h1', ip='192.168.1.100/24',
                           defaultRoute='via 192.168.1.1' )
	h2 = self.addHost( 'h2', ip='192.168.1.101/24',
                           defaultRoute='via 192.168.1.1' )
	h3 = self.addHost( 'h3', ip='192.168.1.102/24',
                           defaultRoute='via 192.168.1.1' )
	
        se1 = self.addHost( 'se1', ip='172.0.0.100/24',
                           defaultRoute='via 172.0.0.1' )
        se2 = self.addHost( 'se2', ip='163.0.0.100/24',
                           defaultRoute='via 163.0.0.1' )
        se3 = self.addHost( 'se3', ip='154.0.0.100/24',
                           defaultRoute='via 154.0.0.1' )
	se4 = self.addHost( 'se4', ip='145.0.0.100/24',
                           defaultRoute='via 145.0.0.1' )
 	se5 = self.addHost( 'se5', ip='136.0.0.100/24',
                           defaultRoute='via 136.0.0.1' )

        for h, s in [ (h1, s1),(h2, s1),(h3, s1), (se1, s2), (se2, s3), (se3, s4), (se4, s5), (se5, s6) ]:
            self.addLink( h, s )
topos = { 'mytopo': ( lambda: NetworkTopo() ) }


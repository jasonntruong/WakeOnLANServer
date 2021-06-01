import sys
from wakeonlan import send_magic_packet

#MAC address is stored as a system argument from PHP script; PHP obtains MAC address from environment variables --> don't want to hand out my MAC address :D
send_magic_packet(str(sys.argv[1]))
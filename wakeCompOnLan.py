import os
from wakeonlan import send_magic_packet

#values stored in Environment variables --> don't want to hand out my ip address :D
PHYSADDRESS = os.environ["PC_PHYS_ADDRESS"]

send_magic_packet(str(PHYSADDRESS))
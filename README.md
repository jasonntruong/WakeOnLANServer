# WakeOnLAN Server to power on my computer over LAN using my Google Home

Yes, there are other ways to do this without any coding necessary, but that requires giving services your IP and PC MAC address.
It also seemed like it'd be a fun project to do from scratch :D -- If you wanted to also turn your computer on over LAN, I'll leave how below

**Required: Windows, [XAMPP Control Panel] (https://www.apachefriends.org/download.html), PHP, Python **

## A. Go into BIOS and turn on "Wake up over LAN" or something of that nature...depends on your BIOS

## B. Allowing wake on LAN


## C. Setting up XAMPP Control Panel
1. You can find videos about it online, but basically delete everything in the htdocs folder and add the repo files there
2. Start the Apache and MySQL modules on the XAMPP Control Panel

## D. Setting up Environment Variables
1. Click Start and search for "Edit the system environment variables"
2. Click the top "New..." button: For the variable name put "PC_PHYS_ADDRESS" 

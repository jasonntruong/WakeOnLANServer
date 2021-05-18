# WakeOnLAN Server to power on my computer over LAN using my Google Home

Yes, there are other ways to do this without any coding necessary, but that requires giving services your IP and PC MAC address.
It also seemed like it'd be a fun project to do from scratch so I can get my foot through the "PHP door" :D -- If you wanted to also turn your computer on over LAN, I'll leave how below

**Uses: PHP, Python, SQL, Apache**

**Required: Windows PC, XAMPP Control Panel (https://www.apachefriends.org/download.html), Windows Raspberry Pi**

## A. Allowing wake on LAN
1. Go into BIOS and turn on "Wake up over LAN" or something of that nature...depends on your BIOS
2. Click Start and search for "Command Prompt"
3. Type in " ipconfig /all " without the quotes. Find the network adapter with the most data -- we'll use that one
4. Click Start and search for "Device Manager"
5. Under Network adapters, find the network adapter from Step 3: Right click > Properties > Power Management > Check "Only allow a magic pakcet to wake the computer"

### Now on your Raspberry Pi !!

## B. Setting up Environment Variables
1. Click Start and search for "Edit the system environment variables"
2. Click the top "New..." button: For the variable name put "PC_PHYS_ADDRESS" and for the variable value put the Physical Address from the network adapter from Step A-3

## C. Setting up XAMPP Control Panel
1. You can find videos about it online, but basically delete everything in the htdocs folder and add the repo files there
2. Start the Apache and MySQL modules on the XAMPP Control Panel
3. By putting in the IPv4 Address from Step A-3 (ex: 123.456.789.101) or "localhost" into your browser, you should see a directory matching htdocs
4. Go through and open the wakeCompOnLan.php file. It should be a simple page that says "Wake On LAN Server"

## D. Making a publically accesible site
1. Find out how to port forward on your router. Port forward your public IP address to the IPv4 address in Step A-3 preferably on port 80.
2. For me, I go to my public IP address in my browser, login, go to Port Forwarding and change the values
3. Now you should be able to type in your public IP address like in Step C-3 and maneuver to the php file

## E. Setting up your Google Home
1. Make an IFTTT account (https://ifttt.com/) and set it up with your Google Home
2. Make a command where the IF is a Google assistant voice command (make it "Turn on Computer" or something similar) and the THEN is a webhook/web request
3. Make the URL field the URL to the screen that says "Wake ON LAN Server" from Step D-3 (Make sure it has the public IP address with the php file in the link)
4. Add "?computer=FROM_GOOGLE_HOME" without the quotations, to the end of the URL field in step E-3. This is the GET web request that sets $computer = FROM_GOOGLE_HOME
5. Make the method "GET" and leave everything else alone

## F. Done
1. Now all you got to do is test it out. Say your command from Step E and the computer, if all things are set up correctly, should turn on
2. It should also work if you put in the combined URL from E-4 into your browser

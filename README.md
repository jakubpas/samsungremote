# Samsung PHP Remote
Allows to replace oryginal samsung remote control
## How to run:

- find your device and tv ip and MAC
```sh
$ sudo arp-scan --interface=wlan0 --localnet
```
- edit samsungremote.php
- run:
```sh
$ php -S localhost:8081
```
- go to:
http://localhost:8081
- Enjoy!
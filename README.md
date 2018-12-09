# element_iot
###### Currently only GET Requests - updated soon
The PHP class makes it easy to access Zenner IoT's *ELEMENT IoT* platform.
It was builded for usage at [Stadtwerke Karlsruhe GmbH](https://stadtwerke-karlsruhe.de) , but can easily adapted
to any other Servers / Systems.
___
### Create Object

```PHP
  require "element_iot.inc.php";
  $element_iot = new element_iot("api_key_found_on_settings_api_keys", "your.domain");//__construct($api_key, $domain)
```
There is no need for declaring an Transfer Protocol.
It's always replaced with **https://**!
The domain has a default value setted up for the usage at swka.
___
### Accessible Functions

In the first version are four accessible functions implemented.
I will list them in the following, with Parameters and description:

```PHP
  $element_iot->get($tp = ["devices","readings"], [
        "id" => "1234567890"  
  ])// public function get($tp = [], $configuration = []);
```
The *get* function starts an GET Request to the given domain and returns the answered data formatted as PHP Array, for easy access.
**IMORTANT:** If you use the *["devices", "readings"]*, *["devices", "packets"]*, *["devices", "interfaces"]*, *["drivers", "instances"]*, *["mandates", "stats", "packets"]* or *["mandates", "stats", "created_devices"]* parameter an Device ID is requiered.

#### How to setup parameters?

  ( i ) *tp* stands for *type* and should define your request.
  All currently possible possibilities are listed and explained in the following:
 ##### Devices
 ```PHP
 $element_iot->get(["devices"]);
#    Returns an array of all devices, filled up with information like: name, interfaces, etc. (without readings!)
#    > Can be directed to one device - if needed just add an id in the configuration.

       $element_iot->get(["devices", "readings"], ["id" => "device_id_requiered"]);
      #    Returns an array of readings.
      #    > configuration
       $element_iot->get(["devices", "packets"], ["id" => "device_id_requiered"]);
      #    Returns an array of packets.
      #    > configuration
       $element_iot->get(["devices", "interfaces"], ["id" => "device_id_requiered"]);
      #    Returns an array of interfaces.
      #    > configuration
```
___
##### Devices
```PHP
 $element_iot->get(["tags"]);
#   Returns an array of tags.
#   > configuration
```
___
##### Parsers
```PHP
 $element_iot->get(["parsers"]);
#   Returns an array of parsers.
#   > configuration
```
___
##### Drivers
```PHP
 $element_iot->get(["drivers"]); //returns an HTTP 500 Error at the current ELEMENT Version!
#   Returns an array of tags.
#   > configuration

        $element_iot->get(["drivers", "instances"], ["id" => "device_id_requiered"]);
      #    Returns an array of driver instances.
      #    > configuration

```
___
##### Groups
```PHP
 $element_iot->get(["groups"]);
#   Returns an array of groups.
#   > configuration
```
___
##### Api_keys
```PHP
 $element_iot->get(["api_keys"]);
#   Returns an array of api_keys (if you are allowed to see them).
#   > configuration
```
___
##### Mandates
```PHP
 $element_iot->get(["mandates"]);
#   Returns an array of all mandates.
#   > configuration

       $element_iot->get(["mandates", "stats", "packets"], ["id" => "device_id_requiered"]);
      #    Returns an array of driver instances.
      #    > configuration
        $element_iot->get(["mandates", "stats", "created_devices"], ["id" => "device_id_requiered"]);
      #    Returns an array of driver instances.
      #    > configuration

```

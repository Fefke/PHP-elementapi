# element_iot
#### included in PHP
###### Currently only GET Requests - updated soon
The PHP class makes it easy to access Zenner IoT's *ELEMENT IoT* platform.
It was builded for usage at [Stadtwerke Karlsruhe GmbH](https://stadtwerke-karlsruhe.de) , but can easily adapted
to any other Servers / Systems.
___
### Create Object

```PHP
  require "element_iot.inc.php";
  $element_iot = new element_iot("api_key_found_on_settings->api_keys", "your.domain", "proxy_if_needed");//__construct($api_key, $domain = NULL, $proxy = NULL)
```
There is no need for declaring an Transfer Protocol.
It's always replaced with **https://**!
The domain has a default value setted up for the usage at swka.
___
### Accessible Functions
#### get()

In the first version are six accessible functions implemented.
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
  The configuration is the same as listed on the [official api documentation](https://docs.element-iot.com/api/configuration/pagination/).
  
  ###### universal configuration
  The Array is directly converted into the GET Request.
  Pro: It's dynamic builded for the future.
  * **So use the key that you want to use as GET-Key as key for the Array and the GET-Value as Array value.**
```PHP
  $configuration = [
     "limit" => 10,
     "sort" => "name",
     "sort_direction" => "ascending",
     "retrieve_after" => "ID of the last paginated item",
     "before" => "YYYY-MM-DD",
     "after" => "YYYY-MM-DD"
  ]
```

  All currently possible possibilities are listed and explained in the following:
  
 ##### Devices / Readings / Packets / Interfaces
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
Configuration of: [Devices](https://docs.element-iot.com/api/resources/devices/) |
Configuration of: [Readings](https://docs.element-iot.com/api/resources/readings/) |
Configuration of: [Packets](https://docs.element-iot.com/api/resources/packets/) |
Configuration of: [Interfaces](https://docs.element-iot.com/api/resources/interfaces/)

##### Tags
```PHP
 $element_iot->get(["tags"]);
#   Returns an array of tags.
#   > configuration
```
Configuration of: [Tags](https://docs.element-iot.com/api/resources/tags/)

##### Parsers
```PHP
 $element_iot->get(["parsers"]);
#   Returns an array of parsers.
#   > configuration
```
 Configuration of: [Parsers](https://docs.element-iot.com/api/resources/parsers/)


##### Drivers
```PHP
 $element_iot->get(["drivers"]); //returns an HTTP 500 Error at the current ELEMENT Version!
#   Returns an array of tags.
#   > configuration

        $element_iot->get(["drivers", "instances"], ["id" => "device_id_requiered"]);
      #    Returns an array of driver instances.
      #    > configuration

```
  Configuration of: [Drivers](https://docs.element-iot.com/api/resources/drivers/) |
  Configuration of: [Driver-Instances](https://docs.element-iot.com/api/resources/driver-instances/)

##### Groups
```PHP
 $element_iot->get(["groups"]);
#   Returns an array of groups.
#   > configuration
```
   Configuration of: [Groups](https://docs.element-iot.com/api/resources/groups/)


##### Api_keys
```PHP
 $element_iot->get(["api_keys"]);
#   Returns an array of api_keys (if you are allowed to see them).
#   > configuration
```
  Configuration of: [Api_keys](https://docs.element-iot.com/api/resources/api-keys/)


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
  Configuration of: [Mandates](https://docs.element-iot.com/api/resources/mandates/) |
  Configuration of: [stats / Statistics](https://docs.element-iot.com/api/resources/stats/)
___

#### set_api_key($api_key)
```PHP
  $element_iot->set_api_key("you_new_api_key");
```
Renew the API Key of an already initialized object.

#### get_api_key()
```PHP
  $element_iot->set_api_key("you_new_api_key");
```
Returns an String with the length of 32 characters, where 24 are *invisible*.
> For Identification if you use it for productiv systems with customers, etc.

#### get_cached_data()
```PHP
  $element_iot->get_cached_data();
```
Returns the answer of the last request. 

#### set_domain($domain)
```PHP
  $element_iot->set_domain("your_new_domain");
```
Sets an new domain.

#### get_domain()
```PHP
  $element_iot->get_domain();
```
Returns the current domain.

### How to Setup anything else?
If you want to setup curl you can do this or other defaults on the attributes in the class or an proxy can also set during the initialization of the object.

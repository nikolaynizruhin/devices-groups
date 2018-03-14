Test task description
===

You have a system with 2 entities: Devices and Groups.

A device represents a physical thing (smartphone, laptop etc) and has the following set of attributes:

* MAC address
* IPv4 address
* Slug (should be unique)
* Human-readable name

A group has the following set of attributes:

* Human-readable name
* Slug (should be unique)

At any given moment a device could be connected only to one group. A group may have unlimited number of devices. 

You will need to create a simple application with API endpoints that cover following operations: 

* CRUD for devices and groups
* Ability to connect/disconnect device to/from a group

---

* Device details request should contain information about the group that it is connected to.
* Group details request should contain list of 5 devices that has been connected to this group recently as well as total number of connected devices.

Submission notes
===

Please create your version of the app in a separate branch and open merge request when you think it's ready.
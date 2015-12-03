# Arme 3 Altis Life WebInterface

## Settings

* `broadcast.*`             _Text_ - global message
* `curl.key`                _String_ - random key http://randomkeygen.com
* `email.receiver`          _Integer_ - ID of User-Account
* `email.{table}_{action}`  _Boolean_ - send email for that type
    * list all types
* `info.*`                  _String_ - dashboard "Serveradressen" uses the key as label
* `licence.{key}`           _String_ - the human translation for this licence
* `system.show`             _Boolean_ - display the system stats on the dashboard for allowed users
* `vehicle.{classname}`     _String_ - the human translation for this vehicle

## Permissions

* `view_database`
* `view_donators`
* `view_gangs`
* `view_players`
* `view_system`
* `view_users`
* `view_vehicles`
* `view_weblog`

* `add_donator`

* `edit_player`
    * `_name`
    * `_playerid`
    * `_adminlevel`
    * `_cash`
    * `_bankacc`
* `edit_gang`
* `edit_user`
* `edit_vehicle`

* `delete_donator`
* `delete_user`
* `delete_vehicle`

* `manage_permissions`
* `manage_roles`
* `manage_settings`

## ToDo

### System

* ~~use gulp - less~~
* ~~update app config - ::class~~
* seeder in migration
* add permissions migration
* use trans function for vehicle & license names
* update frontend to new theme
* artisan command for regular sysload saves

### Refactoring

* Routes
* Auth
* ~~Database~~
    * ~~Controller~~
    * ~~View~~
* DonatorHistory
* Gang
* Home
* Permission
* Player
* Role
* Setting
* System
* User
* Vehicle
* Weblog
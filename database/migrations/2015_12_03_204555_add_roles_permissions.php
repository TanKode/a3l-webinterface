<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesPermissions extends Migration
{
    protected $roles = [
        'super_admin' => [
            'display_name' => 'Super-Administrator',
            'description' => 'Der höchste Rang - kann alles.'
        ],
        'member' => [
            'display_name' => 'Mitglied',
            'description' => 'Der niedrigste Rang - kann quasi nichts.'
        ],
    ];

    protected $permissions = [
        'view_database' => [
            'display_name' => 'Datenbank ansehen',
            'description' => ''
        ],
        'view_donators' => [
            'display_name' => 'Donators ansehen',
            'description' => ''
        ],
        'view_gangs' => [
            'display_name' => 'Gangs ansehen',
            'description' => ''
        ],
        'view_players' => [
            'display_name' => 'Spieler ansehen',
            'description' => ''
        ],
        'view_users' => [
            'display_name' => 'Benutzer ansehen',
            'description' => ''
        ],
        'view_vehicles' => [
            'display_name' => 'Fahrzeuge ansehen',
            'description' => ''
        ],
        'view_weblog' => [
            'display_name' => 'Weblog ansehen',
            'description' => ''
        ],
        'add_donator' => [
            'display_name' => 'Donator hinzufügen',
            'description' => ''
        ],
        'edit_player_name' => [
            'display_name' => 'Spieler Namen bearbeiten',
            'description' => ''
        ],
        'edit_player_playerid' => [
            'display_name' => 'Spieler Spieler-ID bearbeiten',
            'description' => ''
        ],
        'edit_player_adminlevel' => [
            'display_name' => 'Spieler Adminlevel bearbeiten',
            'description' => ''
        ],
        'edit_player_cash' => [
            'display_name' => 'Spieler Bargeld bearbeiten',
            'description' => ''
        ],
        'edit_player_bankacc' => [
            'display_name' => 'Spieler Bankkonto bearbeiten',
            'description' => ''
        ],
        'edit_gang' => [
            'display_name' => 'Gang bearbeiten',
            'description' => ''
        ],
        'edit_user' => [
            'display_name' => 'Benutzer bearbeiten',
            'description' => ''
        ],
        'edit_vehicle' => [
            'display_name' => 'Fahrzeug bearbeiten',
            'description' => ''
        ],
        'delete_donator' => [
            'display_name' => 'Donator löschen',
            'description' => ''
        ],
        'delete_user' => [
            'display_name' => 'Benutzer löschen',
            'description' => ''
        ],
        'delete_vehicle' => [
            'display_name' => 'Fahrzeug löschen',
            'description' => ''
        ],
        'manage_permissions' => [
            'display_name' => 'Berechtigungen verwalten',
            'description' => ''
        ],
        'manage_roles' => [
            'display_name' => 'Rollen verwalten',
            'description' => ''
        ],
        'manage_settings' => [
            'display_name' => 'Einstellungen verwalten',
            'description' => ''
        ],
    ];

    public function up()
    {
        foreach($this->roles as $key => $atts) {
            $role = new \A3LWebInterface\Role();
            $role->name = $key;
            $role->display_name = $atts['display_name'];
            $role->description = $atts['description'];
            $role->save();
        }

        foreach($this->permissions as $key => $atts) {
            $perm = new \A3LWebInterface\Permission();
            $perm->name = $key;
            $perm->display_name = $atts['display_name'];
            $perm->description = $atts['description'];
            $perm->save();
        }
    }

    public function down()
    {
        //
    }

}

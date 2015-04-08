<?php
/**
 * ide: PhpStorm
 * Author: Gummibeer
 * url: https://github.com/Gummibeer
 * package: a3l_admintool
 * since 1.5
 */

return array(
    'cartax' => array(
        true, // active
        array('civ'=>true,'cop'=>false,'med'=>false,'adac'=>false), // active for single sides
        10, // default slots for undefined vehicles
        75, // dollar per slot
        25000, // surcharge for air
        100000, // surcharge for armed
        array('B_MRAP_01_F','O_MRAP_02_F','I_MRAP_03_F'), // armed classnames
    ),
);
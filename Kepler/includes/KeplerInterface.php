<?php 

interface KeplerGetVehicules {
    
    public static function getInstance();

    public static function kepler_get_vehicles() : array;
}
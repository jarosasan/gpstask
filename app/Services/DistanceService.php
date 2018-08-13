<?php
/**
 * Created by PhpStorm.
 * User: jaroslavlomecki
 * Date: 04/08/2018
 * Time: 10:08
 */

namespace App\Services;
use App\Device;
use Illuminate\Support\Facades\DB;


class DistanceService
{
    public function getDistance()
    {
        $device = Device::all();
        $count = $device->count();
        $result['distance']= 0;
        for ($i=0; $i < $count;$i++) {
            for ($j=$i+1; $j < $count; $j++) {
                $item = Device::select('ori.id as from_id',
                    'ori.name as from_name',
                    'dist.id as to_id',
                    'dist.name as to_name',
                    DB::raw("6371 * acos( cos( radians(".$device[$j]->latitude.") ) * cos( radians( ".$device[$i]->latitude." ) ) * cos( radians( ".$device[$i]->longitude." ) - radians(".$device[$j]->longitude.") ) + sin( radians(".$device[$j]->latitude.") ) * sin( radians( ".$device[$i]->latitude." ) ) ) AS distance"))
                    ->from('devices as ori')
                    ->join('devices as dist', function($join){
                        $join->on('ori.id', '<>', 'dist.id');})
                    ->where([['ori.id', '=', $device[$i]->id], ['dist.id', '=', $device[$j]->id]])
                    ->get();
                $r = $item[0];
               if ($result['distance'] < $r->distance){
                   $result = $r;
               }
            }
        }
        return $result;
        }

    public function getDistancePhp()
    {
        $devices = Device::all();
        $count = $devices->count();
        $device['distance']= 0;
        for ($i=0; $i < $count; $i++) {
            for ($j=$i+1; $j < $count; $j++) {
                $earthRadius = 6371;  //  km
                $point1Lat   = $devices[$i]['latitude'];
                $point2Lat   = $devices[$j]['latitude'];
                $deltaLat    = deg2rad( $point2Lat - $point1Lat );
                $point1Long  = $devices[$i]['longitude'];
                $point2Long  = $devices[$j]['longitude'];
                $deltaLong   = deg2rad( $point2Long - $point1Long );
                $a           = sin( $deltaLat / 2 ) * sin( $deltaLat / 2 ) + cos( deg2rad( $point1Lat ) ) * cos( deg2rad( $point2Lat ) ) * sin( $deltaLong / 2 ) * sin( $deltaLong / 2 );
                $c           = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );
                $distance = $earthRadius * $c;

                $result = round($distance, 3, PHP_ROUND_HALF_UP);
                if ($device['distance'] < $result){
                    $device['distance'] = $result;
                    $device['from_name'] = $devices[$i]['name'];
                    $device['to_name'] = $devices[$j]['name'];
                }
                }
            }
        return $device;
    }
}
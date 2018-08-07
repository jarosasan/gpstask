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
            for ($j=$i+1; $j < ($count-$i); $j++) {
                $item = Device::select('ori.id as from_id',
                    'ori.name as from_name',
                    'dist.id as to_id',
                    'dist.name as to_name',
                    DB::raw("ROUND( 6353 * 2 *
                        ASIN(SQRT( POWER(SIN((".$device[$i]->latitude." - abs(".$device[$j]->latitude.")) * pi()/180 / 2),2)
                            + COS(".$device[$i]->latitude." * pi()/180 ) * COS( abs(".$device[$j]->latitude.") *  pi()/180)
                            * POWER(SIN((".$device[$i]->longitude." - ".$device[$j]->longitude.") * pi()/180 / 2), 2) ))
                        , 2) AS distance"))
                    ->from('devices as ori')
                    ->join('devices as dist', function($join){
                        $join->on('ori.id', '<>', 'dist.id');})
                    ->where([['ori.id', '=', $device[$i]->id], ['dist.id', '=', $device[$j]->id]])
                    ->get();
                $r = $item[0];
               if ($result['distance'] < $r['distance']){
                   $result = $r;
               }
            }
        }
        return $result;
        }

}
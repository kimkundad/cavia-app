<?php

namespace App\Imports;

use App\Models\point;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class UsersImport implements ToModel, WithStartRow, WithCustomCsvSettings, WithChunkReading, ShouldQueue
{

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $point_last = DB::table('points')->where('user_key', $row[0])->orderby('id', 'desc')->first();
        $point = 0;
        $get_point = 0;

        $get_userx = User::where('phone', $row[0])->first();
        dd($get_userx);
        $get_user = User::where('phone', $row[0])->count();

        if(isset($point_last)){
        if($point_last->date == $row[1]){
                
        }else{

            $get_point = 0;

            if($get_user > 0){

                $get_point = ($row[2]*(2))/100;

                \DB::table('users')->where('phone', $row[0])->increment('point', $get_point);
                
            }else{

                if($get_user == 0){

                $get_point = ($row[2]*(2))/100;
                $pass = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
                $ran = array("1483537975.png","1483556517.png","1483556686.png");

                $user = User::create([
                    'name' => $row[0],
                    'email' => (\random_int(1000000, 9999999)).'@gmail.com',
                    'password' => Hash::make($pass),
                    'is_admin' => false,
                    'provider' => 'email',
                    'avatar' => $ran[array_rand($ran, 1)],
                    'code_user' => $pass,
                    'phone' => $row[0],
                    'point' => $get_point,
                  ]);

                $user
                ->roles()
                ->attach(Role::where('name', 'user')->first());

                }

            }

        }

        }else{

            $get_point = 0;
            
            if($get_user > 0){

                $get_point = ($row[2]*(2))/100;

                \DB::table('users')->where('phone', $row[0])->increment('point', $get_point);
            }else{

                if($get_user == 0){

                $get_point = ($row[2]*(2))/100;
                $pass = (\random_int(1000, 9999)).''.(\random_int(1000, 9999)).''.(\random_int(10, 99));
                $ran = array("1483537975.png","1483556517.png","1483556686.png");

                $user = User::create([
                    'name' => $row[0],
                    'email' => (\random_int(1000000, 9999999)).'@gmail.com',
                    'password' => Hash::make($pass),
                    'is_admin' => false,
                    'provider' => 'email',
                    'avatar' => $ran[array_rand($ran, 1)],
                    'code_user' => $pass,
                    'phone' => $row[0],
                    'point' => $get_point,
                  ]);

                $user
                ->roles()
                ->attach(Role::where('name', 'user')->first());

                }

            }

            

        }
        


        if(isset($point_last)){

            $point = 0;
            $get_point = 0;

            $point = $point_last->last_point;
            //20
            $get_point = ($row[2]*(2))/100;
            $point = $point + $get_point;

            if($point_last->date == $row[1]){
                
            }else{

                return new point([
                    //
                    'user_key'  => $row[0],
                    'date'  => $row[1],
                    'total_valid_bet_amount'  => $row[2],
                    'point'  => $get_point,
                    'last_point'  => $point,
                ]); 

            }
            
        }else{

            $point = 0;
            $get_point = 0;

            $get_point = ($row[2]*(2))/100;
            $point = $get_point;

            return new point([
                //
                'user_key'  => $row[0],
                'date'  => $row[1],
                'total_valid_bet_amount'  => $row[2],
                'point'  => $get_point,
                'last_point'  => $point,
            ]); 

        }

        
        
        


    }

    public function chunkSize(): int
    {
        return 20;
    }
}

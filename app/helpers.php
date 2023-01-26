<?php

use Illuminate\Support\Facades\DB;

function formatDateThat($strDate)
{
    $strYear = date("j",strtotime($strDate));
   
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("Y",strtotime($strDate)+543);
    return $strDay;
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","January","February","March","April","May","June","July","August","September","October","November","December");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear ";
}

function setting(){

    $cat = DB::table('settings')
          ->where('id', 1)
          ->first();

    return $cat;
  }
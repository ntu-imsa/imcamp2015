<?php

  //身份證字串檢查
  function check_rocid($id) {
    ####################################
    # 文章來源 : http://www.twbb.org
    # 作者 : FIEND (fiend@twbb.org)
    # 信箱 : fiend@twbb.org
    ####################################

     $flag = false;
     $id = strtoupper($id); // 將英文字母全部轉成大寫
     $id_len = strlen($id); // 取得字元長度


     if($id_len <= 0) {
        return false;
        exit;
     }
     if ($id_len > 10) {
        return false;
        exit;
     }
     if ($id_len < 10 && $id_len > 0) {
        return false;
        exit;
     }

     //檢 查 第一個字母是否為英文字
     $id_sub1 = substr($id,0,1); // 從第一個字元開始 取得字串
     $id_sub1 = ord($id_sub1); // 回傳字串的acsii 碼
     if ($id_sub1 > 90 || $id_sub1 < 65) {
        return false;
        exit;
     }

     //檢 查 身份證字號的 第二個字元 男生或女生
     $id_sub2 = substr($id,1,1);

     if($id_sub2 !="1" && $id_sub2 != "2") {
        return false;
        exit;
     }

     for ($i=1;$i<10;$i++) {
        $id_sub3 = substr($id,$i,1);
        $id_sub3 = ord($id_sub3);
        if ($id_sub3 > 57 || $id_sub3 < 48) {
           $n=$i+1;
           return false;
           exit;
        }
     }

     $num=array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",
     "F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",
     "M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",
     "T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",
     "Z" => "33","I" => "34","O" => "35");

     $d1 = substr($id,0,1); // 從第一個字元開始 取得字串
     $n1=substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);
     $n2=0; //初使化
     for ($j=1;$j<9;$j++) {
        $d4=substr($id,$j,1);
        $n2=$n2+$d4*(9-$j);
     }
     $n3=$n1+$n2+substr($id,9,1);
     if(($n3 % 10)!= 0) {
        return false;
        exit;
     }
     return true;

  }
  ?>

<?php

class db
{
      protected $server="localhost";
     protected $user="mehndipvc_u439213217_mehndi_pro2";
     protected $pass="Mehndi@2023$#";
     protected $db="mehndipvc_u439213217_mehndi_pro";
     protected $con;

     public function connect()
     {
     	$this->con=mysqli_connect($this->server,$this->user,$this->pass,$this->db);
     	if($this->con)
     	{
     		//echo "connected";
     	}
     	else
     	{
     		echo "not connected".mysqli_error($con);
     	}
     }
      public function query($sql)
      {
      	$que=mysqli_query($this->con,$sql) or die(mysqli_error($this->con));
      
      	return 1;
      }


      public function row($check)
      {
        $que=mysqli_query($this->con,$check);
        $result=mysqli_num_rows($que);
        return $result;
      }
       public function arr($value)
       {
        $ar=mysqli_query($this->con,$value);
        $result=mysqli_fetch_array($ar);
        return $result;
       }

       public function num($value)
       {
        $ar=mysqli_query($this->con,$value);
        $result=mysqli_num_rows($ar);
        return $result;
       }

       public function fetch($query)
       {
        $abc=array();
        $res=mysqli_query($this->con, $query);
        while($result=mysqli_fetch_assoc($res))
        { 
          $abc[]=$result;
        }
        return $abc;
      }

      //   public function status($postid)
      //   {
      //      $sql="SELECT * FROM user_post WHERE id='$postid' && status='1'";
      //       $result=mysqli_query($this->con,$sql);
      //       if(mysqli_num_rows($result)>0)
      //       {
      //         return 1;
      //       }
      //       else
      //       {
      //         return 0;
      //       }
      //   }

     
    

}

$obj=new db();
$obj->connect();






?>
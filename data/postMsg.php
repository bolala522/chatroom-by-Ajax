<?php
$servername="localhost";
$username="root";
$password="";
$data="jq-chat";
$conn=mysqli_connect($servername,$username,$password,$data);
$sql="SET NAMES UTF8";
mysqli_query($conn,$sql);

if (isset($_REQUEST['username']) and $_REQUEST['content']){
//    提交数据时
    $time=date("Y-m-d H:i:s");
    $username=$_REQUEST['username'];
    $content=$_REQUEST['content'];
    $sql="INSERT INTO message(user,msg,time) VALUES ('$username','$content','$time')";
    $result=mysqli_query($conn,$sql);
    if ($result){
        echo "添加成功";
    }else{
        echo "添加失败";
    }
}else{
//    没有提交数据时
    $result=mysqli_query($conn,"SELECT * FROM message order by id DESC  limit 8");
    if ($result){
        $data=array();//数据数组
        class Info{
            public $id;
            public $user;
            public $msg;
            public $time;
        }
        while ($row=mysqli_fetch_array($result)){
            $user=new Info();//实例化对象
            $user->id=$row['id'];
            $user->user=$row['user'];
            $user->msg=$row['msg'];
            $user->time=$row['time'];
            $data[]=$user;//对象传入数据数组
        }
        $data=json_encode($data);//转为json数据
        echo "$data";
    }else{
        echo "查询失败";
    }
}

?>
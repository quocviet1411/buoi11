<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Đếm lùi ngày sinh nhật</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php
		//kiểm tra số ngày trong tháng
		function demngaytrongthang($m,$y){
			$da = cal_days_in_month(CAL_GREGORIAN, $m, $y);
			return $da;
		}
		//đếm số ngày còn lại
	 	function demngay($d, $m, $y){
			$ngay_sinh_nhat_ke_tiep = mktime(0,0,0,$m,$d,$y); //đổi sang định dạng m/d/y rồi lấy thời gian sinh nhật sắp tới tính bằng đơn vị s 
			//$hom_nay = time(); //lấy thời gian hiện tại tính bắng s 
			$hom_nay=mktime(0,0,0,date('m'),date('d'),date('Y'));
			$hieu_so = ($ngay_sinh_nhat_ke_tiep - $hom_nay); //sô ngày sắp đến sinh nhật tính bằng đơn vị s
			$so_ngay = (int)($hieu_so/86400);  //quy đổi s thành ngày
			return $so_ngay;
		}
		
		if(isset($_POST['check']))
		{
			$date= $_POST['ngay'];
			$month= $_POST['thang'];
			$year= $_POST['nam'];
			$fs_d='';
			$fs_m='';
			$fs_y='';
			if (!is_numeric($month) || $month<1 || $month >12) {
				$fs_m="autofocus";
				$rs="Vui lòng nhập đúng tháng sinh";
			}
			elseif (!is_numeric($year)) {
				$fs_y="autofocus";
				$rs="Vui lòng nhập đúng năm sinh";
			}
			elseif ($year<1820) {
				$rs="Chắc giờ bạn đã chết rồi nên không cần sinh nhật đâu !!";
			}
			elseif($year>date('Y')){
				$rs="Bạn còn chưa được sinh ra!!";
			}
			elseif(!is_numeric($date) || $date> demngaytrongthang($month,$year) || $date<1 || $date>31)
			{
				$fs_d="autofocus";
				$rs="Vui lòng nhập đúng ngày sinh";
			}
			else
			{
				$da=demngay($date,$month,date('Y'));
				if($da<0)
				{
					$da=demngay($date,$month,date('Y')+1);
				}
				if($da==0)
					$rs="Hôm nay là sinh nhật bạn rồi";
				else
					$rs="Còn $da ngày nữa là đến sinh nhật bạn rồi !!";
			}
			

		}
		echo @$rs;
	 ?>
	<form action="" method="post" accept-charset="utf-8">
		<input type="text" name="ngay" <?php echo @$fs_d ?> placeholder="Nhập ngày sinh" value="<?php echo @$date ?>">
		<input type="text" name="thang" <?php echo @$fs_m ?> placeholder="Nhập tháng sinh" value="<?php echo @$month ?>">
		<input type="text" name="nam" <?php echo @$fs_y ?> placeholder="Nhập năm sinh" value="<?php echo @$year ?>">
		<button type="submit" name="check"> Check</button>
	</form>
</body>
</html>
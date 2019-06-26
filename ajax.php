<?php
          session_start();      
        include("manage-ad/config.php");
        date_default_timezone_set('Asia/Calcutta');        
		if($_GET['f']=="get_city")
		{
				get_city();
		}
		if($_GET['f']=="update_financier_viewed")
		{
				update_financier_viewed();
		}
		if($_GET['f']=="update_borrower_viewed")
		{
				update_borrower_viewed();
		}
		if($_GET['f']=="update_student_borrower_viewed")
		{
				update_student_borrower_viewed();
		}
		if($_GET['f']=="update_student_financier_viewed")
		{
				update_student_financier_viewed();
		}
		if($_GET['f']=="deactivate_financier")
		{
				deactivate_financier();
		}
		if($_GET['f']=="activate_financier")
		{
				activate_financier();
		}
		if($_GET['f']=="activate_borrower")
		{
				activate_borrower();
		}
		if($_GET['f']=="deactivate_borrower")
		{
				deactivate_borrower();
		}
		if($_GET['f']=="deactivate_borrower")
		{
				deactivate_borrower();
		}
		if($_GET['f']=="activate_student_borrower")
		{
				activate_student_borrower();
		}
		if($_GET['f']=="deactivate_student_borrower")
		{
				deactivate_student_borrower();
		}
		if($_GET['f']=="activate_student_financier")
		{
				activate_student_financier();
		}
		if($_GET['f']=="deactivate_student_financier")
		{
				deactivate_student_financier();
		}
		if($_GET['f']=="remove_document_financier")
		{
				remove_document_financier();
		}
		if($_GET['f']=="remove_document_borrower")
		{
				remove_document_borrower();
		}
		if($_GET['f']=="remove_student_borrower_document")
		{
				remove_student_borrower_document();
		}
		if($_GET['f']=="remove_document_student_financier")
		{
				remove_document_student_financier();
		}
		function get_city()
		{
			$state=$_POST['state'];
			echo '<option value="">Select City</option>';
			echo "select * from cities where city_state='$state'";
			$sql=mysql_query("select * from cities where city_state='$state'");
			while($row=mysql_fetch_array($sql))
			{
				echo '<option value="'.$row['id'].'">'.$row['city_name'].'</option>';
			}
		}
		function update_financier_viewed()
		{
			$user_id=$_SESSION['user_id'];
			$finan_id=$_POST['finan_id'];
			$qry=mysql_query("select * from viewed_financiers where user_id='$user_id' and financier_id='$finan_id'");
			$res=mysql_fetch_array($qry);
			$count=mysql_num_rows($qry);
			if($count<1)
			{
				$sql=mysql_query("INSERT INTO viewed_financiers (user_id,financier_id,times) VALUES ('$user_id', '$finan_id', '1')");
			}
			else
			{
				$times=$res['times'];
				$total_time=$times+1;
				$sql=mysql_query("update viewed_financiers set times='$total_time' where user_id='$user_id' and financier_id='$finan_id'");
			}
		}
		function update_student_financier_viewed()
		{
			$user_id=$_SESSION['user_id'];
			$finan_id=$_POST['finan_id'];
			$qry=mysql_query("select * from viewed_student_financiers where user_id='$user_id' and financier_id='$finan_id'");
			$res=mysql_fetch_array($qry);
			$count=mysql_num_rows($qry);
			if($count<1)
			{
				$sql=mysql_query("INSERT INTO viewed_student_financiers (user_id,financier_id,times) VALUES ('$user_id', '$finan_id', '1')");
			}
			else
			{
				$times=$res['times'];
				$total_time=$times+1;
				$sql=mysql_query("update viewed_student_financiers set times='$total_time' where user_id='$user_id' and financier_id='$finan_id'");
			}
		}
		function update_borrower_viewed()
		{
			$user_id=$_SESSION['user_id'];
			$borrow_id=$_POST['borrow_id'];
			$qry=mysql_query("select * from viewed_borrowers where user_id='$user_id' and borrower_id='$borrow_id'");
			$res=mysql_fetch_array($qry);
			$count=mysql_num_rows($qry);
			if($count<1)
			{
				$sql=mysql_query("INSERT INTO viewed_borrowers (user_id,borrower_id,times) VALUES ('$user_id', '$borrow_id', '1')");
			}
			else
			{
				$times=$res['times'];
				$total_time=$times+1;
				$sql=mysql_query("update viewed_borrowers set times='$total_time' where user_id='$user_id' and borrower_id='$borrow_id'");
			}
		}
		function update_student_borrower_viewed()
		{
			$user_id=$_SESSION['user_id'];
			$borrow_id=$_POST['borrow_id'];
			$qry=mysql_query("select * from viewed_student_borrowers where user_id='$user_id' and borrower_id='$borrow_id'");
			$res=mysql_fetch_array($qry);
			$count=mysql_num_rows($qry);
			if($count<1)
			{
				$sql=mysql_query("INSERT INTO viewed_student_borrowers (user_id,borrower_id,times) VALUES ('$user_id', '$borrow_id', '1')");
			}
			else
			{
				$times=$res['times'];
				$total_time=$times+1;
				$sql=mysql_query("update viewed_student_borrowers set times='$total_time' where user_id='$user_id' and borrower_id='$borrow_id'");
			}
		}
		function deactivate_financier()
		{
			$id=$_POST['id'];
			
			$qry1=mysql_query("update financiers set active_status='2' where id='$id'");
			session_unset();
		}
		function activate_financier()
		{
			$id=$_POST['id'];
			
			$qry1=mysql_query("update financiers set active_status='0' where id='$id'");
		}
		function deactivate_borrower()
		{
			$id=$_POST['id'];
			
			$qry1=mysql_query("update borrower set active_status='2' where id='$id'");
			session_unset();
		}
		function activate_borrower()
		{
			$id=$_POST['id'];
			
			$qry1=mysql_query("update borrower set active_status='0' where id='$id'");
		}
		function activate_student_borrower()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("update student_borrower set active_status='0' where id='$id'");
		}
		function deactivate_student_borrower()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("update student_borrower set active_status='2' where id='$id'");
			session_unset();
		}
		function activate_student_financier()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("update student_financiers set active_status='0' where id='$id'");
		}
		function deactivate_student_financier()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("update student_financiers set active_status='2' where id='$id'");
			session_unset();
		}
		
		
		
		function remove_document_financier()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("delete from financier_documents where id='$id'");
		}
		function remove_document_borrower()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("delete from borrower_documents where id='$id'");
		}
		function remove_student_borrower_document()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("delete from student_borrower_documents where id='$id'");
		}
		function remove_document_student_financier()
		{
			$id=$_POST['id'];
			$qry1=mysql_query("delete from student_financier_documents where id='$id'");
		}
?>

<?php
class Pager
{
	function findStart($limit)
	{
		if((!isset($_GET['page']))  || ($_GET['page']=="1"))
		{
			$start = 0;
			$_GET['page'] = 1 ;
		}
		else
		{
			$start = ($_GET['page'] - 1) * $limit;
		}
		return $start;
	}
	
	function findPages($count, $limit)  
	{
		$pages = (($count % $limit)== 0) ? $count / $limit : floor($count / $limit) + 1;
		return $pages;
	}
	
	function pageList ($curPage, $pages,  $param=NULL)
	{
		$ma_khoa_hoc = " Khóa LTrinh PHP ";
		$page_list = "";
		if(($curPage !=1) &&($curPage))
		{
			$page_list .= "<a href = \"".$_SERVER['PHP_SELF']."?"."page=1$param\" title=\"Trang đầu\">First |</a>";
		}
		if(($curPage - 1) >0)
		{
			$page_list .= "<a href = \"".$_SERVER['PHP_SELF']."?"."page=".($curPage-1)."$param\" title=\"Về trang trước\"> Previous | </a>";	
		}
		$vtdau = max($curPage-2,1);
		$vtcuoi = min($curPage+2,$pages);
		
		for($i = $vtdau; $i <= $vtcuoi; $i ++)
		{
			if($i == $curPage)
			{
				$page_list .= "<span>".$i."</span>";
			}
			else
			{
				$page_list .= "<a href='".$_SERVER['PHP_SELF']."?"."page=".$i."$param 'title = 'Trang ".$i."'>".$i."</a>";
			}
		}
		
		if($curPage + 1 <= $pages)
		{
			$page_list.= "<a href =\"".$_SERVER['PHP_SELF']."?"."page=".($curPage+1)."$param\" title=\"Đến trang sau\">| Next  </a>";
			$page_list.= "<a href =\"".$_SERVER['PHP_SELF']."?"."page=".$pages."$param\" title=\"Đến trang cuối\"> | Last</a>";
		}
		return $page_list;
	}
	
	function nextPrev($curpage, $pages) // Hiển thị 2 nút trước sau
	{
		$next_prev = "";
		if($curpage-1<0)
		{
			$next_prev .= "Về trang trước";
		}
		else
		{
			$next_prev.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\">Về trang trước</a>"; 
		}
		$next_prev .="  |  ";
		if(($curpage + 1)>$pages)
		{
			$next_prev .= "Đến trang sau";
		}
		else
		{
			$next_prev.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\">Đến trang sau</a>"; 
		}
		return $next_prev;
	}
	
	// bootstrap
	public function pageListBootstrap($curPage, $totalPages) {
		$output = '';
		if ($totalPages > 1) {
			$output .= '<li class="page-item"><a class="page-link" href="?page=1">&laquo;</a></li>';
			for ($i = 1; $i <= $totalPages; $i++) {
				if ($i == $curPage) {
					$output .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
				} else {
					$output .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
				}
			}
			$output .= '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '">&raquo;</a></li>';
		}
		return $output;
	}
	
}

?>
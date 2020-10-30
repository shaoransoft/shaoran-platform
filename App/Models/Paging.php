<?php
/* Shaoran web application framework 5 */
class Paging
{
  private $html = '';
  private $totalRows = 0;
  private $limitRows = 30;
  private $limitNumPageBtn = 5;
  private $firstPageBtn = true;
  private $lastPageBtn = true;
  private $firstPageBtnLabel = "&laquo;";
  private $lastPageBtnLabel = "&raquo;";
  private $prevPageBtnLabel = "&lsaquo;";
  private $nextPageBtnLabel = "&rsaquo;";
  private $pagingContainStyle = ['pagination', 'justify-content-center'];
  private $pagingItemStyle = ['page-item'];
  private $pagingLinkStyle = ['page-link'];

  public function SetTotalRows($totalRows = 0) {
    $this->totalRows = $totalRows;
  }

  public function SetPaging($option = []) {
    if (isset($option['LimitRows'])) $this->limitRows = $option['LimitRows'];
    if (isset($option['FirstPageBtn'])) $this->firstPageBtn = ($option['FirstPageBtn']);
    if (isset($option['LastPageBtn'])) $this->lastPageBtn = ($option['LastPageBtn']);
    if (isset($option['Label'])) {
      foreach ($option['Label'] as $k => $v) {
        switch ($k) {
          case 'FirstPage':
            $this->firstPageBtnLabel = $v;
            break;
          case 'LastPage':
            $this->lastPageBtnLabel = $v;
            break;
          case 'NextPage':
            $this->nextPageBtnLabel = $v;
            break;
          case 'PrevPage':
            $this->prevPageBtnLabel = $v;
            break;
        }
      }
    }
    if (isset($option['Style'])) {
      $this->pagingContainStyle = array_merge($this->pagingContainStyle, $this->FindVal('Pagination', $option));
      $this->pagingItemStyle = array_merge($this->pagingItemStyle, $this->FindVal('PagingItem', $option));
      $this->pagingLinkStyle = array_merge($this->pagingLinkStyle, $this->FindVal('PagingLink', $option));
    }
    $this->CreatePaging();
  }

  public function GetPaging() { return $this->html; }

  public function GetCurrentPage() { return (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1; }

  private function CreatePaging() {
    $currentPage = $this->GetCurrentPage();
    $totalPage = ceil($this->totalRows / $this->limitRows);
    $half = ceil($this->limitNumPageBtn / 2);
    $pagingItemStyle = join(' ', $this->pagingItemStyle);
    $pagingLinkStyle = join(' ', $this->pagingLinkStyle);
    $this->html .= '<ul class="'.join(' ', $this->pagingContainStyle).'">';

    // first page btn
    if ($this->firstPageBtn) {
      $this->html .= '<li class="'.$pagingItemStyle.' '.($currentPage == 1 ? 'disabled' : null).'">';
      $this->html .= '<a class="'.$pagingLinkStyle.'" href="'.$this->SetHref(1).'">'.$this->firstPageBtnLabel.'</a>';
      $this->html .= '</li>';
    }

    // prev page btn
    $this->html .= '<li class="'.$pagingItemStyle.' '.($currentPage == 1 ? 'disabled' : null).'">';
    $this->html .= '<a class="'.$pagingLinkStyle.'" href="'.$this->SetHref($currentPage - 1).'">'.$this->prevPageBtnLabel.'</a>';
    $this->html .= '</li>';

    // num page btn
    if (ceil($totalPage / $this->limitNumPageBtn) > 1) {
      if ($currentPage <= $half) {
        for ($i = $half; $i > 0; $i--) {
          if ($currentPage - $i <= $half) {
            $startNum = $i;
            $endNum = ($this->limitNumPageBtn + 1) - $i;
          }
        }
      }
      else if ($totalPage - $currentPage < $half) {
        for ($i = $currentPage; $i <= $totalPage; $i++) {
          if ($currentPage - $i < $half) {
            $startNum = $i - ($this->limitNumPageBtn - 1);
            $endNum = $i;
          }
        }
      }
      else {
        $startNum = $currentPage - ($half - 1);
        $endNum = $currentPage + $half;
      }
    }
    else {
      $startNum = 1;
      $endNum = $totalPage;
    }
    for ($i = $startNum; $i <= $endNum; $i++) {
      $this->html .= '<li class="'.$pagingItemStyle.' '.((int)$i == $currentPage ? 'active' : null).'">';
      $this->html .= '<a class="'.$pagingLinkStyle.'" href="'.$this->SetHref((int)$i).'">'.($i > 3 && $i == $startNum ? '..' : (int)$i).'</a>';
      $this->html .= '</li>';
    }

    // next page btn
    $this->html .= '<li class="'.$pagingItemStyle.' '.($currentPage == $totalPage ? 'disabled' : null).'">';
    $this->html .= '<a class="'.$pagingLinkStyle.'" href="'.$this->SetHref($currentPage + 1).'">'.$this->nextPageBtnLabel.'</a>';
    $this->html .= '</li>';

    // last page btn
    if ($this->lastPageBtn) {
      $this->html .= '<li class="'.$pagingItemStyle.' '.($currentPage == $totalPage ? 'disabled' : null).'">';
      $this->html .= '<a class="'.$pagingLinkStyle.'" href="'.$this->SetHref($totalPage).'">'.$this->lastPageBtnLabel.'</a>';
      $this->html .= '</li>';
    }
    $this->html .= '</ul>';
  }

  private function SetHref($page) {
    $url = $_SERVER['REQUEST_URI'];
    return isset($_GET['page']) ? str_replace('page='.$_GET['page'], 'page='.$page, $url) : $url.(count($_GET) > 1 ? '&' : '?').'page='.$page;
  }

  private function FindVal($key = null, $opt = []) {
    $val = [];
    if ($key != null && count($opt) > 0) {
      foreach ($opt as $k => $v) {
        if (strtolower($key) != strtolower($k) && is_array($v)) $val = $this->FindVal($key, $v);
        else if (strtolower($key) != strtolower($k)) continue;
        else {
          $val = is_array($v) ? $v : [$v];
          break;
        }
      }
    }
    return $val;
  }
}
?>

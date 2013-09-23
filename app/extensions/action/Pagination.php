<?php
namespace app\extensions\action;
use lithium\action\DispatchException;

class Pagination extends \lithium\action\Controller{

  public function __construct($mongoHandler, $currentURL = false) {
    global $var;

    $this->mongoHandler = $mongoHandler;
    $this->currentURL   = $currentURL;
  }

  public function setQuery($queryParam, $currentpage = 1, $itemsPerPage = false) {
    global $var;

    $this->query = $queryParam;
    if(!empty($currentpage) && is_numeric($currentpage) && empty($itemsPerPage)) {
      $this->limitResult = $currentpage;
    }
    else {
      $this->currentpage = $currentpage;
      $this->itemsPerPage = $itemsPerPage;
    }
    return true;
  }

  /**
   * 	Paginate MongoResults
   */
  public function Paginate() {
    global $var;

    $collection = (!empty($this->query['#collection']))?$this->query['#collection']:die('MongoPagination: no collection found');
    $find = (!empty($this->query['#find']))?$this->query['#find']:array();
    $sort = (!empty($this->query['#sort']))?$this->query['#sort']:array();

    //  Get total results count
    $this->totalItemCount = $this->mongoHandler->$collection->find($find)->count();

    /*	Enable Limit based Query	*/
    if(!empty($this->limitResult)) {
      $resultSet = $this->mongoHandler->$collection->find($find)
      ->sort($sort)
      ->limit($this->limitResult);
      return array(
        'dataset'		=>    iterator_to_array($resultSet),
        'totalItems'	=>    $this->totalItemCount
      );
    }
    /*	Enable Pagination based Query	*/
    else {
      $resultSet = $this->mongoHandler->$collection->find($find)
      ->sort($sort)
      ->limit($this->itemsPerPage)
      ->skip($this->itemsPerPage * ($this->currentpage-1));
      $this->totalPages = floor($this->totalItemCount / $this->itemsPerPage);
      return array(
        'dataset'		=>    iterator_to_array($resultSet),
        'totalPages'	=>    $this->totalPages,
        'totalItems'	=>    $this->totalItemCount
      );
    }
  }

  /**
   * 	Generate HTML Based Page Links
   */
  public function getPageLinks($setVisiblePagelinkCount = 3, $type = 'HTML') {
    global $var;

    $html = '';
    if($this->totalPages <= 1) {
      return $html;
    }

    $html = '<div class="pagination"><ul>';
    if(1 != $this->currentpage) {
      $html .= '<li><a href="'.$this->preparePageLink($this->currentpage - 1).'">&laquo; Previous</a></li>';
    }
    $VisiblePagelinkCount = 1;
    for($i=$this->currentpage; $i <= $this->totalPages+1; $i++) {
      if($VisiblePagelinkCount <= $setVisiblePagelinkCount) {
        if($this->currentpage == $i) {
          $html .= '<li><a class="active " href="'.$this->preparePageLink($i).'">'.$i.'</a></li>';
        }
        else {
          $html .= '<li><a href="'.$this->preparePageLink($i).'">'.$i.'</a></li>';
        }
      }
      $VisiblePagelinkCount++;
    }    
    if($this->totalPages != $this->currentpage) {
      $html .= '<li><a href="'.$this->preparePageLink($this->currentpage + 1).'">Next &raquo;</a></li>';
    }
    $html .= '</ul></div>';
    
    /*
    $html = '<div class="MongoPagination">';
    $html .= '<span><a href="'.$this->currentURL.'/'.$i.'">First</a></span>';
    $VisiblePagelinkCount = 1;
    for($i=1; $i <= $this->totalPages; $i++) {
      if($VisiblePagelinkCount <= $setVisiblePagelinkCount) {
        $html .= '<span><a href="'.$this->currentURL.'/'.$i.'">'.$i.'</a></span>';
      }
      $VisiblePagelinkCount++;
    }

    $html .= '<span><a href="'.$this->currentURL.'/'.$i.'">Last</a></span>';
    $html .= '</div>';
	*/
    
    return $html;
  }
  
  private function preparePageLink($currentPageIndex = 1) {
    global $var;
    $pageUrl = $this->currentURL;
    if(false === stristr($this->currentURL, '{{PAGE}}')) {
      $pageUrl = $this->currentURL.'/'.$i;
    }
    else {
      $pageUrl = str_ireplace('{{PAGE}}', $currentPageIndex, $this->currentURL);
    }
    
    return $pageUrl;
  }
}
?>